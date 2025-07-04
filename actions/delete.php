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
$delete = new OssnVD;
$entites = $_REQUEST['entites'];
foreach($entites as $entity){
   $entity = get_ad_entity((int)$entity);
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