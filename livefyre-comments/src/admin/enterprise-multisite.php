<?php
/*
Author: Livefyre, Inc.
Version: 4.2.1
Author URI: http://livefyre.com/
*/

?>

<div id="fyresettings">
    <div id="fyreheader" style= <?php echo '"background-image: url(' .plugins_url( '/livefyre-comments/images/header-bg.png', 'livefyre-comments' ). ')"' ?> >
        <img src= <?php echo '"' .plugins_url( '/livefyre-comments/images/logo.png', 'livefyre-comments' ). '"' ?> rel="Livefyre" style="padding: 5px; padding-left: 15px;" />
    </div>
    <div id="fyrebody">
        <div id="fyrebodycontent">
            <div id="fyrestatus">
                <?php
                $bad_status = $this->ext->get_network_option( 'livefyre_domain_name', '' ) == ''
                    || $this->ext->get_network_option( 'livefyre_domain_key', '' ) == '';
                $status = Array('All systems go!', 'green');
                if( $bad_status ) {
                    $status = Array('Settings blank', 'red');
                }
                echo '<h1><span class="statuscircle' .esc_attr($status[1]). '"></span>Livefyre Status: <span>' .esc_attr($status[0]). '</span></h1>';

                $total_errors = 1;
                if ( $bad_status ) {
                    echo '<h2> You must set your network name and key.</h2>';
                }
                ?>
            </div>
            <div id="fyrenetworksettingsmulti">
                <form method="post" action="edit.php?action=save_network_options">
                    <?php
                        settings_fields( 'livefyre_domain_options' );
                        do_settings_sections( 'livefyre_network' );
                    ?>
                    <p>*Livefyre settings (Network Name/Key) can be acquired from your technical account manager.</p>
                    <p>For information about the authenication delegate, please refer to our documentation
                    <a href="http://docs.livefyre.com/developers/plugins/wordpress/#authentication" target=_blank>here.</a></p>
                    <p>The Callback Function must be a valid Javascript function declared before the wp_footer. Please, consult your
                    theme design for where to place the variable. For further information, please visit our docs 
                    <a href="http://docs.livefyre.com/developers/plugins/wordpress/" target=_blank>here.</a></p>
                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
                    </p>
                </form>
            </div>
            <div id="fyresidepanel">
                <div id="fyresidesettings">
                    <h1>Network Settings</h1>
                        <p class="lf_label">Network: </p>
                        <?php echo '<p class="lf_text">' .esc_html($this->ext->get_network_option( 'livefyre_domain_name', '' )). '</p>'; ?>
                        <br />
                        <p class="lf_label">Network Key: </p>
                        <?php echo '<p class="lf_text">' .esc_html($this->ext->get_network_option( 'livefyre_domain_key', '' )). '</p>'; ?>
                        <br />
                        <p class="lf_label">Auth Delegate: </p>
                        <?php echo '<p class="lf_text">' .esc_html($this->ext->get_network_option( 'livefyre_auth_delegate_name', '' )). '</p>'; ?>
                        <br />
                        <p class="lf_label">Callback: </p>
                        <?php echo '<p class="lf_text">' .esc_html($this->ext->get_network_option( 'livefyre_callback_name', '' )). '</p>'; ?>
                    <h1>Site Settings</h1>
                        <?php echo '<p class="lf_text">Specific to each site</p>'; ?>
                    <h1>Links</h1>
                        <a href="http://livefyre.com/admin" target="_blank">Livefyre Admin</a>
                        <br />
                        <a href="http://support.livefyre.com" target="_blank">Livefyre Support</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    <?php wp_enqueue_style("livefyre-e-m-css", plugins_url() . '/livefyre-comments/src/admin/settings-template.css' ); ?>
</style>
