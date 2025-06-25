<?php
/**
 * Open Source Social Network
 * @link      https://www.opensource-socialnetwork.org/
 * @package   Disable Member Self Validating
 * @author    Michael Zülsdorff <ossn@z-mans.net>
 * @copyright (C) Michael Zülsdorff
 * @license   GNU General Public License https://www.gnu.de/documents/gpl-2.0.en.html
 */
ossn_register_languages('de', array(
	'com:disable:member:self:validating:registration:denied' => 'Es tut uns leid, aber wir müssen deine Registrierungs-Anfrage leider ablehnen.',	
	'com:disable:member:self:validating:validation:error' => 'Validierung fehlgeschlagen. Bitte überprüfe den von uns gesendeten Link und versuche es erneut.',
	'com:disable:member:self:validating:validated:activation:notified' => 'Validierung erfolgreich - Dein Konto wird in Kürze aktiviert - hab bitte etwas Geduld.',
	'com:disable:member:self:validating:validated:activation:pending' => 'Dran bleiben – der Administrator wurde benachrichtigt – Dein Konto wird in Kürze aktiviert.',
	'com:disable:member:self:validating:validated:confirmation:pending' => 'Du hast Deine E-Mail-Adresse noch nicht bestätigt – überprüfe bitte Deinen Posteingang .',
	'com:disable:member:self:validating:account:activated' => 'Dein Konto wurde aktiviert - Du kannst dich nun anmelden.',
	'com:disable:member:self:validating:admin:mail:subject' => 'Aktivierung eines neuen Mitglieds ausstehend',
	'com:disable:member:self:validating:admin:mail:body' => 'Eine neue Aktivierungsanfrage von %s %s steht bei %s aus',
	'com:disable:member:self:validating:compatibility:error' => '<b>%s</b> kann nicht aktiviert werden solange <b>DisableUserActivationByMail</b> gleichzeitig aktiviert ist',
	'account:created:email' => "Schritt 1: Dein Benutzer-Konto wurde erfolgreich registriert.<br>
	 Schritt 2: Überprüfe Deinen Posteingang und klicke auf den in unserer E-Mail enthaltenen Link, um Deine E-Mail-Adresse zu bestätigen.<br>
	 Schritt 3: Warte, bis Dein Konto aktiviert ist. Dies kann einige Stunden dauern.",
	 'ossn:add:user:mail:body' => "Hallo und vielen Dank für Deine Registrierung bei %s!

Bitte bestätige als Nächstes Deine E-Mail-Adresse, indem Du auf den untenstehenden Link klickst:
	 
%s
	 
Du kannst die Adresse auch kopieren und in Deinen Browser einfügen, falls der Link nicht anklickbar ist.
	 
Dein Benutzer-Konto wird vom Administrator manuell aktiviert, nachdem Deine Bestätigung überprüft wurde. Dies kann einige Stunden dauern – also hab bitte etwas Geduld.
	 
Mit freundlichen Grüßen.",
)); 
