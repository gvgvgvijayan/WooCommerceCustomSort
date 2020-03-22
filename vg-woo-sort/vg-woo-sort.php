<?php
defined('ABSPATH') or die('No direct access please!');

/*
Plugin Name: VG Woo Sort
Description: Aditional sort for WooCommerce Shop
Version: 1.0
Author: Vijayan G
Author URI: www.vijayan.in
*/

/**
 * Adds Custom Sorting
 * 
 * This plugin is used to add and modify sorting options in product archive page
 */
class VG_Sort
{

    /**
     * Callback method to implement A-Z & Z-A sort functionality
     * 
     * @since 1.0
     */
    public static function custom_woocommerce_get_catalog_ordering_args($args)
    {
        $orderby_value = isset($_GET['orderby']) ?
            wc_clean($_GET['orderby']) :
            apply_filters(
                'woocommerce_default_catalog_orderby',
                get_option('woocommerce_default_catalog_orderby')
            );

        if ('reverse_list' == $orderby_value) {
            $args['orderby'] = 'title';
            $args['order'] = 'desc';
        } else if ('alpha_list' == $orderby_value) {
            $args['orderby'] = 'title';
            $args['order'] = 'asc';
        }

        return $args;
    }

    /**
     * Callback method to rename and reorder the sort options
     * 
     * @since 1.0
     */
    public static function custom_woocommerce_catalog_orderby($sortby)
    {
        $sortby = [
            'menu_order' => __('Default', 'woocommerce'),
            'alpha_list' => __('A - Z', 'woocommerce'),
            'reverse_list' => __('Z - A', 'woocommerce'),
            'popularity' => __('Popularity', 'woocommerce'),
            'rating'     => __('Average rating', 'woocommerce'),
            'date'       => __('Latest', 'woocommerce'),
            'price'      => __('Price: low to high', 'woocommerce'),
            'price-desc' => __('Price: high to low', 'woocommerce'),
        ];

        return $sortby;
    }

    /**
     * Callback method to alter number of products per page
     * 
     * @since 2.0
     */
    public static function custom_products_per_page($per_page)
    {

        $count = (int) get_query_var('show');
        $count = empty($count) ? 16 : $count;

        switch ($count) {
            case 4:
            case 8:
            case 16:
            case 32:
            case -1:
                $per_page = $count;
                break;
            default:
                $per_page = 16;
                break;
        }

        return $per_page;
    }

    /**
     * Template method responsible for total products per page
     * 
     * @since 2.0
     */
    public static function template_products_per_page()
    {
        wc_get_template('products-per-page.php', array(), '', plugin_dir_path(__FILE__) . 'templates/');
    }

    /**
     * Add the query variables used by products per page logic
     * 
     * @since 2.0
     */
    public static function add_query_vars_products_per_page($vars)
    {
        $vars[] = 'show';

        return $vars;
    }

    /**
     * Include plugin JS & CSS
     * 
     * @since 2.0
     */
    public static function add_assets()
    {
        wp_enqueue_style('vg-sort-css', plugin_dir_url(__FILE__) .  'assets/css/main.css');
    }
}

/**
 * Add custom sorting options (both asc & desc)
 */
add_filter('woocommerce_get_catalog_ordering_args', array('VG_Sort', 'custom_woocommerce_get_catalog_ordering_args'));
add_filter('woocommerce_default_catalog_orderby_options', array('VG_Sort', 'custom_woocommerce_catalog_orderby'));
add_filter('woocommerce_catalog_orderby', array('VG_Sort', 'custom_woocommerce_catalog_orderby'));
add_filter('loop_shop_per_page', array('VG_Sort', 'custom_products_per_page'));
add_action('woocommerce_before_shop_loop', array('VG_Sort', 'template_products_per_page'), 30);
add_filter('query_vars', array('VG_Sort', 'add_query_vars_products_per_page'));
add_action('wp_enqueue_scripts', array('VG_Sort', 'add_assets'));
