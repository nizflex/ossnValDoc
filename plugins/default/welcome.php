<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network (OSSN)
 * @author    OSSN Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$guid = isset($_GET['guid']) ? $_GET['guid'] : '';
$key = isset($_GET['key']) ? $_GET['key'] : '';
$custom_settings = ossn_goblue_get_custom_logos_bgs_setting();

// Authentify User and check unvalidated status + Document not uploaded yet
if (!empty($guid) && !empty($key)) {
	$user       = new OssnUser;
	$user->guid = $guid;
	$unvalidated_user = $user->getUser();
	
	if (!$unvalidated_user) {
		ossn_trigger_message(ossn_print('com:disable:member:self:validating:registration:denied'), 'error');
		redirect();
		exit;
	}
	if (strlen($unvalidated_user->activation)) {
		// activation still pending
		if ($unvalidated_user->activation == $key) {
			// yes, matching key!
			error_log($unvalidated_user->activation);
			$visits = $unvalidated_user->last_activity;
			if (!$visits) {

				// No document uploaded yet
				error_log($visits);

			}else{
				//Validation Document already uploaded - please wait for validation
				ossn_trigger_message(ossn_print('com:disable:member:self:validating:validated:activation:pending'), 'success');
				redirect('login');
				exit;
			}
		}else{
			//Bad Key
			ossn_trigger_message(ossn_print('com:disable:member:self:validating:validation:error'), 'error');
			redirect('login');
		}
	}else{
		redirect('login');
	}
}else{
	redirect('login');
}

?>


<div class="row ossn-page-contents">
		<div class="col-lg-6 home-left-contents">
			<div class="logo">
            	<?php if(isset($custom_settings) && isset($custom_settings['logo_site'])){ ?>
            		<img src="<?php echo ossn_add_cache_to_url(ossn_theme_url("logos_backgrounds/logo_site_{$custom_settings['logo_site']}"));?>" />
                <?php } else { ?>
            		<img src="<?php echo ossn_theme_url();?>images/logo.png" />                
                <?php } ?>
            </div>	          
 	   </div>   
	   
       <div class="col-lg-6">
    	<?php 
			$user_guid = $guid;
			$user_token = $key;
			$params['user_guid'] = $guid;
			$params['user_token'] = $key;

			$contents = ossn_view_form('upload_vd', array(
						'id' => 'ossn-uvd',
						'action' => ossn_site_url('action/uvd'),
						'params' => $params
			));
			$heading = "<p>".ossn_print('validation:welcome:msg')."</p>";
			$name = ossn_user_by_guid($guid)->fullname; ;
			$heading = sprintf($heading,$name);
			echo ossn_plugin_view('widget/view', array(
						'title' => ossn_print('validate:account'),
						'contents' => $heading.$contents,
			));
		?>	       			
       </div>     
</div>	
