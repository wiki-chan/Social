<?php
class RelationshipResponse extends ApiBase {
	public function execute() {
		$main = $this->getMain();

		$response = $main->getVal('response');
		$requestId = $main->getVal('id');

		global $wgUser;

		// Don't allow blocked users to send messages and also don't allow message
		// sending when the database is locked for some reason
		if ( $wgUser->isBlocked() || wfReadOnly() ) {
			return false;
		}

		$out = '';

		$rel = new UserRelationship( $wgUser->getName() );
		if ( $rel->verifyRelationshipRequest( $requestId ) == true ) {
			$request = $rel->getRequest( $requestId );
			$user_name_from = $request[0]['user_name_from'];
			$user_id_from = User::idFromName( $user_name_from );
			$rel_type = strtolower( $request[0]['type'] );

			$rel->updateRelationshipRequestStatus( $requestId, intval( $response ) );

			$avatar = new wAvatar( $user_id_from, 'l' );
			$avatar_img = $avatar->getAvatarURL();

			if ( $response == 1 ) {
				$rel->addRelationship( $requestId );
				$out .= "<div class=\"relationship-action red-text\">
					{$avatar_img}" .
						wfMessage( "ur-requests-added-message-{$rel_type}", $user_name_from )->escaped() .
					'<div class="visualClear"></div>
				</div>';
			} else {
				$out .= "<div class=\"relationship-action red-text\">
					{$avatar_img}" .
						wfMessage( "ur-requests-reject-message-{$rel_type}", $user_name_from )->escaped() .
					'<div class="visualClear"></div>
				</div>';
			}
			$rel->deleteRequest( $requestId );
		} else {
			return false;
		}

		$this->getResult()->addValue( null, 'html', $out );

		return true;
	}

	// Description
	public function getDescription() {
		return '관계 요청에 대해 응답합니다.';
	}

	// Face parameter.
	public function getAllowedParams() {
		return array_merge( parent::getAllowedParams(), array(
			'response' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true
			),
			'id' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true
			)
		) );
	}

	// Describe the parameter
	public function getParamDescription() {
		return array_merge( parent::getParamDescription(), array(
			'response' => '관계 요청에 대한 응답입니다. 1은 수락을, -1은 거절을 의미합니다.',
			'id' => '관계 요청 아이디입니다.'
		) );
	}

	// Get examples
	public function getExamplesMessages() {
		return array();
/*                        // apisampleoutput-face-1 is the key to an i18n message explaining the example
			'api.php?action=senduserboardmessage&&format=xml'
			=> 'apisampleoutput-face-1'
		);*/
	}
}
