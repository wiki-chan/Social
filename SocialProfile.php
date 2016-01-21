<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die(
		'This is the setup file for the Social extension to MediaWiki. ' .
		'Please see https://github.com/wiki-chan/Social for ' .
		'more information about this extension.'
	);
}

//$wgNamespacesWithSubpages[NS_USER] = false;

# 가상의 권한인 disabled라는 권한이 있어야만 편집이 가능함 = 편집 불가
//$wgNamespaceProtection[NS_USER_TALK] = array( 'disabled' );

/**
 * This is the loader file for the Social extension.
 *
 * For more info about SocialProfile, please see https://github.com/wiki-chan/Social
 */

// Internationalization files
$wgMessagesDirs['SocialProfile'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['SocialProfileAlias'] = __DIR__ . '/SocialProfile.alias.php';
$wgExtensionMessagesFiles['SocialProfileNamespaces'] = __DIR__ . '/SocialProfile.namespaces.php';

// Classes to be autoloaded
$wgAutoloadClasses['SocialProfileInitClass'] = __DIR__ . '/SocialProfileInitClass.php';

// Necessary AJAX functions
// TODO: 별도 클래스로 각각 분리할 것
//require_once( __DIR__ . "/UserStatus/UserStatus_AjaxFunctions.php" );

// Whether to enable friending or not -- this doesn't do very much actually, so don't rely on it
$wgFriendingEnabled = true;

// Prefix SocialProfile will use to store avatars
// for global avatars on a wikifarm or groups of wikis,
// set this to something static.
$wgHooks['ParserFirstCallInit'][] = 'SocialProfileInitClass::setAvatarKey';

// Extension credits that show up on Special:Version
$wgExtensionCredits['profile'][] = array(
	'path' => __FILE__,
	'name' => 'Social',
	'author' => array( 'Aaron Wright', 'David Pean', 'Jack Phoenix', '페네트-' ),
	'version' => '1.7.4',
	'url' => 'https://github.com/wiki-chan/Social',
	'license-name' => 'GPL-2.0',
	'descriptionmsg' => 'socialprofile-desc',
);

// Hooked functions
$wgAutoloadClasses['SocialProfileHooks'] = __DIR__ . '/SocialProfileHooks.php';

// Loader files
//require_once( __DIR__ . "/UserGifts/Gifts.php" ); // UserGifts (user-to-user gifting functionality) loader file
//require_once( __DIR__ . "/SystemGifts/SystemGifts.php" ); // SystemGifts (awards functionality) loader file
//require_once( __DIR__ . "/UserActivity/UserActivity.php" ); // UserActivity - recent social changes


$wgHooks['BeforePageDisplay'][] = 'SocialProfileHooks::onBeforePageDisplay';
$wgHooks['CanonicalNamespaces'][] = 'SocialProfileHooks::onCanonicalNamespaces';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'SocialProfileHooks::onLoadExtensionSchemaUpdates';

// For the Renameuser extension
$wgHooks['RenameUserComplete'][] = 'SocialProfileHooks::onRenameUserComplete';

// ResourceLoader module definitions for certain components which do not have
// their own loader file

// General
$wgResourceModules['ext.socialprofile.clearfix'] = array(
	'styles' => 'clearfix.css',
	'position' => 'top',
	'localBasePath' => __DIR__ . '/shared',
	'remoteExtPath' => 'SocialProfile/shared',
);

$wgResourceModules['ext.socialprofile.responsive'] = array(
	'styles' => 'responsive.less',
	'position' => 'top',
	'localBasePath' => __DIR__ . '/shared',
	'remoteExtPath' => 'SocialProfile/shared',
);

// General/shared JS modules -- not (necessarily) directly used by SocialProfile,
// but rather by other social tools which depend on SP
// @see https://phabricator.wikimedia.org/T100025
$wgResourceModules['ext.socialprofile.flash'] = array(
	'scripts' => 'flash.js',
	'position' => 'bottom',
	'localBasePath' => __DIR__ . '/shared',
	'remoteExtPath' => 'SocialProfile/shared',
);

$wgResourceModules['ext.socialprofile.LightBox'] = array(
	'scripts' => 'LightBox.js',
	'position' => 'bottom',
	'localBasePath' => __DIR__ . '/shared',
	'remoteExtPath' => 'SocialProfile/shared',
);

// End ResourceLoader stuff