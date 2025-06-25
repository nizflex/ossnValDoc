<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Source Social Network Core Team <info@openteknik.com>
 * @copyright (C) OpenTeknik LLC
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$add = new OssnVD;

$params['user_guid'] = input('guid');
$params['description'] = input('description');
$params['user_token'] = input('token');


if (empty($params['user_guid']) || empty($params['user_token'])) {
    ossn_trigger_message(ossn_print('fields:required'), 'error');
    redirect(REF);
}

 // Check if file is uploaded
 if (!isset($_FILES['validation_doc']) || $_FILES['validation_doc']['error'] == UPLOAD_ERR_NO_FILE) {
    ossn_trigger_message(ossn_print('file:required'), 'error');
    redirect(REF);
}

if (verify_user_token($params['user_guid'],$params['user_token'])) {

    if ($add->addNewVD($params)) {
        ossn_trigger_message(ossn_print('vd:created'), 'success');
        if (set_user_vd_uploaded($params['user_guid'],$params['user_token'])){
            ossn_trigger_message(ossn_print('ossnvaldoc:validated:activation:notified'), 'success');
        
            /* Done in Default.php   
            //send email to notify admin
            $user       = new OssnUser;
			$user->guid = $params['user_guid'];
			$unvalidated_user = $user->getUser();
            $mail_recipient = ossn_site_settings('owner_email');
            $mail_subject   = ossn_print('ossnvaldoc:admin:mail:subject');
            $mail_body      = ossn_print('ossnvaldoc:admin:mail:body', array(
                    $unvalidated_user->first_name,
                    $unvalidated_user->last_name,
                    ossn_site_url('pending_validations/list')
            ));
            $mailer         = new OssnMail;
            $mailer->notifyUser($mail_recipient, $mail_subject, $mail_body);
        */
            }else{
            ossn_trigger_message(ossn_print('ossnvaldoc:validated:activation:notnotified'), 'error');
        }
        redirect('home');
    } else {
        ossn_trigger_message(ossn_print('vd:create:fail'), 'error');
        redirect(REF);
    }

} else {
    ossn_trigger_message(ossn_print('token:bad'), 'error');
    redirect(REF);
}

