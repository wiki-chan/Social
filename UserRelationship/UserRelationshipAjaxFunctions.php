<?php

class UserRelationshipAjaxFunctions {

	public static function wfRelationshipRequestResponse( $response, $requestId ) {
		global $wgUser;
		$out = '';

		$rel = new UserRelationship( $wgUser->getName() );
		if ( $rel->verifyRelationshipRequest( $requestId ) == true ) {
			$request = $rel->getRequest( $requestId );
			$user_name_from = $request[0]['user_name_from'];
			$user_id_from = User::idFromName( $user_name_from );
			$rel_type = strtolower( $request[0]['type'] );

			$response = ( isset( $_POST['response' ] ) ) ? $_POST['response'] : $response;
			$rel->updateRelationshipRequestStatus( $requestId, intval( $response ) );

			$avatar = new wAvatar( $user_id_from, 'l' );
			$avatar_img = $avatar->getAvatarURL();

			if ( $response == 1 ) {
				$rel->addRelationship( $requestId );
				$out .= "<div class=\"relationship-action red-text\">
					{$avatar_img}" .
						wfMessage( "ur-requests-added-message-{$rel_type}", $user_name_from )->escaped() .
					'<div class="cleared"></div>
				</div>';
			} else {
				$out .= "<div class=\"relationship-action red-text\">
					{$avatar_img}" .
						wfMessage( "ur-requests-reject-message-{$rel_type}", $user_name_from )->escaped() .
					'<div class="cleared"></div>
				</div>';
			}
			$rel->deleteRequest( $requestId );
		}

		return $out;
	}

	// 새 친구신청이 있는 경우 알림 출력 by 페네트
	public static function wfGetNewRequestRelationship() {
		global $wgUser;
	//return '1';
		// 1은 일반 유저를, 2는 차단한 유저를 가리킨다.
		return UserRelationship::getOpenRequestCount( $wgUser->getID(), 1 );
	}
}