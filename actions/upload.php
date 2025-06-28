<?php
/**
 * DiplomaVerifier Diploma Upload Action
 * 
 * @package DiplomaVerifier
 * @license OSSN v8.1
 */
 
// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ossn_error_page();
}

// CSRF protection
ossn_call_hook('action', 'validate', 'csrf');

// Get and sanitize input
$user_guid = (int) input('user_guid');
$user      = ossn_user_by_guid($user_guid);

if (!$user) {
    ossn_trigger_message(ossn_print('diploma:usernotfound'), 'error');
    redirect(REF);
}

// Check activation token in URL (for extra security, you may require the token as hidden input)
$token = input('token');
if (empty($user->activation) || substr($user->activation, 0, 10) !== $token) {
    ossn_error_page();
}

// Check if already verified
if (empty($user->activation)) {
    ossn_trigger_message(ossn_print('diploma:alreadyverified'), 'error');
    redirect(REF);
}

// Check for existing diploma upload
if (Diploma::getByUserGuid($user_guid)) {
    ossn_trigger_message(ossn_print('diploma:waitingadmin'), 'error');
    redirect(REF);
}

// File validation

if (!isset($_FILES['ossn_diploma']) || $_FILES['ossn_diploma']['error'] !== UPLOAD_ERR_OK) {
    
    ossn_trigger_message(ossn_print('diploma:upload:error'), 'error');
    redirect(REF);
}

// Validate file type and size
$file = $_FILES['ossn_diploma'];
$allowed_ext  = array('jpg', 'jpeg', 'pdf');
$allowed_mime = array('image/jpeg', 'application/pdf');
$max_size     = 5 * 1024 * 1024; // 5MB

$ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$mime = mime_content_type($file['tmp_name']);

if (!in_array($ext, $allowed_ext) || !in_array($mime, $allowed_mime)) {
    ossn_trigger_message(ossn_print('diploma:upload:invalidtype'), 'error');
    redirect(REF);
}

if ($file['size'] > $max_size) {
    ossn_trigger_message(ossn_print('diploma:upload:toolarge'), 'error');
    redirect(REF);
}
    
// Prevent path traversal
if (strpos($file['name'], '..') !== false) {
    ossn_trigger_message(ossn_print('diploma:upload:error'), 'error');
    redirect(REF);
}
// Prepare file object


// Store file using Diploma entity
$diploma = new Diploma;
$diploma->owner_guid = $user_guid;
$diploma->type = 'user';
$diploma->subtype = 'diploma:file';
$diploma->file = $file;
$success = $diploma->addFile($file, $user_guid);


if ($success) {
    ossn_trigger_message(ossn_print('diploma:success'), 'success');
    ossn_trigger_message(ossn_print('diploma:waitingadmin'), 'success');
    //set user's last activity to :'1'
    $user = ossn_user_by_guid($user_guid);
    if ($user) {
        $user->last_activity = '1';
        $user->save();
    }
    redirect('home');
} else {
    ossn_trigger_message(ossn_print('diploma:upload:error'), 'error');
    redirect('home');
}
