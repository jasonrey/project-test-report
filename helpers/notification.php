<?php
!defined('SERVER_EXEC') && die('No access.');

class NotificationHelper extends Helper
{
	public static function send($data)
	{
		if (!$data['to'] || !$data['text']) {
			return false;
		}

		$slackTable = Lib::table('slackuser');

		if ($slackTable->load(['email' => $data['to']])) {
			// Send slack
			$slackMessage = Lib::helper('slack')->newMessage();
			$slackMessage->channel = '@' . $slackTable->name;
			$slackMessage->text = $data['text'];

			$messageKeys = ['username', 'icon_emoji'];

			foreach ($messageKeys as $mKey) {
				if (!empty($data[$mKey])) {
					$slackMessage->$mKey = $data[$mKey];
				}
			}

			if (!empty($data['attachments'])) {
				$attachmentKeys = ['fallback', 'color', 'title', 'title_link', 'text'];

				foreach ($data['attachments'] as $attach) {
					$attachment = $slackMessage->newAttachment();

					foreach ($attachmentKeys as $aKey) {
						if (!empty($attach[$aKey])) {
							$attachment->$aKey = $attach[$aKey];
						}
					}

					if (!empty($attach['fields'])) {
						foreach ($attach['fields'] as $fieldKey => $fieldValue) {
							$attachment->newField($fieldKey, $fieldValue);
						}
					}
				}
			}

			$slackMessage->send();
		} else {
			// Send email
			$mail = Lib::helper('mail')->newMessage();

			$mail->recipientEmail = $data['to'];

			$mail->subject = 'Report Notification';

			$mail->body = '<p>' . $data['text'] . '</p>';

			$attachments = '';

			foreach ($data['attachments'] as $attach) {
				if (empty($attach['title']) || empty($attach['title_link'])) {
					continue;
				}

				$attachments .= '<p><a href="' . $attach['title_link'] . '">' . $attach['title'] . '</a></p>';
			}

			if (!empty($attachments)) {
				$mail->body .= '<p><strong><u>Attachments</u></strong></p>';
				$mail->body .= $attachments;
			}

			$mail->body .= '<p style="font-size: 10px;">Do not reply to this email.</p>';

			$mail->send();
		}

		return true;
	}
}
