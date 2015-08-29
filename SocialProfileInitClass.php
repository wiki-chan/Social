<?php

class SocialProfileInitClass {
	public static function setAvatarKey() {
		global $wgAvatarKey;
		// 이거 진짜로 필요한거 맞는지?
		$wgAvatarKey = wfGetDB( DB_SLAVE )->getDBname();
	}
}