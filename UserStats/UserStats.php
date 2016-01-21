<?php

$wgExtensionCredits['profile'][] = array(
	'path' => __FILE__,
	'name' => 'User Stats',
	'author' => array('David Pean', '페네트-'),
	'url' => 'https://github.com/wiki-chan/Social',
	'license-name' => 'GPL-2.0',
	'description' => 'Add user stat information in Social',
);

// Internationalization files
$wgMessagesDirs['SocialProfileUserStats'] = __DIR__ . '/i18n';

// Classes to be autoloaded
$wgAutoloadClasses['UserStatsFunctions'] = __DIR__ . '/UserStatsFunctions.php';
$wgAutoloadClasses['GenerateTopUsersReport'] = __DIR__ . '/GenerateTopUsersReport.php';
$wgAutoloadClasses['UpdateEditCounts'] = __DIR__ . '/SpecialUpdateEditCounts.php';
$wgAutoloadClasses['UserLevel'] = __DIR__ . '/UserStatsClass.php';
$wgAutoloadClasses['UserStats'] = __DIR__ . '/UserStatsClass.php';
$wgAutoloadClasses['UserStatsTrack'] = __DIR__ . '/UserStatsClass.php';
$wgAutoloadClasses['UserEmailTrack'] = __DIR__ . '/UserStatsClass.php';
$wgAutoloadClasses['UserSystemMessage'] = __DIR__ . '//UserSystemMessages/UserSystemMessagesClass.php';
$wgAutoloadClasses['TopFansByStat'] = __DIR__ . '/TopFansByStat.php';
$wgAutoloadClasses['TopFansRecent'] = __DIR__ . '/TopFansRecent.php';
$wgAutoloadClasses['TopUsersPoints'] = __DIR__ . '/TopUsers.php';

// Hooks
$wgHooks['NewRevisionFromEditComplete'][] = 'UserStatsFunctions::incEditCount';
$wgHooks['ArticleDelete'][] = 'UserStatsFunctions::removeDeletedEdits';
$wgHooks['ArticleUndelete'][] = 'UserStatsFunctions::restoreDeletedEdits';

// New special pages
$wgSpecialPages['GenerateTopUsersReport'] = 'GenerateTopUsersReport';
$wgSpecialPages['TopFansByStatistic'] = 'TopFansByStat';
$wgSpecialPages['TopUsers'] = 'TopUsersPoints';
$wgSpecialPages['TopUsersRecent'] = 'TopFansRecent';
$wgSpecialPages['UpdateEditCounts'] = 'UpdateEditCounts';

// Resource Modules
$wgResourceModules['ext.socialprofile.userstats.css'] = array(
	'styles' => 'TopList.css',
	'localBasePath' => __DIR__ . '/UserStats',
	'remoteExtPath' => 'SocialProfile/UserStats',
	'position' => 'top' // just in case
);