<?php
function verify_user_token($guid, $token) {   
    $user = ossn_user_by_guid($guid);
    return ($user && $user->activation == $token);
}

function get_user_document_url($user_guid) {
    $file = new OssnFile;
    $files = $file->searchFiles(array(
        'type' => 'user',
        'subtype' => 'Validation_Document',
        'owner_guid' => $user_guid
    ));
    if ($files) {
        return $files[0]->getURL();
    }
    return false;
}

function set_user_vd_uploaded($guid, $token){
    $user       = new OssnUser;
    $user->guid = $guid;
    $unvalidated_user = $user->getUser();
    // activation still pending
    if ($unvalidated_user->activation == $token) {
        // yes, matching key!
        $visits = $unvalidated_user->last_activity;
        if (!$visits) {
       
        //send email to notify admin
            $mail_recipient = ossn_site_settings('owner_email');
            $mail_subject   = ossn_print('ossnvaldoc:admin:mail:subject');
            $mail_body      = ossn_print('ossnvaldoc:admin:mail:body', array(
                    $unvalidated_user->first_name,
                    $unvalidated_user->last_name,
                    ossn_site_url('pending_validations/list')
            ));
            $mailer         = new OssnMail;
            $mailer->notifyUser($mail_recipient, $mail_subject, $mail_body);

        //Update DB
            $visits++;
            $params['table']  = 'ossn_users';
            $params['names']  = array(
                'last_activity'
            );
            $params['values'] = array(
                $visits
            );
            $params['wheres'] = array(
                "guid='{$unvalidated_user->guid}'"
            );
            $OssnDatabase     = new OssnDatabase;
            $OssnDatabase->update($params);
            return true;            
        }
        return false;
    }
    return false;
}

function get_unvalidated_users_with_documents($search = '', $count = false) {
    $users = new OssnUser;
    if($count) {
            $params['count'] = true;
    }
    if(empty($search)) {
            $params['wheres'] = array(
                    "activation <> ''","last_activity <> '0'",
            );
    } else {
            $params['wheres'] = array(
                    "activation <> ''", "last_activity <> '0'",
                    "CONCAT(first_name, ' ', last_name) LIKE '%$search%' AND activation <> '' OR
                  username LIKE '%$search%' AND activation <> '' OR email LIKE '%$search%' AND activation <> ''",
            );
    }
    $result = $users->searchUsers($params);
    if($result) {
            return $result;
    }
    return false;
}