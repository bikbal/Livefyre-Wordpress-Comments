<?php
/*
Author: Livefyre, Inc.
Version: 4.2.0
Author URI: http://livefyre.com/
*/

/*
 * Untility class that allows certain values to be set in the option table
 * based on a GET param.
 *
 * TODO: These need to be checked for a valid token(site or network) so that others can't set
 * these values without verification.
 */
class Livefyre_Utility {
    
    function __construct( $lf_core ) {

        $this->lf_core = $lf_core;
        $this->ext = $lf_core->ext;

        add_action( 'init', array( &$this, 'set_activity_id' ) );
        add_action( 'init', array( &$this, 'show_activity_id' ) );
        add_action( 'init', array( &$this, 'set_import_status' ) );
        add_action( 'init', array( &$this, 'set_widget_priority' ) );
        add_action( 'init', array( &$this, 'show_widget_priority' ) );
    }
    
    /*
     * Sets an activity ID for a site sync.
     *
     */
    function set_activity_id() {

        if ( ( self::validity_check() ) && !( isset($_GET['lf_set_activity_id']) ) ) {
            return;
        }
        $result = array(
            'status' => 'ok',
            'activity-id-set-to' => sanitize_text_field( $_GET['lf_set_activity_id'] )
        );
        $status = $this->ext->update_option( "livefyre_activity_id", 
            sanitize_text_field( $_GET["lf_set_activity_id"] ) );
        if ( !$status ) {
            $result['status'] = 'error';
        }
        echo json_encode( $result );
        exit;
    }

    /*
     * Shows the current activity ID for a site sync.
     *
     */
    function show_activity_id() {

        if ( ( self::validity_check() ) && 
            !( isset($_GET['lf_show_activity_id']) && $_GET['lf_show_activity_id'] == 1) ) {
            return;
        }
        $result = array(
            'activity-id' => $this->ext->get_option( 'livefyre_activity_id', 0 )
        );
        echo json_encode( $result );
        exit;
    }

    /*
     * Sets the plugin's priority to sort out weight issues.
     *
     */
    function set_widget_priority() {

        if ( ( self::validity_check() ) && 
            !( isset($_GET['lf_set_widget_priority'] ) )
        ) {
            return;
        }
        $priority = sanitize_text_field( $_GET["lf_set_widget_priority"] );
        $result = array(
            'status' => 'ok',
            'widget-priority-set-to' => $priority
        );
        $status = $this->ext->update_option( "livefyre_widget_priority", $priority );
        if ( !$status ) {
            $result['status'] = 'error';
        }
        echo json_encode( $result );
        exit;
    }

    /*
     * Show the plugin's current priority.
     *
     */
    function show_widget_priority() {

        if ( ( self::validity_check() ) &&
            !( isset($_GET['lf_show_widget_priority']) && $_GET['lf_show_widget_priority'] == 1 ) 
        ) {
            return;
        }
        $result = array(
            'widget-priority' => $this->ext->get_option( 'livefyre_widget_priority', 99 )
        );
        echo json_encode( $result );
        exit;
    }
    
    function set_import_status() {

        if ( !( isset($_GET['lf_set_import_status']) ) ) {
            return;
        }
        $import_code = $_GET['lf_set_import_status'];
        $import_status = ( $import_code == 0 ) ? 'error' : 'complete';
        $result = array(
            'status' => 'ok',
            'import_status' => $import_status
        );
        $success = $this->update_import_status( $import_status );
        if ( !$success ) {
            $result['status'] = 'error';
        }
        echo json_encode( $result );
        exit;
    }

    function update_import_status( $status ) {

        return $this->ext->update_option( "livefyre_import_status", $status );
    }
    
    /*
     * TODO: Check for the validity of these requests. Due to security reasons, make sure
     * these only come from a Livefyre or the customer.
     *
     */
    function validity_check() {
        return true;

    }

}
