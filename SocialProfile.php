<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die(
		'This is the setup file for the Social extension to MediaWiki.' .
		'Please see https://github.com/wiki-chan/Social for' .
		' more information about this extension.'
	);
}

$wgNamespacesWithSubpages[NS_USER] = false;

# 가상의 권한인 disabled라는 권한이 있어야만 편집이 가능함 = 편집 불가
$wgNamespaceProtection[NS_USER_TALK] = array( 'disabled' );

/**
 * This is the loader file for the SocialProfile extension. You should include
 * this file in your wiki's LocalSettings.php to activate SocialProfile.
 *
 * If you want to use the UserWelcome extension (bundled with SocialProfile),
 * the <topusers /> tag or the user levels feature, there are some other files
 * you will need to include in LocalSettings.php. The online manual has more
 * details about this.
 *
 * For more info about SocialProfile, please see https://www.mediawiki.org/wiki/Extension:SocialProfile.
 */

// Internationalization files
$wgMessagesDirs['SocialProfile'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['SocialProfileAlias'] = __DIR__ . '/SocialProfile.alias.php';

$wgMessagesDirs['SocialProfileUserStats'] = __DIR__ . '/UserStats/i18n';
$wgExtensionMessagesFiles['SocialProfileNamespaces'] = __DIR__ . '/SocialProfile.namespaces.php';

// Classes to be autoloaded
$wgAutoloadClasses['SocialProfileInitClass'] = __DIR__ . '/SocialProfileInitClass.php';

$wgAutoloadClasses['GenerateTopUsersReport'] = __DIR__ . '/UserStats/GenerateTopUsersReport.php';

$wgAutoloadClasses['UpdateEditCounts'] = __DIR__ . '/UserStats/SpecialUpdateEditCounts.php';

$wgAutoloadClasses['UserLevel'] = __DIR__ . '/UserStats/UserStatsClass.php';
$wgAutoloadClasses['UserStats'] = __DIR__ . '/UserStats/UserStatsClass.php';
$wgAutoloadClasses['UserStatsTrack'] = __DIR__ . '/UserStats/UserStatsClass.php';
$wgAutoloadClasses['UserEmailTrack'] = __DIR__ . '/UserStats/UserStatsClass.php';
$wgAutoloadClasses['UserSystemMessage'] = __DIR__ . '/UserSystemMessages/UserSystemMessagesClass.php';
$wgAutoloadClasses['TopFansByStat'] = __DIR__ . '/UserStats/TopFansByStat.php';
$wgAutoloadClasses['TopFansRecent'] = __DIR__ . '/UserStats/TopFansRecent.php';
$wgAutoloadClasses['TopUsersPoints'] = __DIR__ . '/UserStats/TopUsers.php';


// New special pages

$wgSpecialPages['GenerateTopUsersReport'] = 'GenerateTopUsersReport';
$wgSpecialPages['TopFansByStatistic'] = 'TopFansByStat';
$wgSpecialPages['TopUsers'] = 'TopUsersPoints';
$wgSpecialPages['TopUsersRecent'] = 'TopFansRecent';
$wgSpecialPages['UpdateEditCounts'] = 'UpdateEditCounts';


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
	'descriptionmsg' => 'socialprofile-desc',
);
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'TopUsers',
	'author' => 'David Pean',
	'url' => 'https://github.com/wiki-chan/Social',
	'description' => 'Adds a special page for viewing the list of users with the most points.',
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

/*
function efUserBoardOnUserRename( $renameUserSQL ) {
	$renameUserSQL->tables['{multi}'][] = array( 'user_board', 'ub_user_name', 'ub_user_id' );
	$renameUserSQL->tables['{multi}'][] = array( 'user_board', 'ub_user_name_from', 'ub_user_id_from' );
	// <fixme> 여기도 column 바꿀 곳이 한 곳 더 있음. 확인 요망. </fixme>
	return true;
}
*/





// UserStats
$wgResourceModules['ext.socialprofile.userstats.css'] = array(
	'styles' => 'TopList.css',
	'localBasePath' => __DIR__ . '/UserStats',
	'remoteExtPath' => 'SocialProfile/UserStats',
	'position' => 'top' // just in case
);

// End ResourceLoader stuff
