<?php
defined( 'ABSPATH' ) or die( 'No direct access please!' );

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
class VG_Sort {

    /**
     * Callback method to implement A-Z & Z-A sort functionality
     * 
     * @since 1.0
     */
    public function custom_woocommerce_get_catalog_ordering_args( $args ) {
        $orderby_value = isset( $_GET['orderby'] ) ? 
                wc_clean( $_GET['orderby'] ) : 
                apply_filters( 'woocommerce_default_catalog_orderby', 
                    get_option( 'woocommerce_default_catalog_orderby' ));

        if ( 'reverse_list' == $orderby_value ) {
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
    public function custom_woocommerce_catalog_orderby( $sortby ) {
        $sortby = [
            'menu_order' => __( 'Default', 'woocommerce'),
            'alpha_list' => __('A - Z', 'woocommerce'),
            'reverse_list' => __( 'Z - A', 'woocommerce'),
            'popularity' => __( 'Popularity', 'woocommerce' ),
            'rating'     => __( 'Average rating', 'woocommerce' ),
            'date'       => __( 'Latest', 'woocommerce' ),
            'price'      => __( 'Price: low to high', 'woocommerce' ),
            'price-desc' => __( 'Price: high to low', 'woocommerce' ),
        ];

        return $sortby;
    }
}

/**
 * Add custom sorting options (both asc & desc)
 */
add_filter( 'woocommerce_get_catalog_ordering_args', array('VG_Sort', 'custom_woocommerce_get_catalog_ordering_args' ));
add_filter( 'woocommerce_default_catalog_orderby_options', array('VG_Sort', 'custom_woocommerce_catalog_orderby' ));
add_filter( 'woocommerce_catalog_orderby', array('VG_Sort', 'custom_woocommerce_catalog_orderby' ));