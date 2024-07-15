<?php
/**
 * 2024 ezySoft
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    codepresta.com <hello@codepresta.com>
 *  @copyright 2024 ezySoft.gr
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 *  @version   1.0.0
 *  @created   14 July 2024
 *  @last updated 14 July 2024
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_.'ezysoft/classes/ezySoftRecords.php';
class DataCollector
{

    protected $delimiter = '-';
    protected $charMap = array(
        '©' => '(c)',
        'Α' => 'A', 'Β' => 'V', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'I', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'U', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'O',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'U', 'Ή' => 'I', 'Ώ' => 'O', 'Ϊ' => 'I',
        'Ϋ' => 'I',
        'α' => 'a', 'β' => 'v', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'i', 'θ' => 'th',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => 'ks', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'u', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'o',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'u', 'ή' => 'i', 'ώ' => 'o', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'u', 'ϋ' => 'u', 'ΐ' => 'i',
    );
    public $item;
    public $id_product;
    public $id_source;
    public $api_response_status;
    public $external;

    public function __construct($item)
    {
        $this->item = $item;
    }


    public function setExternal($ex)
    {
        $this->external = $ex;
    }

    public function getExternal()
    {
        return $this->external;
    }
    public function setIdSource($id_source)
    {
        $this->id_source = $id_source;
    }

    public function getIdSource()
    {
        return $this->id_source;
    }

    public function setApiResponseStatus($status)
    {
        $this->api_response_status = $status;
    }
    public function getApiResponseStatus()
    {
        return $this->api_response_status;
    }

    public  function toList()
    {
        $date =   date("Y-m-d H:i:s");;
        $params = [
            'id_product' => $this->getIdProduct(),
            'id_source' => $this->getIdSource(),
            'status' => $this->getApiResponseStatus()['status'],
            'external' => $this->getExternal(),
            'date_add' => $date
        ];
        Db::getInstance()->insert('ezysoft', $params);


        return  Db::getInstance()->Insert_ID();
    }

    public function setIdProduct($id_product)
    {
        $this->id_product = $id_product;
    }

    public function getIdProduct()
    {
        return $this->id_product;
    }


    public  function toPrestashop($id=false)
    {



        $product                        = new Product($id, null, Context::getContext()->language->id);
        $product->name                  = $this->item['name'];
        $product->link_rewrite          = $this->generate_link_rewrite_greeklish($this->item['name'], true);
        $product->price                 = ($this->item['price']) ? $this->item['price'] : 0;
        $product->wholesale_price       = ($this->item['wholesale_price']) ? $this->item['wholesale_price'] :0;
        $product->id_tax_rules_group    = false;
        $product->active                = $this->item['active'];
        if (!empty($this->item['mpn'])){
            if (Validate::isMpn($this->item['mpn'])){
                $product->mpn = $this->item['mpn'];
            }
        }

        if (!empty($this->item['ean'])) {
            if (Validate::isEan13($this->item['ean']))
            {

                $product->ean13 = $this->item['ean'];
            }
        }

        if (!empty($this->item['manufacturer'])){
            $product->id_manufacturer = $this->addManufacturer($this->item['manufacturer']);
        }else{
            $product->id_manufacturer = false;
        }


        if (!empty($this->item['description_short'])){
            $product->description_short = $this->item['description_short'];
        }

        if (!empty($this->item['description']))
        {
            $product->description = $this->item['description'];
        }

        if(!$product->save()) {
            return false;
        }

        if (!$id) {


            if (!empty($this->item['category_full_path'])) {
                $product->deleteCategories();
                $categories = explode('|', $this->item['category_full_path']);
                $mapCategories = call_user_func_array('array_merge', $this->mapCategories($categories));
                $id_category_default = reset($mapCategories);
                $product->id_category_default = $id_category_default;
                $product->addToCategories($mapCategories);
            }else{
                $product->deleteCategories();
                $product->id_category_default = Configuration::get('EZYSOFT_DEFAULT_CATEGORY');
                $product->addToCategories([Configuration::get('EZYSOFT_DEFAULT_CATEGORY')]);
            }
        }


        $product->reference = Configuration::get('EZYSOFT_SKU_PREFIX').$product->id;
        if (!$product->update()) {
            return  false;
        }

        // no update image
        if (!$id)
        {
            if ($this->item['has_image'])
            {
                if (!empty($this->item['default_image'])) {
                    $this->addImage($this->item['default_image'], $product->id, true);
                }
                if (!empty($this->item['images'])) {
                    $images_array = json_decode($this->item['images'], true);
                    if (count($images_array)) {
                        foreach ($images_array as $image) {
                            $this->addImage($image, $product->id, false);
                        }
                    }
                }
            }
        }else
        {
            $this->deleteImages($product->id);
            $product->deleteImages();
            if ($this->item['has_image'])
            {
                if (!empty($this->item['default_image'])) {
                    $this->addImage($this->item['default_image'], $product->id, true);
                }
                if (!empty($this->item['images'])) {
                    $images_array = json_decode($this->item['images'], true);
                    if (count($images_array)) {
                        foreach ($images_array as $image) {
                            $this->addImage($image, $product->id, false);
                        }
                    }
                }
            }
        }
        if ($this->item['has_features']){
            if (!$id){
                if (!empty($this->item['features'])) {
                    $features = json_decode($this->item['features'], true);
                    $this->createProductFeatures($features, $product);
                }
            }else{
                $deleted = $product->deleteProductFeatures();
                if ($deleted){
                    if (!empty($this->item['features'])){
                        $features = json_decode($this->item['features'], true);
                        $this->createProductFeatures($features, $product);
                    }
                }
            }
        }else{
            $product->deleteProductFeatures();
        }

        $this->addStockAvailableQty($product->id,$this->item['quantity']);
        return  $this->setIdProduct($product->id);
    }

    public function deleteImages($id_product)
    {
        $images = Image::getImages(Configuration::get('PS_LANG_DEFAULT'), $id_product);

        foreach ($images as $image) {
            $imageObj = new Image($image['id_image']);
            $imagePath = _PS_IMG_DIR_ . 'p/' . $imageObj->getExistingImgPath() . '.jpg';
            $imageTypes = ImageType::getImagesTypes('products');

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            foreach ($imageTypes as $imageType) {
                $thumbPath = _PS_IMG_DIR_ . 'p/' . $imageObj->getExistingImgPath() . '-' . stripslashes($imageType['name']) . '.jpg';
                if (file_exists($thumbPath)) {
                    unlink($thumbPath);
                }
            }
        }
    }

    public function mapCategories($categories)
    {
        $cate = [];
        foreach ($categories as $category) {
            $cate[] = $this->processCategoryTree($category);
        }
        return $cate;
    }

    public function processCategoryTree($categoryTree)
    {
        $categories = explode('>', $categoryTree);

        $parentId = 2; // Κεντρική κατηγορία
        $categoryIds = array();

        foreach ($categories as $category) {
            $existingCategoryId = $this->getCategoryIdByName($category, $parentId);

            if ($existingCategoryId) {
                $parentId = $existingCategoryId;
            } else {
                $newCategoryId = $this->createCategory($category, $parentId);
                if ($newCategoryId) {
                    $parentId = $newCategoryId;
                }
            }
            $categoryIds[] = $parentId;
        }

        return $categoryIds;
    }

    public function getCategoryIdByName($name, $parentId = 2)
    {
        $category = self::searchByName((int)$this->context->language->id, $name, true);

            return $category['id_category'];
    }

    public static function searchByName($idLang, $query, $unrestricted = false, $skipCache = false)
    {
        if ($unrestricted === true) {
            $key = 'Category::searchByName_' . $query;
            if ($skipCache || !Cache::isStored($key)) {
                $sql = new DbQuery();
                $sql->select('c.*, cl.*');
                $sql->from('category', 'c');
                $sql->leftJoin('category_lang', 'cl', 'c.`id_category` = cl.`id_category` ' . Shop::addSqlRestrictionOnLang('cl'));
                $sql->where('`name` = \'' . pSQL($query) . '\'');
                $categories = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
                if (!$skipCache) {
                    Cache::store($key, $categories);
                }

                return $categories;
            }

            return Cache::retrieve($key);
        } else {
            $sql = new DbQuery();
            $sql->select('c.*, cl.*');
            $sql->from('category', 'c');
            $sql->leftJoin('category_lang', 'cl', 'c.`id_category` = cl.`id_category` AND `id_lang` = ' . (int) $idLang . ' ' . Shop::addSqlRestrictionOnLang('cl'));
            $sql->where('`name` LIKE \'%' . pSQL($query) . '%\'');
            $sql->where('c.`id_category` != ' . (int) Configuration::get('PS_HOME_CATEGORY'));

            return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
        }
    }

    /**
     * @param $name
     * @param $parentId
     * @return null
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function createCategory($name, $parentId = 2){
        $category = new Category(null,Context::getContext()->language->id);
        $category->name = $name;
        $category->id_parent = $parentId;
        $category->active = 1;
        $category->link_rewrite = array((int)Configuration::get('PS_LANG_DEFAULT') => Tools::link_rewrite($name));

        if ($category->add()) {
            return $category->id;
        }
        return null;
    }

    public function checkCategory($name)
    {
        $sql = 'SELECT b.`id_category` 
                FROM `'._DB_PREFIX_.'category` as a
                LEFT JOIN `'._DB_PREFIX_.'category_lang` b 
                ON a.`id_category` = b.`id_category`
                WHERE b.`id_lang` = '.(int)Context::getContext()->language->id.' 
                AND b.`name` = "'.pSQL($name).'" AND a.`id_parent`=2';
        return Db::getInstance()->getRow($sql)['id_category'];
    }

    public function createProductFeatures($features, $product){

        foreach ($features as $feature){
            $check = $this->check($feature['name']);

            if (!$check){
                $id = $this->feature($feature);

                if ($id_feature_value = $this->existFeatureValue($feature['value'],$id)){
                    $product->addFeaturesToDB($id, $id_feature_value);
                }else{
                    $id_f_val = $this->addFeatureValue($id,$feature['value']);
                    $product->addFeaturesToDB($id, $id_f_val);
                }
            }else{
                $id_checker = $this->check($feature['name']);
                if ($id_feature_value = $this->existFeatureValue($feature['value'],$id_checker)){
                    $product->addFeaturesToDB($id_checker, $id_feature_value);
                }else{
                    $id_f_val = $this->addFeatureValue($id_checker,$feature['value']);
                    $product->addFeaturesToDB($id_checker, $id_f_val);
                }
            }
        }
    }


    public function generate_link_rewrite_greeklish($slug_string,$lowercase=true){
        $slug_string = mb_convert_encoding($slug_string, 'UTF-8', mb_list_encodings());
        $slug_string = str_replace(array_keys($this->charMap),
            $this->charMap, $slug_string);
        $slug_string = preg_replace('/[^\p{L}\p{Nd}]+/u',
            $this->delimiter, $slug_string); // delimiter
        $slug_string = preg_replace('/(' . preg_quote($this->delimiter, '/') . '){2,}/', '$1', $slug_string);
        $slug_string = trim($slug_string, $this->delimiter); // delimiter

        if($lowercase){
            return mb_strtolower($slug_string, 'UTF-8'); // UTF-8
        }

        return  $slug_string;
    }

    public function addStockAvailableQty($id_product, $qty)
    {
        $sql = 'SELECT `id_stock_available`
                FROM `'._DB_PREFIX_.'stock_available`
                 WHERE `id_product`='.(int)$id_product;
        $result  = Db::getInstance()->getRow($sql);
        $idStockAvailable = $result['id_stock_available'];

        return Db::getInstance()->update(
            'stock_available', array('quantity'=> $qty),
            'id_stock_available='.(int)$idStockAvailable
        );
    }

    public function existFeatureValue($name, $id_feature)
    {
        $sql = 'SELECT a.`id_feature_value` FROM `'._DB_PREFIX_.'feature_value` as a
                    LEFT JOIN `'._DB_PREFIX_.'feature_value_lang` as b
                    ON a.`id_feature_value`=b.`id_feature_value`
                    WHERE b.`value`="'.pSQL($name).'"
                    AND b.`id_lang`='.(int)Context::getContext()->language->id.' AND a.`id_feature`='.(int)$id_feature;

        $res = Db::getInstance()->getValue($sql);
        return ($res) ? $res : false;
    }


    public function addFeatureValue($id_feature, $name)
    {
        $featureValue = new FeatureValue(null, Context::getContext()->language->id);
        $featureValue->value = $name;
        $featureValue->id_feature = $id_feature;
        if (!$featureValue->save()) {
            return  false;
        }

        return  $featureValue->id;
    }


    public function feature($feature)
    {
        $f = new Feature(null,Context::getContext()->language->id);
        $f->name = $feature['name'];
        if (!$f->save()){
            return  false;
        }

        return  $f->id;
    }

    public function check($name)
    {
        $sql = 'SELECT `id_feature`
                FROM `'._DB_PREFIX_.'feature_lang` 
                WHERE `name`="'.pSQL($name).'" AND  `id_lang`='.(int)Context::getContext()->language->id;
        $result = Db::getInstance()->getValue($sql);
        return ($result) ? $result : false;
    }

    public function addManufacturer($name)
    {
        $result = 'SELECT `id_manufacturer` 
                   FROM `'._DB_PREFIX_.'manufacturer`
                   WHERE `name`="'.pSQL($name).'"';

        $r = Db::getInstance()->getRow($result);

        if (isset($r['id_manufacturer']) && $r['id_manufacturer']) {
            return $r['id_manufacturer'];
        }

        $man = new Manufacturer();
        $man->name = $name;
        $man->active = true;
        if (!$man->save())
        {
            return  false;
        }

        return  $man->id;
    }


    public static function copyImg($id_entity, $id_image = null, $url = '', $entity = 'products', $regenerate = true)
    {
        $tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
        $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));

        switch ($entity) {
            default:
            case 'products':
                $image_obj = new Image($id_image);
                $path = $image_obj->getPathForCreation();
                break;
            case 'categories':
                $path = _PS_CAT_IMG_DIR_.(int) $id_entity;
                break;
            case 'manufacturers':
                $path = _PS_MANU_IMG_DIR_.(int) $id_entity;
                break;
            case 'suppliers':
                $path = _PS_SUPP_IMG_DIR_.(int) $id_entity;
                break;
            case 'stores':
                $path = _PS_STORE_IMG_DIR_.(int) $id_entity;
                break;
        }

        $url = urldecode(trim($url));
        $parced_url = parse_url($url);

        if (isset($parced_url['path'])) {
            $uri = ltrim($parced_url['path'], '/');
            $parts = explode('/', $uri);
            foreach ($parts as &$part) {
                $part = rawurlencode($part);
            }
            unset($part);
            $parced_url['path'] = '/'.implode('/', $parts);
        }

        if (isset($parced_url['query'])) {
            $query_parts = array();
            parse_str($parced_url['query'], $query_parts);
            $parced_url['query'] = http_build_query($query_parts);
        }


        $url = http_build_url('', $parced_url);

        $orig_tmpfile = $tmpfile;

        if (Tools::copy($url, $tmpfile)) {
            // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
            if (!ImageManager::checkImageMemoryLimit($tmpfile)) {
                @unlink($tmpfile);
                return false;
            }

            $tgt_width = $tgt_height = 0;
            $src_width = $src_height = 0;
            $error = 0;
            ImageManager::resize($tmpfile, $path.'.jpg', null, null, 'jpg', false, $error, $tgt_width, $tgt_height, 5, $src_width, $src_height);
            $images_types = ImageType::getImagesTypes($entity, true);

            if ($regenerate) {
                $previous_path = null;
                $path_infos = array();
                $path_infos[] = array($tgt_width, $tgt_height, $path.'.jpg');
                foreach ($images_types as $image_type) {
                    $tmpfile = self::get_best_path($image_type['width'], $image_type['height'], $path_infos);

                    if (ImageManager::resize(
                        $tmpfile,
                        $path.'-'.stripslashes($image_type['name']).'.jpg',
                        $image_type['width'],
                        $image_type['height'],
                        'jpg',
                        false,
                        $error,
                        $tgt_width,
                        $tgt_height,
                        5,
                        $src_width,
                        $src_height
                    )) {
                        // the last image should not be added in the candidate list if it's bigger than the original image
                        if ($tgt_width <= $src_width && $tgt_height <= $src_height) {
                            $path_infos[] = array($tgt_width, $tgt_height, $path.'-'.stripslashes($image_type['name']).'.jpg');
                        }
                        if ($entity == 'products') {
                            if (is_file(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$id_entity.'.jpg')) {
                                unlink(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$id_entity.'.jpg');
                            }
                            if (is_file(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$id_entity.'_'.(int)Context::getContext()->shop->id.'.jpg')) {
                                unlink(_PS_TMP_IMG_DIR_.'product_mini_'.(int)$id_entity.'_'.(int)Context::getContext()->shop->id.'.jpg');
                            }
                        }
                    }
                    if (in_array($image_type['id_image_type'], $watermark_types)) {
                        Hook::exec('actionWatermark', array('id_image' => $id_image, 'id_product' => $id_entity));
                    }
                }
            }
        } else {
            @unlink($orig_tmpfile);
            return false;
        }
        unlink($orig_tmpfile);
        return true;
    }


    /**
     * @param $tgt_width
     * @param $tgt_height
     * @param $path_infos
     * @return mixed|string
     */
    protected static function get_best_path($tgt_width, $tgt_height, $path_infos){

        $path_infos = array_reverse($path_infos);
        $path = '';

        foreach ($path_infos as $path_info) {
            list($width, $height, $path) = $path_info;
            if ($width >= $tgt_width && $height >= $tgt_height) {
                return $path;
            }
        }
        return $path;
    }
    private function addImage($myimage, $id_product, $cover=false)
    {
        $shops 				= Shop::getShops(true, null, true); //$shops
        $image 				= new Image();
        $image->id_product 	= $id_product;

        $image->position 	= Image::getHighestPosition($id_product) + 1;
        $image->cover 		= $cover;
        $image->legend = null;
        $url =  $myimage;

        if ($image->add()) {
            $image->associateTo($shops);

            self::copyImg($id_product, $image->id, $url, 'products', true);
        }

        return $image->id;

    }

}