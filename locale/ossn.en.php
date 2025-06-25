<?php
/**
 * Open Source Social Network
 * @link      https://www.opensource-socialnetwork.org/
 * @package   Disable Member Self Validating
 * @author    Michael Zülsdorff <ossn@z-mans.net>
 * @copyright (C) Michael Zülsdorff
 * @license   GNU General Public License https://www.gnu.de/documents/gpl-2.0.en.html
 */
ossn_register_languages('en', array(
	'ossnvaldoc:registration:denied' => "We're sorry, but unfortunately we had to decline your registration request.",
	'ossnvaldoc:validation:error' => 'Validation failed - please verify the link we sent to you and try again.',
	'ossnvaldoc:validated:activation:notified' => 'Validation successful - your account will be activated soon - please be patient.',
	'ossnvaldoc:validated:activation:pending' => 'Stay tuned - the admin has been notified - your account will be activated soon.',
	'ossnvaldoc:validated:confirmation:pending' => 'You did not confirm your email address yet - check your incoming mails, please .',
	'ossnvaldoc:account:activated' => 'Congratulations! Your account has been activated - Good stafing...',
	'ossnvaldoc:admin:mail:subject' => 'New member activation pending',
	'ossnvaldoc:admin:mail:body' => 'A new activation request from %s %s is pending on %s',
	'ossnvaldoc:compatibility:error' => '<b>%s</b> cannot be enabled as long as <b>DisableUserActivationByMail</b> is activated',
	'account:created:email' => "Step 1: Your account has been registered successfully.<br>
	 Step 2: Check your inbox and click the link included in our mail to confirm your email address and upload your Diploma.<br>
	 Step 3: Wait for your account to be activated. Please note that this may take some hours.",
	'ossn:add:user:mail:body' => "Hello, and thank you for registering with %s!

		Next, please confirm your email address by clicking the link below:

		%s

		You may copy and paste the address to your browser in case the link is not clickable.

		Your account will be activated manually by the administrator after your confirmation has been verified. This may take some hours - so please be patient.

		Kind regards.",
	'ossnvd' => 'Validation Documents Manager',
    'fields:required' => 'Some required fields (guid,token, or others...) are missing!',
	'file:required' => 'You should select your validation document (photo or pdf)!',
    'vd:created' => 'Your validation document has been uploaded successfully!',
    'vd:create:fail' => 'Your validation document could not be uploaded!',
    'vd:desc' => 'Description or comment (if needed!)',
    'vd:photo' => 'Photo or pdf:',
    'vd:browse' => 'Browse',
	'validate:account' => 'Final step to quality staffing...!',
	'vd:deleted' => "Validation Doc. with the title of '%s' has been successfully deleted.",
	'vd:delete:fail' => 'Cannot delete validation document! Please try again later.',
	'admin:users:pendingvalidations' => 'Pending Validations',
	'validation:welcome:msg' => " <strong> Dear %s,</strong><br>
					Welcome to Staff.ma, the exclusive social network for healthcare professionals!
				We're delighted to welcome you to our platform dedicated to healthcare professionals. As reliable professional network, to ensure the integrity and confidentiality of our community, we kindly ask you to complete a simple verification process:<br>
				<strong><ol>
				<li> Upload a photo of your professional diploma.</li><br>
				<li> Our administrative team will verify the document's authenticity.</li><br>
				<li> Your account will be activated, quickly after validated.</li>
				</ol></strong>
				This quick verification allows us to maintain a safe environment conducive to quality professional exchanges. Your diploma will be treated confidentially and used only for verification purposes.

				We look forward to having you as an active member. Together, let's build a strong and supportive staffing medical community!

				<br><br>The Staff.ma Team, <br>Kind regards.",
	'validation:upload:document' => 'Upload Validation Document',
));
