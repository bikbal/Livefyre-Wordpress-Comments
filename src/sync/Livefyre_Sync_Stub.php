<?php
/*
Author: Livefyre, Inc.
Version: 4.2.0
Author URI: http://livefyre.com/
*/

require_once 'Livefyre_Sync.php';

/*
 * Stubbed out version of Livefyre's Site Sync. This is stubbed
 * out so that there isn't broken functionality when switching from
 * the enterprise version to the community version. Since enterprise
 * doesn't require site sync or imports, the code would break if our
 * building script didn't handle this case.
 */
class Livefyre_Sync_Stub implements Livefyre_Sync {

    function do_sync() {
        return;
    }

    function schedule_sync( $timeout ) {
        return;
    }
    
    function comment_update() {
        return;
    }
    
    function profile_update( $user_id ) {
        return;
    }

    function check_profile_pull() {
        return;
    }

    function save_post( $post_id ) {
        return;
    }

    function post_param( $name, $plain_to_html = false, $default = null ) {
        return;
    }
    
    function is_signed_profile_pull() {
        return;
    }

    function site_rest_url() {
        return;

    }

    function livefyre_report_error( $message ) { 
        return;
    }

    function livefyre_insert_activity( $data ) {
        return;
    }
    
}
