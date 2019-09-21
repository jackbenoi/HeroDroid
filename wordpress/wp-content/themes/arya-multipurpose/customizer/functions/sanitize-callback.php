<?php
/**
 * Collection of functions to sanitize customizer field values.
 *
 * @package Arya_Multipurpose
 */


/**
 * Sanitization callback function for number field.
 */
if ( ! function_exists( 'arya_multipurpose_sanitize_number' ) ) {

    function arya_multipurpose_sanitize_number( $input, $setting ) {

        return absint( $input );
    }
}


/**
 * Sanitization callback function for select field.
 */
if ( !function_exists('arya_multipurpose_sanitize_select') ) {

    function arya_multipurpose_sanitize_select( $input, $setting ) {

        $input = sanitize_key( $input );
        
        $choices = $setting->manager->get_control( $setting->id )->choices;
        
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
}