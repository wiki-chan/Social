<?php

class UserRelationshipHooks {
	/**
	 * For Echo extension
	 *
	 * @param $notifications array of Echo notifications
	 * @param $notificationCategories array of Echo notification categories
	 * @param $icons array of icon details
	 * @return bool
	 */
	public static function onBeforeCreateEchoEvent( &$notifications, &$notificationCategories, &$icons ) {
		$notificationCategories['social-rel'] = array(
			'priority' => 2,
			'tooltip' => 'echo-pref-tooltip-social-rel',
		);

		$notifications['social-rel-add'] = array(
			'primary-link' => array( 'message' => 'notification-link-text-view-edit', 'destination' => 'diff' ),
			'category' => 'social-rel',
			'group' => 'interactive',
			'formatter-class' => 'SocialFormatter',
			'title-message' => 'notification-social-rel-add',
			'title-params' => array( 'user', 'relationship' ),
			'payload' => array( 'relationship-add-message' ),
			'email-subject-message' => 'notification-social-rel-add-email-subject',
			'email-subject-params' => array( 'user' ),
			'email-body-batch-message' => 'notification-social-rel-add-email-batch-body',
			'email-body-batch-params' => array( 'user', 'relationship' ),
			'icon' => 'gratitude',
		);

		$notifications['social-rel-accept'] = array(
			'primary-link' => array( 'message' => 'notification-link-text-view-edit', 'destination' => 'diff' ),
			'category' => 'social-rel',
			'group' => 'interactive',
			'formatter-class' => 'SocialFormatter',
			'title-message' => 'notification-social-rel-accept',
			'title-params' => array( 'user' ),
			'email-subject-message' => 'notification-social-rel-accept-email-subject',
			'email-subject-params' => array( 'user' ),
			'email-body-batch-message' => 'notification-social-rel-accept-email-batch-body',
			'email-body-batch-params' => array( 'user' ),
			'icon' => 'gratitude',
		);
/*
		$icons['thanks'] = array(
			'path' => 'Social/ThankYou.png',
		);
*/
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
			case 'social-rel-add':
			case 'social-rel-accept':
				$extra = $event->getExtra();
				$target_id = $extra['target'];
				$users[] = User::newFromId($target_id);
				break;
		}
		return true;
	}
}