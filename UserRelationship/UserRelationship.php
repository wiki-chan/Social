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
