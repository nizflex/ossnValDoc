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
<input type="hidden" name="guid" value="<?php echo $params['user_guid']; ?>" required>
<input type="hidden" name="token" value="<?php echo $params['user_token']; ?>" required>

<label><?php echo ossn_print('vd:photo'); ?></label>
<input type="file" name="validation_doc" required/>

<div class="margin-top-10">
	<input type="submit"  value="<?php echo ossn_print('validation:upload:document'); ?> " class="btn btn-primary"/>
</div>

