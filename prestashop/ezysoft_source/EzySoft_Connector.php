<?php


require_once _PS_MODULE_DIR_.'ezysoft_source/classes/ezySoftLogs.php';
require_once _PS_MODULE_DIR_.'ezysoft_source/src/RestApiHandler.php';
require_once _PS_MODULE_DIR_.'ezysoft_source/src/DatabaseQueryHelper.php';

class EzySoft_Connector
{

    const DOMAIN_URL_API ='http://127.0.0.1:8000';


    public static function updateOrCreateProduct($id_product, $id_lang) {


        $product               = new Product($id_product, null,$id_lang);
        $images                = DatabaseQueryHelper::getImages($product->getImages($id_lang),$product->name);
        $features              = DatabaseQueryHelper::getFeatures($product->getFeatures());
        $manufacturer          = DatabaseQueryHelper::getManufacturer($product->id_manufacturer);
        $categories            = DatabaseQueryHelper::getCategories($product->getCategories(),$id_lang);

        $default_category_name = DatabaseQueryHelper::getCategoryName($product->id_category_default,$id_lang);

        $params = [
            'id_source'         => $product->id,
            'reference'         => $product->reference,
            'price'             => $product->price,
            'mpn'               => $product->mpn,
            'ean'               => $product->ean13,
            'name'              => $product->name,
            'description'       => $product->description,
            'description_short' => $product->description_short,
            'id_lang'           => $id_lang,
            'manufacturer'      => (!$manufacturer) ? '' : $manufacturer,
            'images'            => (isset($images['images'])) ? json_encode($images['images']) : '',
            'default_image'     => (isset($images['cover'])) ? $images['cover'] :  '',
            'user_id'             => Configuration::get('EZYSOFT_SOURCE_STORE_ID'),
            'category_full_path'  => (empty($categories)) ? null : $categories,
            'id_category_default'   => $product->id_category_default,
            'quantity'          => Product::getQuantity($id_product),
            'skroutz_price'     => (isset($product->skroutz_price)) ? $product->skroutz_price : 0,
            'shopflix_price'    => (isset($product->shopflix_price)) ? $product->shopflix_price : 0,
            'available_now'     => $product->available_now,
            'wholesale_price'   => $product->wholesale_price,
            'meta_description'  => $product->meta_description,
            'meta_title'        => $product->meta_title,
            'features'          => ($features) ? json_encode($features) : null,
            'active'            => $product->active,
            'category_name_default' => $default_category_name,
            'categories_ids' => ($product->getCategories()) ? json_encode($product->getCategories()) : [],
            'has_image' => ($product->getImages($id_lang)) ? true : false,
            'has_features' => ($product->getFeatures()) ? true : false,
        ];

        $RestApiHandler = new RestApiHandler('http://127.0.0.1:8000','v1');
        $response = $RestApiHandler->post('product/store',$params);
      
        self::setLog($response);

    }


    /**
     * @param $id_product
     * @return void
     * @throws Exception
     */
    public static function toDeleteList($id_product)
    {

        $RestApiHandler = new RestApiHandler(self::DOMAIN_URL_API,'v1');
        $params = [
            'id_source' => $id_product,
            'user_id' => Configuration::get('EZYSOFT_SOURCE_STORE_ID')
        ];
        $inDatabase = $RestApiHandler->post('product/exist',$params);
        if (isset($inDatabase['response']['status'])
            && $inDatabase['response']['status'])
        {
            $response = $RestApiHandler->post('product/delete',$params);
            self::setLog($response);
        }
    }


    public static function setLog($response, $custom_id=false)
    {

        $log = new ezySoftLogs();
        $log->id_entry = ($custom_id) ? $custom_id : $response['response']['id'];
        $log->table = $response['response']['type'];
        $log->action = $response['response']['action'];
        $log->response_status = $response['code'];
        $log->message = $response['response']['message'];
        $log->status = $response['response']['status'];
        if (!$log->save()){
            return false;
        }
        return true;
    }

    public static function updateOrCreateOrder($object) {

        if (Configuration::get('EZYSOFT_SEND_ORDER_AND_CUSTOMER')) {
            $customer = new Customer($object->id_customer);
            $addresses = $customer->getAddresses(Configuration::get('EZYSOFT_SOURCE_ID_LANG'));
            $address = new Address($object->id_address_delivery);
            $params = [
                'customer' => [
                    'email' => $customer->email,
                    'id_source' => $customer->id,
                    'firstname' => $customer->firstname,
                    'lastname' => $customer->lastname,
                    'address' => $address->address1,
                    'postcode' => $address->postcode,
                    'phone' => $address->phone,
                    'mobile' => $address->phone_mobile,
                    'city' => $address->city,
                    'user_id' => Configuration::get('EZYSOFT_SOURCE_STORE_ID'),
                    'addresses' => json_encode($addresses),
                    'object' => json_encode($customer)
                ],
                'order' => [
                    'id_source' => $object->id,
                    'user_id' => Configuration::get('EZYSOFT_SOURCE_STORE_ID'),
                    'product_list' => json_encode($object->product_list),
                    'reference' => $object->reference,
                    'payment' => $object->payment,
                    'customer_id' => $object->customer_id,
                    'carrier' => DatabaseQueryHelper::getCarrier($object->id_carrier),
                    'id_carrier' => $object->id_carrier,
                    'total_paid' => $object->total_paid,
                    'total_paid_tax_incl' => $object->total_paid_tax_incl,
                    'total_paid_tax_excl' => $object->total_paid_tax_excl,
                    'total_paid_real' => $object->total_paid_real,
                    'total_products' => $object->total_products,
                    'total_shipping' => $object->total_shipping,
                    'codfee' => 1,
                    'voucher' => null,
                    'order_object' => json_encode($object),
                    'histories' => ($object->getHistory) ? $object - json_encode($object->getHistory(Configuration::get('EZYSOFT_SOURCE_ID_LANG'))) : null,
                    'order_payments' => ($object->getOrderPayments()) ? json_encode($object->getOrderPayments()) : null,
                    'invoices_collection' => ($object->getInvoicesCollection()) ? json_encode($object->getInvoicesCollection()) : null,
                    'order_details_list' => ($object->getOrderDetailList()) ? json_encode($object->getOrderDetailList()) : null,
                    'message' => (!empty($object->getFirstMessage())) ? $object->getFirstMessage() : '',
                    'note' => (!empty($object->note)) ? $object->note : '',
                    'current_state' => ($object->getCurrentState()) ? $object->getCurrentState() : 0,
                ],
            ];

            $RestApiHandler = new RestApiHandler('http://127.0.0.1:8000', 'v1');
            $order = $RestApiHandler->post('order/store', $params);
            self::setLog($order, $object->id);
        }

        if (Configuration::get('EZYSOFT_UPD_QTY_ORDER')) {

            $products = $object->product_list;
            $params = self::newQuantities($products);
            $quantity =  $RestApiHandler->post('product/quantity', $params);



            self::setLog($quantity);
        }



    }

    private static function newQuantities($products)
    {
        $quantities = [];
        foreach ($products as $product){
            $quantities[] = [
                'id_source' => $product['id_product'],
                'quantity'   => $product['quantity_available'] - $product['cart_quantity'],
            ];
        }

        return $quantities;
    }

    public static function excludeEzySoft($id_product)
    {
        $RestApiHandler = new RestApiHandler(self::DOMAIN_URL_API,'v1');
        $params = [
            'id_source' => $id_product,
            'user_id'   => Configuration::get('EZYSOFT_SOURCE_STORE_ID')
        ];
//        $inDatabase = $RestApiHandler->post('product/exist',$params);
//        if (isset($inDatabase['response']['status'])
//            && $inDatabase['response']['status'])
//        {
            $response = $RestApiHandler->post('product/exclude',$params);
            self::setLog($response);
        //}
    }

    public static function changeStatus($ob){
        $RestApiHandler = new RestApiHandler(self::DOMAIN_URL_API,'v1');
        $params = [
            'id_source' => $ob->id,
            'user_id'   => Configuration::get('EZYSOFT_SOURCE_STORE_ID'),
            'active'    => $ob->active
        ];
        $response = $RestApiHandler->post('product/status',$params);


        self::setLog($response);
    }
}