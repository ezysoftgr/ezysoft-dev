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

class DatabaseQueryHelper
{


    /**
     * @param $images
     * @return array
     */
    public static function getImages($images, $name)
    {
        $render = [];
        foreach ($images as $key=>$image){
            if ($image['cover']){
                $render['cover'] = Context::getContext()->link->getImageLink($name,
                    (int)$image['id_image'], 'large_default') ;
            }else{
                $render['images'][] = Context::getContext()->link->getImageLink($name,
                    (int)$image['id_image'], 'large_default') ;
            }
        }
        return $render;
    }

    /**
     * @param $features
     * @return array
     */
    public static function getFeatures($features)
    {
        $render = [];
        foreach ($features as $key => $value) {

            $render[] = [
                'name'  => self::getFeatureName($value['id_feature']),
                'value' => self::getFeatureValue($value['id_feature_value'])
            ];
        }
        return $render;
    }


    /**
     * @param $id_manufacturer
     * @return false|string
     */
    public static  function getManufacturer($id_manufacturer)
    {
        $sql = 'SELECT `name`
                FROM `'._DB_PREFIX_.'manufacturer`
                WHERE `id_manufacturer`='.(int)$id_manufacturer;

        return Db::getInstance()->getValue($sql);
    }


    /**
     * @param $categories
     * @param $id_lang
     * @return string
     */
    public static function getCategories($categories, $id_lang)
    {

        $categories1 = array();
        foreach ($categories as $category_id) {
            $category_info = new Category($category_id, (int)Context::getContext()->language->id);
            $category = array(
                'id' => $category_info->id,
                'name' => $category_info->name,
                'parent_id' => $category_info->id_parent,
            );

            $categories1[] = $category;
        }

        $mainCategories = self::buildCategoryTree($categories1);
        return implode('|', self::buildCategoryNames($mainCategories));
    }

    public static function buildCategoryNames($categories, $parent_name = '') {
        $result = array();
        foreach ($categories as $category) {
            $current_name = $parent_name . $category['name'];
            if (!empty($category['children'])) {
                $result = array_merge($result, self::buildCategoryNames($category['children'], $current_name . ' > '));
            } else {
                $result[] = $current_name;
            }
        }
        return $result;
    }
    public static function buildCategoryTree($categories, $parent_id = 2) {

        $tree = array();
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parent_id) {
                $children = self::buildCategoryTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $tree[] = $category;
            }
        }
        return $tree;
    }

    /**
     * @param $categories
     * @return mixed
     */
    private static function defineCategoriesWithoutHome($categories)
    {
        foreach ($categories as $key=>$category) {
            if ($category ==2) {
                unset($categories[$key]);
            }
        }
        return $categories;
    }

    public static function getCategoryName($id_category, $id_lang)
    {
        $sql  = 'SELECT `name` FROM `'._DB_PREFIX_.'category_lang` 
                    WHERE `id_category`='.(int)$id_category.' AND `id_lang`='.(int)$id_lang;

        return Db::getInstance()->getValue($sql);
    }

    /**
     * @param $id
     * @return false|string|null
     */
    private static function getFeatureValue($id)
    {
        return Db::getInstance()->getValue(
            'SELECT `value` 
                 FROM `'._DB_PREFIX_.'feature_value_lang` 
                 WHERE `id_feature_value`='.(int)$id.' 
                 AND `id_lang`='.(int)Configuration::get('EZYSOFT_SOURCE_ID_LANG')
        );
    }


    /**
     * @param $id
     * @return false|string|null
     */
    private static function getFeatureName($id)
    {
        return Db::getInstance()->getValue(
            'SELECT `name` 
                 FROM `'._DB_PREFIX_.'feature_lang` 
                 WHERE `id_feature`='.(int)$id.' 
                 AND `id_lang`='.(int)Configuration::get('EZYSOFT_SOURCE_ID_LANG')
        );
    }



    public  static function getCarrier($id_carrier)
    {
        $sql = 'SELECT `name` 
                FROM `'._DB_PREFIX_.'carrier`
                WHERE `id_carrier`='.(int)$id_carrier;

        return Db::getInstance()->getValue($sql);
    }



}