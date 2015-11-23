<?php
if (!defined('NS_USER_PROFILE')) define( 'NS_USER_PROFILE', 202 );
if (!defined('NS_USER_WIKI')) define( 'NS_USER_WIKI', 200 );

class UserProfileFunctions {
	/**
	 * Called by ArticleFromTitle hook
	 * Calls UserProfilePage instead of standard article
	 *
	 * @param &$title Title object
	 * @param &$article Article object
	 * @return true
	 */
	public static function wfUserProfileFromTitle( &$title, &$article ) {
		global $wgRequest, $wgOut, $wgHooks, $wgUserPageChoice;

		if ( strpos( $title->getText(), '/' ) === false &&
			( NS_USER == $title->getNamespace() || NS_USER_PROFILE == $title->getNamespace() )
		) {
			$show_user_page = false;
			if ( $wgUserPageChoice ) {
				$profile = new UserProfile( $title->getText() );
				$profile_data = $profile->getProfile();

				// If they want regular page, ignore this hook
				if ( isset( $profile_data['user_id'] ) && $profile_data['user_id'] && $profile_data['user_page_type'] == 0 ) {
					$show_user_page = true;
				}
			}

			if ( !$show_user_page ) {
				// Prevents editing of userpage
				if ( $wgRequest->getVal( 'action' ) == 'edit' ) {
					$wgOut->redirect( $title->getFullURL() );
				}
			} else {
				$wgOut->enableClientCache( false );
				$wgHooks['ParserLimitReport'][] = 'UserProfileFunctions::wfUserProfileMarkUncacheable';
			}

			$wgOut->addModuleStyles( array(
				'ext.socialprofile.clearfix',
				'ext.socialprofile.userprofile.css'
			) );

			$article = new UserProfilePage( $title );
		}
		#NS_USER의 하위페이지 접근 시에도 유저페이지만 보여줌 (by 페네트)
		#별로 좋지 못한 해결책임...mw 다음 버전에서 특수 함수를 사용해서 해결할 수 있을듯.
		elseif ( strpos( $title->getText(), '/' ) > 0 &&
			( NS_USER == $title->getNamespace() || NS_USER_PROFILE == $title->getNamespace() )
		) {
			$parts = explode( '/', $title->getText() );
			if ( count( $parts ) > 1 )
				unset( $parts[count( $parts ) - 1] );

			$article = new UserProfilePage( $title );
			$title = Title::newFromText(implode($parts), $title->getNamespace());
			$article->getContext()->getOutput()->redirect($title->getFullURL());
		}
		return true;
	}

	/**
	 * Mark page as uncacheable
	 *
	 * @param $parser Parser object
	 * @param &$limitReport String: unused
	 * @return true
	 */
	public static function wfUserProfileMarkUncacheable( $parser, &$limitReport ) {
		$parser->disableCache();
		return true;
	}
}