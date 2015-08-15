<?php
/**
 * UserBoard extension
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author 페네트-
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point.\n" );
}

/*
새 메시지 알림 모듈. 이젠 확실하게 제거할 것 by 페네트
$wgResourceModules['userboard.getnewmessage'] = array(
	'scripts' => 'UpdateNewAlert.js',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'SocialProfile/UserBoard',
	'position' => 'bottom'
);
$wgHooks['BeforePageDisplay'][] = 'wfRegisterDisplayNewMessage';

function wfRegisterDisplayNewMessage( OutputPage &$out, Skin &$skin ) {

	$out->addModuleScripts('userboard.getnewmessage');
	return true;
}
*/

$wgHooks['GetAlarmMessage'][] = 'UserBoard::AlarmMessage';