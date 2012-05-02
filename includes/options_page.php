<style type="text/css">

#options h3 {
    padding: 7px;
    padding-top: 10px;
    margin: 0px;
    cursor: auto
}

#options p {
    clear: both;
    padding: 0 10px 10px;
}

#options .postbox {
    margin: 0px 0px 10px 0px;
    padding: 0px;
}
</style>

<div class="wrap">
    <div id="icon-plugins" class="icon32"><br></div>
    <h2>Facebook Comments Notify</h2>
    <form method="post" action="options.php" id="options">
        <?php wp_nonce_field('update-options') ?>
        <?php 
            $fbcomment_options = get_option('fbComments');
        ?>
        <div class="postbox-container" style="width:100%;">
            <div class="metabox-holder">
                <div class="postbox">
                    <h3 class="hndle"><span><?php _e('Settings Comments') ?></span></h3>
                    <table class="form-table">
                        <tr>
                            <td>
                    			<label for="fbcomments[use_fbml]">
                                    <input name="fbcomments[use_fbml]" type="checkbox" id="fbcomments[use_fbml]" value="1" <?php checked('1', $fbcomment_options['use_fbml']); ?> />
                                    <?php _e('Enable XFBML (only disable this if you already have XFBML enabled elsewhere)') ?>
                                </label><br />
                    			<label for="fbcomments[use_fbns]">
                                    <input name="fbcomments[use_fbns]" type="checkbox" id="fbcomments[use_fbns]" value="1" <?php checked('1', $fbcomment_options['use_fbns']); ?> />
                                    <?php _e('Enable FB Namespace (only enable this if Facebook comments are not appearing)') ?>
                                </label><br />
                    			<label for="fbcomments[use_opengraph]">
                                    <input name="fbcomments[use_opengraph]" type="checkbox" id="fbcomments[use_opengraph]" value="1" <?php checked('1', $fbcomment_options['use_opengraph']); ?> />
                                    <?php _e('Enable Open Graph (only enable this if Facebook comments are not appearing, not all information is being passed to Facebook or if you have not enabled Open Graph elsewhere within WordPress)') ?>
                                </label><br />
                    			<label for="fbcomments[use_html5]">
                                    <input name="fbcomments[use_html5]" type="checkbox" id="fbcomments[use_html5]" value="1" <?php checked('1', $fbcomment_options['use_html5']); ?> />
                                    <?php _e('Use HTML5 (if this is disabled the old XFBML option will be used)') ?>
                                </label><br /><br />
                    			<label for="fbcomments[in_posts]">
                                    <input name="fbcomments[in_posts]" type="checkbox" id="fbcomments[in_posts]" value="1" <?php checked('1', $fbcomment_options['in_posts']); ?> />
                                    <?php _e('Show comment box in posts') ?>
                                </label><br />
                    			<label for="fbcomments[in_pages]">
                                    <input name="fbcomments[in_pages]" type="checkbox" id="fbcomments[in_pages]" value="1" <?php checked('1', $fbcomment_options['in_pages']); ?> />
                                    <?php _e('Show comment box in pages') ?>
                                </label><br />
                    			<label for="fbcomments[in_homepage]">
                                    <input name="fbcomments[in_homepage]" type="checkbox" id="fbcomments[in_homepage]" value="1" <?php checked('1', $fbcomment_options['in_homepage']); ?> />
                                    <?php _e('Show comment box in homepage') ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="fbcomments[app_id]"><?php _e('App ID') ?></label>
                            </th>
                            <td>
                                <input type="text" name="fbcomments[app_id]" id="fbcomments[app_id]" value="<?php echo $fbcomment_options['app_id']; ?>" class="regular-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="fbcomments[language]"><?php _e('Language') ?></label>
                            </th>
                            <td>
                                <input type="text" name="fbcomments[language]" id="fbcomments[language]" value="<?php echo $fbcomment_options['language']; ?>" class="small-text" />
                                <?php _e('Default is <strong>pt_BR</strong>. A full list of language codes can be found')?> <a href="http://www.facebook.com/translations/FacebookLocales.xml" target="_blank"><?php _e('here');?></a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="fbcomments[number]"><?php _e('Number of Comments') ?></label>
                            </th>
                            <td>
                                <input type="text" name="fbcomments[number]" id="fbcomments[number]" value="<?php echo $fbcomment_options['number']; ?>" class="small-text" />
                                <?php _e('Default is <strong>5</strong>')?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="fbcomments[title]"><?php _e('Title') ?></label>
                            </th>
                            <td>
                                <input type="text" name="fbcomments[title]" id="fbcomments[title]" value="<?php echo $fbcomment_options['title']; ?>" class="regular-text" />
                                <?php _e('Default is <strong>Comments</strong>. This will be nested within a &#60;H3&#62; tag')?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                    			<label for="fbcomments[show_count]">
                                    <input name="fbcomments[show_count]" type="checkbox" id="fbcomments[show_count]" value="1" <?php checked('1', $fbcomment_options['show_count']); ?> />
                                    <?php _e('Show comment count') ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="fbcomments[count_text]"><?php _e('Comment count text') ?></label>
                            </th>
                            <td>
                                <input type="text" name="fbcomments[count_text]" id="fbcomments[count_text]" value="<?php echo $fbcomment_options['count_text']; ?>" class="regular-text" />
                                <?php _e('Comment count text')?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
<script type="text/javascript">
<!--
function use_gmail(){
	if (jQuery('#fbcomments\\[notification_use_gmail\\]').is(':checked')) {
		jQuery('#fbcomments\\[email_host\\]').val('smtp.gmail.com');
		jQuery('#fbcomments\\[email_port\\]').val('465');
		jQuery('#fbcomments\\[email_auth\\]').attr('checked', 1);
		jQuery('#fbcomments\\[email_secure_type\\]').val('ssl');
		if (!jQuery('#fbcomments\\[email_username\\]').val().match(/.+@gmail.com$/) ) {
			jQuery('#fbcomments\\[email_username\\]').val('USERNAME@gmail.com').focus().get(0).setSelectionRange(0,8);
		}
		jQuery('#gmail_user_tip').show();
		
		return true;
	}
}
jQuery(function(){
	jQuery('#fbcomments\\[notification_active\\]').click(function(){
		var $this = jQuery(this);
	    if($this.is(':checked'))
	    	jQuery('#emails_settings').show();
	    else
	    	jQuery('#emails_settings').hide();
	});

	jQuery('#fbcomments\\[use_smtp\\]').click(function(){
		var $this = jQuery(this);
	    if($this.is(':checked'))
	    	jQuery('#smtp_settings').show();
	    else
	    	jQuery('#smtp_settings').hide();
	});
});
//-->
</script> 
            
            <div class="metabox-holder">
                <div class="postbox">
                    <h3 class="hndle"><span><?php _e('Settings Notification') ?></span></h3>
                    <table class="form-table">
                        <tr>
                            <td>
                                <label for="fbcomments[notification_active]">
                                    <input name="fbcomments[notification_active]" type="checkbox" id="fbcomments[notification_active]" value="1" <?php checked('1', $fbcomment_options['notification_active']); ?> />
                                    <?php _e('Enable notification for comments received'); ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                    <div id="emails_settings" <?php echo !$fbcomment_options['notification_active'] ? 'style="display:none;"' : ''?>>
                        <h3 class="title"><?php _e('Email Settings') ?></h3>
                        <p><?php _e('Sending email using PHPMailer library, and it requires smtp server configurations with / without authentication, make the following configurations')?></p>
                        <table class="form-table">
                            <tr>
                                <td colspan="2">
                                    <label for="fbcomments[use_smtp]">
                                        <input name="fbcomments[use_smtp]" type="checkbox" id="fbcomments[use_smtp]" value="1" <?php checked('1', $fbcomment_options['use_smtp']); ?> />
                                        <?php _e('Use SMTP protocol to send emails'); ?>
                                    </label>
                                </td>
                            </tr>
                        </table>
                        <div id="smtp_settings" <?php echo !$fbcomment_options['use_smtp'] ? 'style="display:none;"' : ''?>>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label for="fbcomments[notification_use_gmail]"><?php _e('Send e-mail via GMail?') ?></label>
                                    </th>
                                    <td>
                                        <input name="fbcomments[notification_use_gmail]" onclick="use_gmail()" type="checkbox" id="fbcomments[notification_use_gmail]" value="1" <?php checked('1', $fbcomment_options['notification_use_gmail']); ?> />
                                        <?php _e('Clicking this will override many of the settings defined below. You will need to input your GMail username and password below.'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="fbcomments[email_host]"><?php _e('SMTP Host') ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="fbcomments[email_host]" id="fbcomments[email_host]" value="<?php echo $fbcomment_options['email_host']; ?>" class="regular-text" />
                                        <?php _e('If "localhost" doesn\'t work for you, check with your host for the SMTP hostname.')?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="fbcomments[email_port]"><?php _e('SMTP Port') ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="fbcomments[email_port]" id="fbcomments[email_port]" value="<?php echo $fbcomment_options['email_port']; ?>" class="small-text" />
                                        <?php _e('This is generally 25.')?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="fbcomments[email_secure_type]"><?php _e('Secure connection prefix') ?></label>
                                    </th>
                                    <td>
                                        <select name="fbcomments[email_secure_type]" id="fbcomments[email_secure_type]">
                                            <option value=""></option>
                                            <option value="ssl" <?php selected('ssl', $fbcomment_options['email_secure_type']); ?>>SSL</option>
                                            <option value="tls" <?php selected('tls', $fbcomment_options['email_secure_type']); ?>>TLS</option>
                                        </select>
                                        <?php _e('Sets connection prefix for secure connections (prefix method must be supported by your PHP install and your SMTP host)')?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="fbcomments[email_auth]"><?php _e('Use SMTPAuth?') ?></label>
                                    </th>
                                    <td>
                                        <input name="fbcomments[email_auth]" onclick="use_gmail()" type="checkbox" id="fbcomments[email_auth]" value="1" <?php checked('1', $fbcomment_options['email_auth']); ?> />
                                        <?php _e('If checked, you must provide the SMTP username and password below'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="fbcomments[email_username]"><?php _e('SMTP Username') ?></label>
                                    </th>
                                    <td>
                                        <input type="text" name="fbcomments[email_username]" id="fbcomments[email_username]" value="<?php echo $fbcomment_options['email_username']; ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="fbcomments[email_password]"><?php _e('SMTP Password') ?></label>
                                    </th>
                                    <td>
                                        <input type="password" name="fbcomments[email_password]" id="fbcomments[email_password]" value="<?php echo $fbcomment_options['email_password']; ?>" class="regular-text" />
                                    </td>
                                </tr>
                            </table>
                            <p id="gmail_user_tip" style="display: none;">Be sure to specify your full GMail email address (including the "@gmail.com") as the SMTP username, and your GMail password as the SMTP password.</p>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <label for="fbcomments[email_to_send]"><?php _e('Email Notification') ?></label>
                                </th>
                                <td>
                                    <input type="text" name="fbcomments[email_to_send]" id="fbcomments[email_to_send]" value="<?php echo $fbcomment_options['email_to_send']; ?>" class="regular-text" />
                                    <?php _e('Email will be sent notification.')?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            
            <div class="metabox-holder">
                <div class="postbox">
                    <h3 class="hndle"><span><?php _e('Styling comments box') ?></span></h3>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="fbcomments[scheme]"><?php _e('Color Scheme') ?></label>
                            </th>
                            <td>
                                <input name="fbcomments[scheme]" type="radio" id="fbcomments[scheme_light]" value="light" <?php checked('light', $fbcomment_options['scheme']); ?> />
                                <?php _e('Light Scheme') ?>
                                <br />
                                <input name="fbcomments[scheme]" type="radio" id="fbcomments[scheme_dark]" value="dark" <?php checked('dark', $fbcomment_options['scheme']); ?> />
                                <?php _e('Dark Scheme') ?>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="fbcomments[width]"><?php _e('Width') ?> (px)</label>
                            </th>
                            <td>
                                <input type="text" name="fbcomments[width]" id="fbcomments[width]" value="<?php echo $fbcomment_options['width']; ?>" class="small-text" />
                                <?php echo _e('Default is <strong>450</strong>, minimum must be <strong>350</strong>');?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="metabox-holder">
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="fbcomments" />
                <?php submit_button(); ?>
            </div>
        </div>
    </form>
</div>