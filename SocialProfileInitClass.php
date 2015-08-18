<?php

class SocialProfileInitClass {
	public static function setAvatarKey() {
		global $wgAvatarKey, $wgDBname;
		//TODO: $wgDBname을 getDBname()으로 변경할 것
		$wgAvatarKey = $wgDBname;
	}
}