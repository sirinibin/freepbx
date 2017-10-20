<?php
namespace FreePBX\modules\Sms;
class Api {
	protected $sms_api = 'https://katanafpbx.schmoozecom.com/sms/1';
	private $pest;
	private $key;
	private $cache;

	public function __construct($key) {
		$this->key = $key;
		$this->pest = new \PestJSON($this->sms_api);
	}

	public function getReceivedMessagesSince($did,$time) {
		$url = 'received/'.$this->key.'/'.$did.'/'.$time;
		$messages = $this->pest->get($url);
		return $messages;
	}

	public function getSentMessagesSince($did,$time) {
		$url = 'sent/'.$this->key.'/'.$did;
		$messages = $this->pest->get($url);
		return $messages;
	}

	public function sendMessage($did,$to,$message=null,$media=array()) {
		$info = $this->getDid($did);
		if(!$info['status']) {
			return array(
				"status" => false,
				"message" => _("Invalid DID")
			);
		}
		if(!$info['data']['sms']) {
			return array(
				"status" => false,
				"message" => _("SMS is not setup for this DID")
			);
		}
		if(!empty($media) && !$info['data']['mms']) {
			return array(
				"status" => false,
				"message" => _("MMS is not setup for this DID")
			);
		}
		$url = 'send/'.$this->key.'/'.$did.'/'.$to;
		$messages = $this->pest->post($url,array(
			"text" => !is_null($message) ? $message : "",
			"media" => $media
		));
		return $messages;
	}

	public function getDid($did) {
		if(isset($this->cache['did'][$did])) {
			return $this->cache['did'][$did];
		}
		$url = 'did/'.$this->key.'/'.$did;
		$info = $this->pest->get($url);
		if(!$info['status']) {
			return false;
		}
		$this->cache['did'][$did] = $info;
		return $this->cache['did'][$did];
	}
}
