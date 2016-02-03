<?php

class SocialFormatter extends EchoBasicFormatter {
	/**
	  * @param EchoEvent $event
	  * @param string $param
	  * @param Message $message
	  * @param User $user
	  */
	protected function processParam( $event, $param, $message, $user ) {
		switch ( $param ) {
			case 'user':
				$target_id = $event->getExtra()['from'];
				$target_user = User::newFromId($target_id);
				$target_title = $target_user->getUserPage();

				$link = $this->buildLinkParam($target_title, array(
					'linkText' => $target_user->getName()
				));
				$message->params($link);
				break;

			case 'relationship':
				$title = Title::newFromText('ViewRelationshipRequests', NS_SPECIAL);
				$link = $this->buildLinkParam($title, array(
					'linkText' => $this->getMessage( 'echo-show-social-rel-add-link' )->text()
				));
				$message->params($link);
				break;

			default:
				parent::processParam( $event, $param, $message, $user );
		}
	}

	protected function formatPayload( $payload, $event, $user ) {
		switch ( $payload ) {
			case 'relationship-add':
				$extra = $event->getExtra();
				return $extra['message'];
				break;
			case 'send-message':
				global $wgParser, $wgTitle, $wgOut;

				$extra = $event->getExtra();
				$message = $this->truncate($extra['message']);
				return $message;
				//return $wgParser->getFreshParser()->parse($message, $wgTitle, $wgOut->parserOptions())->getText();
				break;
			default:
				return parent::formatPayload( $payload, $event, $user );
				break;
		}
	}

	private function truncate($string, $length = 100, $append="&hellip;") {
		$string = trim($string);

		if (strlen($string) > $length) {
			$string = wordwrap($string, $length);
			$string = explode("\n", $string, 2);
			$string = $string[0] . $append;
		}

		return $string;
	}
}