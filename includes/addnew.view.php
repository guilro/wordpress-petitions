<?php
    if (version_compare(get_bloginfo('version'), '3.3.4', '<') == 1) {
        echo '
			<style type-"text/css">
			#guilro-petitions .misc-pub-section {
				float: none !important;
				max-width: 100% !important;
				border-bottom: 1px solid #dfdfdf !important;
				border-top: 1px solid #fff !important;
				padding: 4px 10px 0;

			}
			#guilro-petitions .misc-pub-section-last { border-bottom: none !important; }
			#guilro-petitions .postbox-container {
				position: absolute;
				top: 56px;
				right: 15px;
				width: 280px;
			}
			#guilro-petitions #post-body-content {
				margin-right: 300px;
				position: relative;
			}
			#guilro-petitions #major-publishing-actions { padding-bottom: 0; }

			.guilro-petitions-checkbox input { vertical-align: text-top; }
			#guilro-petitions input[type="checkbox"] {
			    margin: 1px 0 0;
			    padding: 0 !important;
			    vertical-align: text-top;
			}
			#guilro-petitions .postbox .inside { margin: 0 !important; }
			#guilro-petitions #minor-publishing:first-child {
    			padding-top: 6px;
			}
			#guilro-petitions .sends_email { margin-top: 0 !important; }
			#guilro-petitions #post-body-content .postbox { padding-bottom: .75em; }
			#guilro-petitions .inside textarea#twitter_message { margin-top: .5em; }
			</style>
		';
    }
?>

<div class="wrap" id="guilro-petitions">

	<div id="icon-guilro-petitions" class="icon32"><br /></div>
	<h2><?php echo $page_title; ?></h2>
	<?php if ($message_update) {
    echo '<div id="message" class="updated"><p>'.$message_update.'</p></div>';
} ?>
	<div id="message" class="error guilro-petitions-error-msg"><p><?php _e('Error: Please correct the highlighted fields.'); ?></p></div>

	<form name="guilro-petitions-edit-petition" id="guilro-petitions-edit-petition" method="post" action="">
		<?php wp_nonce_field($nonce); ?>
		<input type="hidden" name="action" value="<?php echo $action; ?>" />
		<?php if ($petition->id) {
    echo '<input type="hidden" name="id" value="'.esc_attr($petition->id).'" />';
} ?>


<div id="poststuff">

	<div id="post-body" class="metabox-holder columns-2">
		<div id="post-body-content">

			<div id="titlediv">
				<div id="titlewrap">
					<label class="hide-if-no-js" style="visibility:hidden" id="title-prompt-text" for="title"><?php _e('Enter title here', 'guilro_petitions'); ?></label>
					<input type="text" name="title" size="30" tabindex="1" value="<?php echo stripslashes(esc_attr($petition->title)); ?>" id="title" />
				</div>
			</div>

			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class='hndle'><?php _e('Petition', 'guilro_petitions'); ?></h3>
				<div class="inside">
					<div class="guilro-petitions-checkbox sends_email">
						<input type="checkbox" name="sends_email" id="sends_email" <?php if ($petition->sends_email == '0') {
    echo 'checked="checked"';
} ?> />
						<label for="sends_email" class="guilro-petitions-inline"><?php _e('Do not send email (only collect signatures)', 'guilro_petitions'); ?></label>
					</div>
					<div class="guilro-petitions-petition-content">
						<div class="guilro-petitions-email-headers">
							<label for="target_email"><?php _e('Target Email', 'guilro_petitions'); ?></label>
							<input name="target_email" id="target_email" value="<?php echo esc_attr($petition->target_email); ?>" size="40" maxlength="300" type="text" />

							<label for="email_subject"><?php _e('Email Subject', 'guilro_petitions'); ?></label>
							<input name="email_subject" id="email_subject" value="<?php echo stripslashes(esc_attr($petition->email_subject)); ?>" size="40" maxlength="80" type="text" />

							<label for="greeting"><?php _e('Greeting', 'guilro_petitions'); ?></label>
							<input name="greeting" id="greeting" value="<?php echo stripslashes(esc_attr($petition->greeting)); ?>" size="40" maxlength="80" type="text" />
						</div>
					</div>

					<label for="petition_message"><?php _e('Petition Message', 'guilro_petitions'); ?></label>
					<textarea name="petition_message" id="petition_message" rows="10" cols="80"><?php echo stripslashes(esc_textarea($petition->petition_message)); ?></textarea>
				</div>
			</div>

			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class='hndle'><?php _e('Twitter Message', 'guilro_petitions'); ?></h3>
				<div class="inside">
					<textarea name="twitter_message" id="twitter_message" rows="2" cols="80"><?php echo stripslashes(esc_textarea($petition->twitter_message)); ?></textarea>
					<div id="twitter-counter"></div>
				</div>
			</div>

		</div>


		<div id="postbox-container-1" class="postbox-container">
		<div id="side-sortables" class="meta-box-sortables">

			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class='hndle'><?php _e('Petition Options', 'guilro_petitions'); ?></h3>
				<div class="inside">

					<div id="minor-publishing">

						<!-- Email Confirmation -->
						<div class="misc-pub-section">
							<div class="guilro-petitions-checkbox">
								<input type="checkbox" name="requires_confirmation" id="requires_confirmation" <?php if ($petition->requires_confirmation == 1) {
    echo 'checked="checked"';
} ?> />
								<label for="requires_confirmation" class="guilro-petitions-inline"><?php _e('Confirm signatures', 'guilro_petitions'); ?></label>
							</div>
							<div class="guilro-petitions-returnurl guilro-petitions-subsection <?php if ($petition->requires_confirmation != 1) {
    echo 'guilro-petitions-hidden';
} ?>">
								<label for="return_url"><?php _e('Return URL', 'guilro_petitions'); ?>:</label>
								<input id="return_url" name="return_url" value="<?php echo esc_attr($petition->return_url); ?>" size="30" maxlength="200" type="text" />
							</div>
						</div>

						<!-- Editable -->
						<div class="misc-pub-section">
							<div class="guilro-petitions-checkbox">
								<input type="checkbox" name="is_editable" id="is_editable" <?php if ($petition->is_editable == 1) {
    echo 'checked="checked"';
} ?> />
								<label for="is_editable" class="guilro-petitions-inline"><?php _e('Allow custom messages', 'guilro_petitions'); ?></label>
							</div>
						</div>

						<!-- Signature Goal -->
						<div class="misc-pub-section">
							<div class="guilro-petitions-checkbox">
								<input type="checkbox" name="has_goal" id="has_goal" <?php if ($petition->goal > 0) {
    echo 'checked="checked"';
} ?> />
								<label for="has_goal" class="guilro-petitions-inline"><?php _e('Set signature goal', 'guilro_petitions'); ?></label>
							</div>
							<div class="guilro-petitions-goal guilro-petitions-subsection <?php if ($petition->goal < 1) {
    echo 'guilro-petitions-hidden';
} ?>">
								<label for="goal"><?php _e('Goal', 'guilro_petitions'); ?>:</label>
								<input id="goal" name="goal" value="<?php echo esc_attr($petition->goal); ?>" size="8" maxlength="8" type="text" />
							</div>
						</div>

						<!-- Expiration Date -->
						<div class="misc-pub-section misc-pub-section-last">
							<div class="guilro-petitions-checkbox">
								<input type="checkbox" name="expires" id="expires" <?php if ($petition->expires == 1) {
    echo 'checked="checked"';
} ?> />
								<label for="expires" class="guilro-petitions-inline"><?php _e('Set expiration date', 'guilro_petitions'); ?></label>
							</div>
							<div class="guilro-petitions-date guilro-petitions-subsection <?php if ($petition->expires != 1) {
    echo 'guilro-petitions-hidden';
} ?>">
								<select id="month" name="month">
									<option value="01" <?php if ($x_date['month'] == '01') {
    echo 'selected="selected"';
} ?>><?php _e('Jan', 'guilro_petitions'); ?></option>
									<option value="02" <?php if ($x_date['month'] == '02') {
    echo 'selected="selected"';
} ?>><?php _e('Feb', 'guilro_petitions'); ?></option>
									<option value="03" <?php if ($x_date['month'] == '03') {
    echo 'selected="selected"';
} ?>><?php _e('Mar', 'guilro_petitions'); ?></option>
									<option value="04" <?php if ($x_date['month'] == '04') {
    echo 'selected="selected"';
} ?>><?php _e('Apr', 'guilro_petitions'); ?></option>
									<option value="05" <?php if ($x_date['month'] == '05') {
    echo 'selected="selected"';
} ?>><?php _e('May', 'guilro_petitions'); ?></option>
									<option value="06" <?php if ($x_date['month'] == '06') {
    echo 'selected="selected"';
} ?>><?php _e('Jun', 'guilro_petitions'); ?></option>
									<option value="07" <?php if ($x_date['month'] == '07') {
    echo 'selected="selected"';
} ?>><?php _e('Jul', 'guilro_petitions'); ?></option>
									<option value="08" <?php if ($x_date['month'] == '08') {
    echo 'selected="selected"';
} ?>><?php _e('Aug', 'guilro_petitions'); ?></option>
									<option value="09" <?php if ($x_date['month'] == '09') {
    echo 'selected="selected"';
} ?>><?php _e('Sep', 'guilro_petitions'); ?></option>
									<option value="10" <?php if ($x_date['month'] == '10') {
    echo 'selected="selected"';
} ?>><?php _e('Oct', 'guilro_petitions'); ?></option>
									<option value="11" <?php if ($x_date['month'] == '11') {
    echo 'selected="selected"';
} ?>><?php _e('Nov', 'guilro_petitions'); ?></option>
									<option value="12" <?php if ($x_date['month'] == '12') {
    echo 'selected="selected"';
} ?>><?php _e('Dec', 'guilro_petitions'); ?></option>
								</select>
								<input id="day" name="day" value="<?php echo esc_attr($x_date['day']); ?>" size="2" maxlength="2" type="text" />
								,
								<input id="year" name="year" value="<?php echo esc_attr($x_date['year']); ?>" size="4" maxlength="4" type="text" />
								@
								<input id="hour" name="hour" value="<?php echo esc_attr($x_date['hour']); ?>" size="2" maxlength="2" type="text" />
								:
								<input id="minutes" name="minutes" value="<?php echo esc_attr($x_date['minutes']); ?>" size="2" maxlength="2" type="text" />
							</div>
						</div>

						<div id="major-publishing-actions">
							<input type="submit" name="Submit" id="guilro_petitions_submit" value="<?php echo esc_attr($button_text); ?>" class="button-primary" />
						</div>

					</div>
				</div>
			</div>

			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3 class='hndle'><?php _e('Display Options', 'guilro_petitions'); ?></h3>
				<div class="inside">

					<div id="minor-publishing">

						<!-- Address Field -->
						<div class="misc-pub-section">
							<div class="guilro-petitions-checkbox">
								<input type="checkbox" name="display-address" id="display-address" <?php if (count($petition->address_fields) > 0) {
    echo 'checked="checked"';
} ?> />
								<label for="display-address" class="guilro-petitions-inline"><?php _e('Display address fields', 'guilro_petitions'); ?></label>
							</div>
							<div class="guilro-petitions-address guilro-petitions-subsection <?php if (count($petition->address_fields) == 0) {
    echo 'guilro-petitions-hidden';
} ?>">
								<input type="checkbox" id="street" name="street" <?php if (in_array('street', $petition->address_fields)) {
    echo 'checked="checked"';
} ?> />
								<label for="street" ><?php _e('Street', 'guilro_petitions'); ?></label><br/>
	
								<input type="checkbox" id="city" name="city" <?php if (in_array('city', $petition->address_fields)) {
    echo 'checked="checked"';
} ?> />
								<label for="city"><?php _e('City', 'guilro_petitions'); ?></label><br/>
	
								<input type="checkbox" id="state" name="state" <?php if (in_array('state', $petition->address_fields)) {
    echo 'checked="checked"';
} ?> />
								<label for="state"><?php _e('State / Province', 'guilro_petitions'); ?></label><br/>
	
								<input type="checkbox" id="postcode" name="postcode" <?php if (in_array('postcode', $petition->address_fields)) {
    echo 'checked="checked"';
} ?> />
								<label for="postcode"><?php _e('Post Code', 'guilro_petitions'); ?></label><br/>
	
								<input type="checkbox" id="country" name="country" <?php if (in_array('country', $petition->address_fields)) {
    echo 'checked="checked"';
} ?> />
								<label for="country"><?php _e('Country', 'guilro_petitions'); ?></label>
							</div>
						</div>

						<!-- Custom Field -->
						<div class="misc-pub-section">
							<div class="guilro-petitions-checkbox">
								<input type="checkbox" name="displays-custom-field" id="displays-custom-field" <?php if ($petition->displays_custom_field == 1) {
    echo 'checked="checked"';
} ?> />
								<label for="displays-custom-field" class="guilro-petitions-inline"><?php _e('Display custom field', 'guilro_petitions'); ?></label>
							</div>
							<div class="guilro-petitions-custom-field guilro-petitions-subsection <?php if ($petition->displays_custom_field != 1) {
    echo 'guilro-petitions-hidden';
} ?>">
								<label for="custom-field-label"><?php _e('Label', 'guilro_petitions'); ?>:</label>
								<input id="custom-field-label" name="custom-field-label" value="<?php echo stripslashes(esc_attr($petition->custom_field_label)); ?>" size="30" maxlength="200" type="text" />
							</div>
						</div>

						<!-- Email Opt-in -->
						<div class="misc-pub-section misc-pub-section-last">
							<div class="guilro-petitions-checkbox">
								<input type="checkbox" name="displays-optin" id="displays-optin" <?php if ($petition->displays_optin == '1') {
    echo 'checked="checked"';
} ?> />
								<label for="displays-optin" class="guilro-petitions-inline"><?php _e('Display opt-in checkbox', 'guilro_petitions'); ?></label>
							</div>
							<div class="guilro-petitions-optin guilro-petitions-subsection <?php if ($petition->displays_optin != '1') {
    echo 'guilro-petitions-hidden';
} ?>">
								<label for="optin-label"><?php _e('Label', 'guilro_petitions'); ?>:</label>
								<input id="optin-label" name="optin-label" value="<?php echo stripslashes(esc_attr($petition->optin_label)); ?>" size="30" maxlength="200" type="text" />
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>
		</div>

	</div>
</div>



	</form>

</div>