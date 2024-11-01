<?php

/*
Plugin Name: Wakker Media Newsletter Checkout Checkbox
Plugin URI: http://www.wakkermedia.nl/newsletter-checkbox-on-woocommerce-checkout/
Description: Wakker Media Checkout Checkbox is a quick solution for adding a newsletter checkbox on the Woocommerce Checkout Page. This plugin needs the <a href="http://www.satollo.net/plugins/newsletter">Newsletter plugin</a> by Stefano Lissa and <a href="http://www.woothemes.com/woocommerce/">Woocommerce</a> by Woothemes 
Version: 1.1
Author: Douwe Hoogeveen
Author URI: http://www.wakkermedia.nl
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.

Copyright 2013-2014 Douwe Hoogevee (email: info@wakkermedia.nl, web: http://www.wakkermedia.nl)

*/

	
	add_action('woocommerce_before_order_notes', 'wm_newsletter_checkout_field');
	
	function wm_newsletter_checkout_field( $checkout ) {
		if ( is_plugin_active( 'newsletter/plugin.php' ) ) {

			$module = NewsletterSubscription::instance();
			if ($module->options['subscribe_wp_users'] == 2 || $module->options['subscribe_wp_users'] == 3) {
				$default = 0;
				if ($module->options['subscribe_wp_users'] == 3) {
					$default = 1;
				}
				
	
				woocommerce_form_field( 'newsletter', array(
					'type'          => 'checkbox',
					'class'         => array('my-field-class form-row-wide'),
					'default'		=> $default,
					'label'         => $module->options['subscribe_wp_users_label'],
				), $checkout->get_value( 'newsletter' ));
			}
		}
	}	
	
	/**
	 * Save newsletter data from Woocommerce Checkout
	 * By Wakker Media - Douwe Hoogeveen
	 * http://www.wakkermedia.nl
	**/
	add_action('woocommerce_checkout_update_order_meta', 'wm_save_newsletter_checkout_field');

	function wm_save_newsletter_checkout_field( $order_id ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'newsletter/plugin.php' ) ) {

			if ($_POST['newsletter'] == 1) :
				$_REQUEST['ne'] = $_POST['billing_email'];
				$user = NewsletterSubscription::instance()->subscribe();
			endif;
		}
	}
	
