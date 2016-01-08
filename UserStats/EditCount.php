<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

/**
 * For the UserLevels (points) functionality to work, you will need to
 * define $wgUserLevels and require_once() this file in your wiki's
 * LocalSettings.php file.
 */
$wgHooks['NewRevisionFromEditComplete'][] = 'UserStatsFunctions::incEditCount';
$wgHooks['ArticleDelete'][] = 'UserStatsFunctions::removeDeletedEdits';
$wgHooks['ArticleUndelete'][] = 'UserStatsFunctions::restoreDeletedEdits';
