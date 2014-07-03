<?php
/*
Livefyre Realtime Comments Core Module

This library is shared between all Livefyre plugins.

Author: Livefyre, Inc.
Version: 4.2.0
Author URI: http://livefyre.com/
*/

define( 'LF_PLUGIN_VERSION', '4.2.0' );
define( 'LF_DEFAULT_PROFILE_DOMAIN', 'livefyre.com' );
define( 'LF_DEFAULT_TLD', 'livefyre.com' );
define( 'LF_PLUGIN_PATH', WP_PLUGIN_DIR . '/livefyre-comments/');

class Livefyre_WP_Core {

    /*
     * Build the plugins core functionality.
     *
     */
    function __construct() {
        self::add_extension();
        self::require_php_api();
        self::define_globals();
        self::require_subclasses();
    }
    
    /*
     * Helper function that allows classes to use this as a bank for
     * all useful Livefyre values.
     *
     */
    function define_globals() {

        $client_key = $this->ext->get_network_option( 'livefyre_domain_key', '' );
        $profile_domain = $this->ext->get_network_option( 'livefyre_domain_name', 'livefyre.com' );
        $dopts = array(
            'livefyre_tld' => LF_DEFAULT_TLD
        );
        $uses_default_tld = (strpos(LF_DEFAULT_TLD, 'livefyre.com') === 0);
        
        $this->top_domain = ( $profile_domain == LF_DEFAULT_PROFILE_DOMAIN ? LF_DEFAULT_TLD : $profile_domain );
        $this->http_url = ( $uses_default_tld ? "http://www." . LF_DEFAULT_TLD : "http://" . LF_DEFAULT_TLD );
        $this->api_url = "http://api.$this->top_domain";
        $this->quill_url = "http://quill.$this->top_domain";
        $this->admin_url = "http://admin.$this->top_domain";
        $this->assets_url = "http://zor." . LF_DEFAULT_TLD;
        $this->bootstrap_url = "http://bootstrap.$this->top_domain";
        
        // for non-production environments, we use a dev url and prefix the path with env name
        $bootstrap_domain = 'bootstrap-json-dev.s3.amazonaws.com';
        $environment = $dopts['livefyre_tld'] . '/';
        if ( $uses_default_tld ) {
            $bootstrap_domain = 'data.bootstrap.fyre.co';
            $environment = '';
        }
        
        $existing_blogname = $this->ext->get_option( 'livefyre_blogname', false );
        if ( $existing_blogname ) {
            $site_id = $existing_blogname;
        } else {
            $site_id = $this->ext->get_option( 'livefyre_site_id', false );
        }

        $this->bootstrap_url_v3 = "http://$bootstrap_domain/$environment$profile_domain/$site_id";
        
        $this->home_url = $this->ext->home_url();
        $this->plugin_version = LF_PLUGIN_VERSION;

    }
    
    /*
     * Grabs the Livefyre PHP api.
     *
     */
    function require_php_api() {

        require_once(dirname(__FILE__) . "/../livefyre-api/libs/php/JWT.php");

    }

    /*
     * Adds the extension for WordPress.
     *
     */
    function add_extension() {

        require_once( dirname( __FILE__ ) . '/Livefyre_Application.php' );
        $this->ext = new Livefyre_Application();
    }

    /*
     * Builds necessary classes for the WordPress plugin.
     *
     */
    function require_subclasses() {

        require_once( dirname( __FILE__ ) . '/display/Livefyre_Display.php' );
        require_once( dirname( __FILE__ ) . '/import/Livefyre_Import_Impl.php' );
        require_once( dirname( __FILE__ ) . '/admin/Livefyre_Admin.php' );
        require_once( dirname( __FILE__ ) . '/Livefyre_Activation.php' );
        require_once( dirname( __FILE__ ) . '/Livefyre_Utility.php' );
        require_once( dirname( __FILE__ ) . '/sync/Livefyre_Sync_Impl.php' );

        $this->Activation = new Livefyre_Activation( $this );
        $this->Sync = new Livefyre_Sync_Impl( $this );
        $this->Import = new Livefyre_Import_Impl( $this );
        $this->Admin = new Livefyre_Admin( $this );
        $this->Display = new Livefyre_Display( $this );
        $this->Livefyre_Utility = new Livefyre_Utility( $this );
    }

} //  Livefyre_core
