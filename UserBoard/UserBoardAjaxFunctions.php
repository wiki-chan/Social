<?php

class UserBoardAjaxFunctions {
	public static function wfSendBoardMessage( $user_name, $message, $message_type, $count ) {
		global $wgUser;

		// Don't allow blocked users to send messages and also don't allow message
		// sending when the database is locked for some reason
		if ( $wgUser->isBlocked() || wfReadOnly() ) {
			return '';
		}

		$user_name = stripslashes( $user_name );
		$user_name = urldecode( $user_name );
		$user_id_to = User::idFromName( $user_name );
		$b = new UserBoard();

		$m = $b->sendBoardMessage(
			$wgUser->getID(), $wgUser->getName(), $user_id_to, $user_name,
			urldecode( $message ), $message_type
		);

		return $b->displayMessages( $user_id_to, 0, $count );
	}

	public static function wfDeleteBoardMessage( $ub_id ) {
		global $wgUser;

		// Don't allow deleting messages when the database is locked for some reason
		if ( wfReadOnly() ) {
			return '';
		}

		$b = new UserBoard();
		if (
			$b->doesUserOwnMessage( $wgUser->getID(), $ub_id ) ||
			$wgUser->isAllowed( 'userboard-delete' )
		) {
			$b->deleteMessage( $ub_id );
		}
		return 'ok';
	}

	public static function wfGetNewMessage( $ub_old_id ) {
		global $wgUser;

		$b = new UserBoard();
		return $b->getNewMessageCount( $wgUser->getID(), $ub_old_id );
	}

	public static function wfGetResetNewMessageCount( $ub_old_id ) {
		global $wgUser;

		$b = new UserBoard();
		return $b->clearNewMessageCount( $wgUser->getID() );
	}
}