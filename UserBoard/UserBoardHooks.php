<?php

class UserBoardHooks {
	/**
	 * For Echo extension
	 *
	 * @param $notifications array of Echo notifications
	 * @param $notificationCategories array of Echo notification categories
	 * @param $icons array of icon details
	 * @return bool
	 */
	public static function onBeforeCreateEchoEvent( &$notifications, &$notificationCategories, &$icons ) {
		$notificationCategories['social-msg'] = array(
			'priority' => 3,
			'tooltip' => 'echo-pref-tooltip-social-msg',
		);

		$notifications['social-msg-send'] = array(
			'category' => 'social-msg',
			'group' => 'interactive',
			'formatter-class' => 'SocialFormatter',

			'title-message' => 'notification-social-msg-send',
			'title-params' => array( 'user' ),
			'payload' => array( 'send-message' ),

			'icon' => 'mention',

			'bundle' => array( 'web' => true, 'email' => true ),
			'bundle-message' => 'notification-social-msg-send-bundle',
			'bundle-params' => array( 'bundle-user-count', 'bundle-noti-count' )
		);

		return true;
	}

	/**
	 * Add user to be notified on echo event
	 * @param $event EchoEvent
	 * @param $users array
	 * @return bool
	 */
	public static function onEchoGetDefaultNotifiedUsers( $event, &$users ) {
		switch ( $event->getType() ) {
			case 'social-msg-send':
				$extra = $event->getExtra();
				$target_id = $extra['target'];
				$users[] = User::newFromId($target_id);
				break;
		}
		return true;
	}
}