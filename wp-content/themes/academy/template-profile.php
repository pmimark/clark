<?php
    global $current_user;
    $user_data = get_user_meta($current_user->ID,'user_data',true);
    //pa($user_data,1);
?>
<div class="user-image">			
	<div class="bordered-image thick-border">
		<?php echo get_avatar(ThemexUser::$data['user']['ID'], 200); ?>
	</div>
	<div class="user-image-uploader">
		<form action="<?php echo themex_url(); ?>" enctype="multipart/form-data" method="POST">
			<label for="avatar" class="button upload-btn"><span class="button-icon upload"></span><?php _e('Upload','academy'); ?></label>
			<input type="file" class="shifted" id="avatar" name="avatar" />
			<input type="hidden" name="user_action" value="update_avatar" />
			<input type="hidden" name="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
		</form>
	</div>
</div>
<div class="user-description">
	<form action="<?php echo AJAX_URL ?>" class="formatted-form" method="POST">
        <?php if(!empty($user_data)){ ?>
    		<?php foreach($user_data as $key => $field){ ?>
                <div class="sixcol column">
                    <label><?php echo $field['title'] ?></label>
                    <div>
                        <input type="hidden" name="data[<?php echo $key ?>][title]" value="<?php echo $field['title'] ?>" />
                        <input type="text" name="data[<?php echo $key ?>][value]" value="<?php echo $field['value'] ?>" />
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        <input type="hidden" name="user_id" value="<?php echo ThemexUser::$data['user']['ID'] ?>" />
        <input type="hidden" name="action" value="resourceAjax" />
        <input type="hidden" name="method" value="updateUser" />
        <input type="hidden" name="redirect" value="<?php echo themex_url(); ?>" />
        <a href="#" class="button submit-button"><span class="button-icon save"></span><?php _e('Save Changes','academy'); ?></a>
    </form>
</div>