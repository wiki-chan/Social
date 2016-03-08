<?php
class SendUserBoardMessage extends ApiBase {
	public function execute() {
		$main = $this->getMain();

		$user_name = $main->getVal('username');
		$message = $main->getVal('message');
		$message_type = $main->getVal('type') || 0;

		global $wgUser;

		// Don't allow blocked users to send messages and also don't allow message
		// sending when the database is locked for some reason
		if ( $wgUser->isBlocked() || wfReadOnly() ) {
			$this->getResult()->addValue( null, 'result', "현재 메시지를 보낼 수 없습니다.");
			return true;
		}

		$user_name = stripslashes( $user_name );
		$user_name = urldecode( $user_name );
		$user_id_to = User::idFromName( $user_name );
		$b = new UserBoard();

		$m = $b->sendBoardMessage(
			$wgUser->getID(), $wgUser->getName(), $user_id_to, $user_name,
			urldecode( $message ), $message_type
		);

		$this->getResult()->addValue( null, 'result', $b->displayMessages( $user_id_to, 0, 1 ) );

		return true;
	}

	// Description
	public function getDescription() {
		return 'UserBoard에 메시지를 보냅니다.';
	}

	// Face parameter.
	public function getAllowedParams() {
		return array_merge( parent::getAllowedParams(), array(
			'username' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'message' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'type' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => false
			)
		) );
	}

	// Describe the parameter
	public function getParamDescription() {
		return array_merge( parent::getParamDescription(), array(
			'username' => '사용자 이름입니다.',
			'message' => 'urlencode된 메시지입니다.',
			'type' => '메시지 타입입니다. 0은 일반글을, 1은 비밀글을 의미합니다.'
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