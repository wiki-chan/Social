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

$wgExtensionCredits['profile'][] = array(
	'path' => __FILE__,
	'name' => 'Message Board',
	'author' => array('David Pean', '페네트-'),
	'url' => 'https://github.com/wiki-chan/Social',
	'license-name' => 'GPL-2.0',
	'description' => 'Display User Board messages for a user',
);


// resource modules
$wgResourceModules['ext.socialprofile.userboard.js'] = array(
	'scripts' => 'UserBoard.js',
	'messages' => array( 'userboard_confirmdelete' ),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Social/UserBoard',
);

$wgResourceModules['ext.socialprofile.userboard.css'] = array(
	'styles' => 'UserBoard.css',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Social/UserBoard',
	'position' => 'top' // just in case
);

$wgResourceModules['ext.socialprofile.userboard.boardblast.css'] = array(
	'styles' => 'BoardBlast.css',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Social/UserBoard',
	'position' => 'top' // just in case
);

$wgResourceModules['ext.socialprofile.userboard.boardblast.js'] = array(
	'scripts' => 'BoardBlast.js',
	'messages' => array(
		'boardblast-js-sending', 'boardblast-js-error-missing-message',
		'boardblast-js-error-missing-user'
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Social/UserBoard',
);

// Should we display UserBoard-related things on social profile pages?
$wgUserProfileDisplay['board'] = true;
$wgUserBoard = true;

// Internationalization files
$wgMessagesDirs['SocialProfileUserBoard'] = __DIR__ . '/i18n';

// Autoload classes
$wgAutoloadClasses['UserBoard'] = __DIR__ . '/UserBoardClass.php';						// class for control user board messages
$wgAutoloadClasses['SpecialViewUserBoard'] = __DIR__ . '/SpecialUserBoard.php';			// special page for user board view
$wgAutoloadClasses['SpecialBoardBlast'] = __DIR__ . '/SpecialSendBoardBlast.php';		// special page for send 'mass board message'
$wgAutoloadClasses['SendUserBoardMessage'] = __DIR__ . '/APISendUserBoardMessage.php';	// API for send message

// New special pages
$wgSpecialPages['UserBoard'] = 'SpecialViewUserBoard';
$wgSpecialPages['SendBoardBlast'] = 'SpecialBoardBlast';

/**
 * AJAX functions used by UserBoard.
 */
$wgAjaxExportList[] = 'UserBoardAjaxFunctions::wfDeleteBoardMessage';

// API module
$wgAPIModules['social-send-message'] = 'SendUserBoardMessage';