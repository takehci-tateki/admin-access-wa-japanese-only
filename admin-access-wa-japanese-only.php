<?php
/*
Plugin Name: Admin Access Wa Japanese Only
Plugin URI: http://takechi-tateki.com/
Description: Limited access (Non Japanese IP address) to the WordPress administration pages. 
Version: 1.0.0
Author: Tateki Takechi
Author URI: http://takechi-tateki.com/
Copyright (C) 2014 Tateki Takechi
*/
/*
CHANGE LOG
Plugin Name: Admin Block Country
Plugin URI: http://wordpress.org/extend/plugins/admin-block-country/
Description: Blocks admin site by country.
Version: 5.1
Author: TheOnlineHero - Tom Skroza
License: GPL2
*/

add_action('init', 'register_admin_access_wa_japanese_only');

function register_admin_access_wa_japanese_only() {

  if (preg_match('/wp-login|wp-admin/', $_SERVER['REQUEST_URI'])) {

    $wp_nonce = wp_create_nonce('AAWJO-country-code');

    if(isset($_SESSION[$wp_nonce.str_replace(' ', '_', strtolower(get_option('siteurl'))) .'AAWJO-country-code'])) {

      $country_code =  $_SESSION[$wp_nonce.str_replace(' ', '_', strtolower(get_option('siteurl'))) .'AAWJO-country-code'];

    } else {
/*
      $info = file_get_contents('http://who.is/whois-ip/ip-address/'. $_SERVER['REMOTE_ADDR']);
      list($a, $b) = explode('country:        ', $info);
      $_SESSION[$wp_nonce.str_replace(' ', '_', strtolower(get_option('siteurl'))) .'AAWJO-country-code'] = substr($b, 0, 2);
      $country_code =  substr($b, 0, 2);
*/
/*
      $temp = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='. $_SERVER['REMOTE_ADDR']));
      $_SESSION[$wp_nonce.str_replace(' ', '_', strtolower(get_option('siteurl'))) .'AAWJO-country-code'] = $temp['geoplugin_countryCode'];
      $country_code =  $temp['geoplugin_countryCode'];
*/
      $code = file_get_contents('http://ipcountry.marketingmix.com.au/?ip='. $_SERVER['REMOTE_ADDR']);
      $_SESSION[$wp_nonce.str_replace(' ', '_', strtolower(get_option('siteurl'))) .'AAWJO-country-code'] = $code;
      $country_code =  $code;
    }

    if ($country_code != 'JP') {
      exit;
    }
  }
}
