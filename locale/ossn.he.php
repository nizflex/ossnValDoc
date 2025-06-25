<?php
/**
 * Open Source Social Network
 * @link      https://www.opensource-socialnetwork.org/
 * @package   Disable Member Self Validating
 * @author    Michael Zülsdorff <ossn@z-mans.net>
 * @copyright (C) Michael Zülsdorff
 * @license   GNU General Public License https://www.gnu.de/documents/gpl-2.0.en.html
 */
ossn_register_languages('he', array(
	'com:disable:member:self:validating:registration:denied' => "We're sorry, but unfortunately we had to decline your registration request.",
	'com:disable:member:self:validating:validation:error' => 'Validation failed - please verify the link we sent to you and try again.',
	'com:disable:member:self:validating:validated:activation:notified' => 'Validation successful - your account will be activated soon - please be patient.',
	'com:disable:member:self:validating:validated:activation:pending' => 'Stay tuned - the admin has been notified - your account will be activated soon.',
	'com:disable:member:self:validating:validated:confirmation:pending' => 'You did not confirm your email address yet - check your incoming mails, please .',
	'com:disable:member:self:validating:account:activated' => 'Your account has been activated - feel free to login.',
	'com:disable:member:self:validating:admin:mail:subject' => 'New member activation pending',
	'com:disable:member:self:validating:admin:mail:body' => 'A new activation request from %s %s is pending on %s',
	'com:disable:member:self:validating:compatibility:error' => '<b>%s</b> cannot be enabled as long as <b>DisableUserActivationByMail</b> is activated',
	'account:created:email' => "Step 1: Your account has been registered successfully.<br>
	 Step 2: Check your inbox and click the link included in our mail to confirm your email address.<br>
	 Step 3: Wait for your account to be activated. Please note that this may take some hours.",
	'ossn:add:user:mail:body' => "Hello, and thank you for registering with %s!

Next, please confirm your email address by clicking the link below:

%s

You may copy and paste the address to your browser in case the link is not clickable.

Your account will be activated manually by the administrator after your confirmation has been verified. This may take some hours - so please be patient.

Kind regards.",
));
