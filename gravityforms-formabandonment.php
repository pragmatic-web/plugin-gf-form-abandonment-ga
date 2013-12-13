<?php
/*
Plugin Name: Gravity Forms Google Analytics Form Abandonment Addon
Plugin URI: http://www.pragmatic-web.co.uk/plugins/gf-form-abandonment-ga
Description: Send form abandonment data from Gravity Forms forms to Google Analytics - covers text/select, radio, checkbox and submit inputs
Version: 0.2
Author: Pragmatic
Author Email: info@pragmatic-web.co.uk
License:

  Copyright 2013 Pragmatic Web Limited (info@pragmatic-web.co.uk)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

include_once('updater.php');

if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
    $config = array(
        'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
        'proper_folder_name' => 'plugin-gf-form-abandonment-ga', // this is the name of the folder your plugin lives in
        'api_url' => 'https://api.github.com/repos/pragmatic-web/plugin-gf-form-abandonment-ga', // the github API url of your github repo
        'raw_url' => 'https://raw.github.com/pragmatic-web/plugin-gf-form-abandonment-ga/master', // the github raw url of your github repo
        'github_url' => 'https://github.com/pragmatic-web/plugin-gf-form-abandonment-ga', // the github url of your github repo
        'zip_url' => 'https://github.com/pragmatic-web/plugin-gf-form-abandonment-ga/zipball/master', // the zip url of the github repo
        'sslverify' => true, // wether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
        'requires' => '3.7', // which version of WordPress does your plugin require?
        'tested' => '3.7.1', // which version of WordPress is your plugin tested up to?
        'readme' => 'README.md', // which file to use as the readme for the version number
        'access_token' => '', // Access private repositories by authorizing under Appearance > Github Updates when this example plugin is installed
    );
    new WP_GitHub_Updater($config);
}

class GravityFormsGoogleAnalyticsFormAbandonmentAddon {

    /*--------------------------------------------*
     * Constants
     *--------------------------------------------*/
    const name = 'Gravity Forms Google Analytics Form Abandonment Addon';
    const slug = 'gravity_forms_google_analytics_form_abandonment_addon';
    
    /**
     * Constructor
     */
    function __construct() {
        add_action( 'init', array( &$this, 'init_gravity_forms_google_analytics_form_abandonment_addon' ) );
    }
  
    /**
     * Runs when the plugin is initialized
     */
    function init_gravity_forms_google_analytics_form_abandonment_addon() {
        // Setup localization
        load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
        // GF action hook
        add_action( 'gform_enqueue_scripts', array( &$this, 'gform_enqueue_form_abandonment' ) );
    }

    function gform_enqueue_form_abandonment() {
        $this->load_file( self::slug . '-script', '/js/gravityforms-formabandonment.js', true );
    }
    
    /**
     * Helper function for registering and enqueueing scripts and styles.
     */
    private function load_file( $name, $file_path, $is_script = false ) {

        $url  = plugins_url($file_path, __FILE__);
        $file = plugin_dir_path(__FILE__) . $file_path;

        if( file_exists( $file ) ) {
            if( $is_script ) {
                wp_register_script( $name, $url, array('jquery') );
                wp_enqueue_script( $name );
            }
        }

    } 
  
} // end class
new GravityFormsGoogleAnalyticsFormAbandonmentAddon();
