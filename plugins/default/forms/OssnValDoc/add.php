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
?>
<input type="hidden" name="user_guid" value="<?php echo htmlspecialchars($params['user_guid']); ?>" />
<input type="hidden" name="token" value="<?php echo htmlspecialchars($params['token']); ?>" />

<label><?php echo ossn_print('diploma:upload:file'); ?></label>
<input type="file" name="ossn_diploma"/>
<div class="margin-top-10">
	<input type="submit" class="btn btn-success btn-sm" value="<?php echo ossn_print('add'); ?>"/>
</div>