<?php
/**
 * UserRelationship extension
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

$wgExtensionCredits['profile'][] = array(
	'path' => __FILE__,
	'name' => 'Relationship',
	'author' => array('David Pean', '페네트-'),
	'url' => 'https://www.mediawiki.org/wiki/Extension:SocialProfile',
	'description' => 'A special page for adding friends/foe requests for existing users in the wiki',
);

// Internationalization files
$wgMessagesDirs['SocialProfileUserRelationship'] = __DIR__ . '/i18n';

// Autoload Classes
$wgAutoloadClasses['UserRelationship'] = __DIR__ . '/UserRelationshipClass.php';								// class for control relationships
$wgAutoloadClasses['SpecialAddRelationship'] = __DIR__ . '/SpecialAddRelationship.php';							// special page for add relationship
$wgAutoloadClasses['SpecialRemoveRelationship'] = __DIR__ . '/SpecialRemoveRelationship.php';					// special page for remove relationship
$wgAutoloadClasses['SpecialViewRelationshipRequests'] = __DIR__ . '/SpecialViewRelationshipRequests.php';		// special page for view requested relationship
$wgAutoloadClasses['SpecialViewRelationships'] = __DIR__ . '/SpecialViewRelationships.php';						// special page for show relationship
$wgAutoloadClasses['RelationshipResponse'] = __DIR__ . '/APIRelationshipResponse.php';							// Relationship Response API

// for API modules
$wgAPIModules['social-request-response'] = 'RelationshipResponse';

// resource modules
$wgResourceModules['ext.socialprofile.userrelationship.css'] = array(
	'styles' => 'UserRelationship.css',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Social/UserRelationship',
	'position' => 'top' // just in case
);

$wgResourceModules['ext.socialprofile.userrelationship.js'] = array(
	'scripts' => 'UserRelationship.js',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Social/UserRelationship',
);

// special pages
$wgSpecialPages['AddRelationship'] = 'SpecialAddRelationship';
$wgSpecialPages['RemoveRelationship'] = 'SpecialRemoveRelationship';
$wgSpecialPages['ViewRelationshipRequests'] = 'SpecialViewRelationshipRequests';
$wgSpecialPages['ViewRelationships'] = 'SpecialViewRelationships';

// ajax export
$wgAjaxExportList[] = 'UserRelationshipAjaxFunctions::wfRelationshipRequestResponse';
$wgAjaxExportList[] = 'UserRelationshipAjaxFunctions::wfGetNewRequestRelationship';

/*
// 새 친구신청이 있는지 알림
$wgResourceModules['userrelationship.getnewalert'] = array(
	'scripts' => 'NewRelationshipAlert.js',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'SocialProfile/UserRelationship',
	'position' => 'bottom'
);
$wgHooks['BeforePageDisplay'][] = 'wfRegisterDisplayNewRelations';

function wfRegisterDisplayNewRelations( OutputPage &$out, Skin &$skin ) {

	$out->addModuleScripts('userrelationship.getnewalert');
	return true;
}
*/