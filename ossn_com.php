<?php
/**
 * Open Source Social Network
 * @link      https://www.opensource-socialnetwork.org/
 * @package   Disable Member Self Validating
 * @author    Michael Zülsdorff <ossn@z-mans.net>
 * @copyright staff.ma -	2025
 * @license   GNU General Public License https://www.gnu.de/documents/gpl-2.0.en.html
 */
define('__OSSN_VALDOC__', ossn_route()->com . 'OssnValDoc/');

require_once __OSSN_VALDOC__ . 'classes/OssnVD.php';
require_once __OSSN_VALDOC__ . 'classes/Diploma.php';
require_once __OSSN_VALDOC__ . 'plugins/default.php';


function com_disable_member_self_validating()
{
	//$link       = ossn_site_url("uservalidate/activate/{$this->guid}/{$this->activation}");
	//$link       = ossn_call_hook('user', 'validation:email:url', $this, $link);
	ossn_add_hook('user', 'validation:email:url', 'transformValidationUrl');

	ossn_register_page('diploma', 'diploma_upload_page_handler');
	ossn_register_action('diploma/add', __OSSN_VALDOC__ . 'actions/upload.php');

	if (method_exists(new OssnSite, 'setSetting')) {
		ossn_unregister_page('uservalidate');
		ossn_register_page('uservalidate', 'com_disable_member_self_validating_uservalidate_pagehandler');
		ossn_register_callback('component', 'enabled', 'com_disable_member_self_validating_compatibility_check');
		ossn_unregister_action('user/login');
		ossn_register_action('user/login', __OSSN_VALDOC__ . 'actions/user/login.php');
	} else {
		error_log('DisableMemberSelfValidating: Error version mismatch');
		ossn_trigger_message(ossn_print('ossn:admin:settings:save:error'), 'error');
		$comp = new OssnComponents;
		$comp->DISABLE('DisableMemberSelfValidating');
		redirect(REF);
	}

	if (ossn_isAdminLoggedin()) {
			$pending_validations = array(
				'name'   => 'admin:users:pendingvalidations',
				'text'   => ossn_print('admin:users:pendingvalidations'),
				'href'   => ossn_site_url('pending_validations/list'),
				'parent' => 'admin:sidemenu:usermanager',
			);
			ossn_extend_view('css/ossn.admin.default', 'css/vd.admin');
			ossn_register_page('pending_validations', 'pending_validations_page_handler');
			ossn_register_action('ossnvds/delete', __OSSN_VALDOC__ . 'actions/delete.php');
			ossn_register_menu_item('admin/sidemenu', $pending_validations);
	}
	
	ossn_extend_view('js/opensource.socialnetwork', 'js/DisableMemberSelfValidating');
	ossn_register_page('welcome', 'welcome_page_handler');
	ossn_register_action('uvd', __OSSN_VALDOC__ . 'actions/upload_vd.php');
}

function com_disable_member_self_validating_compatibility_check($event, $type, $params)
{
	$incompatible_coms = array('AnonymousRegistration', 'userautovalidate', 'DisableUserActivationByMail');
	if (in_array($params['component'], $incompatible_coms)) {
		ossn_trigger_message(ossn_print('OssnValdDoc:compatibility:error', array($params['component'])), 'error');
		$com = new OssnComponents;
		$com->DISABLE($params['component']);
	}
}

function com_disable_member_self_validating_uservalidate_pagehandler($pages)
{
	$page = $pages[0];
	if (empty($page)) {
		echo ossn_error_page();
	}
	switch ($page) {
		case 'activate':
			if (!empty($pages[1]) && !empty($pages[2])) {
				$user       = new OssnUser;
				$user->guid = $pages[1];
				$unvalidated_user = $user->getUser();
				if (!$unvalidated_user) {
					ossn_trigger_message(ossn_print('OssnValdDoc:registration:denied'), 'error');
					redirect();
					exit;
				}
				if (strlen($unvalidated_user->activation)) {
					// activation still pending
					if ($unvalidated_user->activation == $pages[2]) {
						// yes, matching key!
						$visits = $unvalidated_user->last_activity;
						if (!$visits) {
							// => first time user validating request - Root unvalidate user to welcome page !
							redirect("welcome/page?guid={$unvalidated_user->guid}&key={$unvalidated_user->activation}");
							exit;
						}
						// subsequent activation requests and pending request to admin has been sent already
						// 2. message to member
						ossn_trigger_message(ossn_print('OssnValdDoc:validated:activation:pending'), 'success');
						redirect('login');
						exit;
					} else {
						// wrong activation key submitted
						ossn_trigger_message(ossn_print('OssnValdDoc:validation:error'), 'error');
						redirect('login');
						exit;
					}
				} else {
					// member already activated by admin
					ossn_trigger_message(ossn_print('OssnValdDoc:account:activated'), 'success');
					redirect('login');
				}
			}
		break;

	}
}

function welcome_page_handler($pages) {
    $title = 'Welcome validation page';

    // Pass the variable to the form view
    $params['user_guid'] = $pages[0];
	$params['user_token'] = $pages[1];

	$content = ossn_set_page_layout('startup', array('content' => ossn_plugin_view('welcome',$params)));
    echo ossn_view_page($title, $content);
}

function pending_validations_page_handler($pages){
	$page = $pages[0];
	if (empty($page)) {
		echo ossn_error_page();
	}
	switch ($page) {
		case 'list':
			$title                = ossn_print('admin:users:pendingvalidations');
			$contents['contents'] = ossn_plugin_view('pending');
			$contents['title']    = $title;
			$content              = ossn_set_page_layout('administrator/administrator', $contents);
			echo ossn_view_page($title, $content, 'administrator');
			break;	
		
		case 'photo':
			$ad = get_vd_entity($pages[1]);
			if(!empty($pages[1]) && !empty($pages[2]) && $ad) {
					$file = $ad->getVDFile();
				error_log(var_export($file, true));	
					if(!$file) {
							ossn_error_page();
					}
					$file->output();
			} else {
					ossn_error_page();
			}
			break;

		case 'delete':
			if(!empty($pages[1]) && !empty($pages[2])) {

				//###############################################
				// 1 Delete user from DB
				//###############################################
				$guid = $pages[1];	
				if(!empty($guid)) {
								$user = ossn_user_by_guid($guid);
								if($user && $user->guid !== ossn_loggedin_user()->guid) {
										if(!$user->deleteUser()) {
												ossn_trigger_message(ossn_print('admin:user:delete:error'), 'error');
										}
								}	
				}
				ossn_trigger_message(ossn_print('admin:user:deleted'), 'success');
			
				//###############################################
				// 2 Delete user's objects/entities from DB
				//###############################################

				$delete = new OssnVD;
				$entity = $pages[2];
					$entity = get_vd_entity((int)$entity);
					if(empty($entity->guid)){
						ossn_trigger_message(ossn_print('vd:delete:fail'), 'error');
					} else {
						if (!$delete->deleteVd($entity->guid)) {
							ossn_trigger_message(ossn_print('vd:delete:fail'), 'error');
						} else {
							ossn_trigger_message(ossn_print('vd:deleted', array($entity->title)), 'success');  
						}	   
					}
				}
				redirect(REF);
			break;
	}
}


/**
 * Get vd image url
 *
 * @params $guid vd guid
 *
 * @return url;
 * @access public
 */
function ossn_vds_image_url($guid) {
	$ad = get_vd_entity($guid);
	return $ad->getVDURL();
}
/**
 * Get vd entity
 *
 * @params $guid vd guid
 *
 * @return object;
 * @access public
 */
function get_vd_entity($guid) {
	if($guid < 1 || empty($guid)) {
			return false;
	}
	$vd = ossn_get_object($guid);
	if($vd) {
			return arrayObject($vd, 'OssnVD');
	}
	return false;
}

function diploma_upload_page_handler($pages) {

    if (!isset($pages[1]) || !isset($pages[2])) {
        ossn_error_page();
    }
    
    $user_guid = (int) $pages[1];
    $token = trim($pages[2]);
    
    // Validate user exists
    $user = ossn_user_by_guid($user_guid);
    if (!$user) {
        ossn_error_page();
    }
    
    // Verify token matches first 10 chars of activation hash
    $activation_hash = $user->activation;
    if (empty($activation_hash) || substr($activation_hash, 0, 10) !== $token) {
        ossn_error_page();
    }
    
	// Prepare page metadata
	ossn_set_page_owner_guid($user->guid);
	$title = ossn_print('diploma:upload:title');
	
	$content = diploma_handle_upload_logic($user);
	$contents = array(
		'content' => $content,
	);
	
	$content = ossn_set_page_layout('contents', $contents);
	echo ossn_view_page($title, $content);
}

function diploma_handle_upload_logic($user) {
    // Case 1: Account already verified
    if (empty($user->activation)) {
		return ossn_view_page(ossn_print('diploma:upload:title'), ossn_plugin_view('output/ok', array('text' => ossn_print('diploma:alreadyverified'))));
    }
    
    // Case 2: Check for existing diploma
    $diploma = Diploma::getByUserGuid($user->guid);
    if ($diploma) {
		// If diploma exists, show message
		ossn_trigger_message(ossn_print('diploma:waitingadmin'), 'success');
		redirect(REF);
	}
    
    // Case 3: Show upload form
	$params = array(
					'content' => ossn_view_form('add', array(
												'action' => ossn_site_url() . 'action/diploma/add',
												'component' => 'OssnValDoc',
												'class' => 'ossn-ads-form',
												'params' => array('user_guid' => $user->guid, 
																  'token' => substr($user->activation, 0, 10)
	 				 								)
										), false));
									
		
		return ossn_plugin_view('diploma/upload', array('form' => $params['content'], 'user_guid' => $user->guid, 'user_token' => substr($user->activation, 0, 10)));
}

function transformValidationUrl($hook, $type, $return, $params) {

	// Replace 'uservalidate/activate' with 'diploma/upload'
    $url = str_replace('uservalidate/activate', 'diploma/upload', $return);
    
    // Find the last slash and extract the hash part
    $lastSlashPos = strrpos($url, '/');
    if ($lastSlashPos !== false) {
        $beforeHash = substr($url, 0, $lastSlashPos + 1);
        $hash = substr($url, $lastSlashPos + 1);
        
        // Keep only first 10 characters of the hash
        $shortHash = substr($hash, 0, 10);
        
        // Reconstruct the URL
        $url = $beforeHash . $shortHash;
    }
    
    return $url;
}

ossn_register_callback('ossn', 'init', 'com_disable_member_self_validating');
