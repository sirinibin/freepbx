<?php
namespace FreePBX\modules\Sms\Adaptor;
use FreePBX\modules\Sms\Api;
include __DIR__."/Smsapi.class.php";
class Sipstation extends \FreePBX\modules\Sms\AdaptorBase {
	private $key;
	private $api;
	//	License for all code of this FreePBX module can be found in the license file inside the module directory
	//	Copyright 2013 Schmooze Com Inc.
	//

	protected $sms_server = 'trunk1.freepbx.com';

	public function __construct($ss=null) {
		parent::__construct();
		if (!empty($ss)) {
			$this->key = $ss->get_key();
			if(!empty($this->key)) {
				$c = $ss->get_settings($this->key, false);
				if(!empty($c['gateways'][1])) {
					$this->sms_server = $c['gateways'][1];
					$this->api = new Api($this->key);
					$this->supportsMedia = true;
				}
			}
		}
	}

	/**
	* Create the Notification Class statically while checking to make sure the class hasn't already been loaded
	*
	* @param object Database Object
	* @return object Notification object
	*/
	static function &create($ss=null) {
		static $obj;
		if (!isset($obj)) {
			$obj = new Sipstation($ss);
		}
		return $obj;
	}

	public function showDID($id, $did) {
		return \FreePBX::Ucp()->getCombinedSettingByID($id,'Sipstation','sms_enable');
	}

	public function sendMedia($to,$from,$cnam,$message,$files) {
		$useAPI = $this->api->getDid($from);
		if($useAPI) {
			//supports proper unicode
			$message = $this->emoji->shortnameToUnicode($message);
			$fmedia = array();
			foreach($files as $file) {
				$fmedia[] = array(
					"data" => base64_encode(file_get_contents($file)),
					"ext" => pathinfo ($file, PATHINFO_EXTENSION)
				);
			}
			$res = $this->api->sendMessage($from,$to,$message,$fmedia);
			if($res['status']) {
				$id = parent::sendMedia($to,$from,null,$message,$files,null,'Sipstation');
				return array("status" => true, "id" => $id);
			} else {
				return array("status" => false, "message" => $res['message']);
			}
		} else {
			return array("status" => false, "message" => _("MMS supported for this DID"));
		}
	}

	public function sendMessage($to,$from,$cnam,$message) {
		$useAPI = $this->api->getDid($from);
		if($useAPI) {
			//supports proper unicode
			$message = $this->emoji->shortnameToUnicode($message);
			$res = $this->api->sendMessage($from,$to,$message);
			if($res['status']) {
				$id = parent::sendMessage($to,$from,null,$message,null,'Sipstation');
				return array("status" => true, "id" => $id);
			} else {
				return array("status" => false, "message" => $res['message']);
			}
		} else {
			$id = parent::sendMessage($to,$from,$cnam,$message,null,'Sipstation');
			$astman = \FreePBX::create()->astman;
			$cnam = !empty($cnam) ? '"'.utf8_decode($cnam).'"' : '';
			//message bus does not support proper unicode
			$message = $this->emoji->toShort($message);
			$message = $this->emoji->shortnameToAscii($message);
			$res = $astman->MessageSend('sip:'.$to.'@'.$this->sms_server, $cnam.' <sip:+'.$from.'@'.$this->sms_server.'>', $message);
			$final = array();
			if(!empty($res['Response']) && ($res['Response'] == 'Success')) {
				return array("status" => true, "id" => $id);
			} else {
				return array("status" => false);
			}
		}
	}

	public function getMessage($to,$from,$cnam,$message) {
		$sql = "SELECT *, unix_timestamp(tx_rx_datetime) as ut FROM sms_messages WHERE direction = 'in' AND adaptor = 'Sipstation' ORDER BY `ut` DESC LIMIT 1";
		$sth = \FreePBX::Database()->prepare($sql);
		$sth->execute();
		$row = $sth->fetch(\PDO::FETCH_ASSOC);
		$time = !empty($row['ut']) ? $row['ut'] : '0';
		$data = $this->api->getReceivedMessagesSince($to,$time);
		if($data['status'] && !empty($data['messages'])) {
			foreach($data['messages'] as $m) {
				$m['from'] = str_replace("+","",$m['from']);
				$m['to'] = str_replace("+","",$m['to']);
				$time = null; //Could use $m['time'] but it's not the time we received the message, we got it NOW
				$msgid = parent::getMessage($m['to'],$m['from'],null,$m['text'],$time,'Sipstation',$m['id']);
				if($m['type'] == 'mms' && !empty($m['media'])) {
					foreach($m['media'] as $media) {
						$name = basename($media);
						$data = file_get_contents($media);
						$this->addMedia($msgid, $name, $data);
					}
				}
			}
		} else {
			parent::getMessage($to,$from,$cnam,$message,null,'Sipstation');
		}
	}

	public function dialPlanHooks(&$ext, $engine, $priority) {
		global $core_conf;

		//need to get the list of trunks we control.
		//\FreePBX::PJSip()->addEndpoint('test','message_context','sms-incoming');

		$c = 'sms-incoming';
		$ext->add($c, '_.', '', new \ext_noop('SMS came in with DID: ${EXTEN}'));
		$ext->add($c, '_.', '', new \ext_goto('1', 's'));
		$ext->add($c, 's', '', new \ext_agi('sipstation_sms.php, RECEIVE'));
		$ext->add($c, 's', '', new \ext_hangup());

		$core_conf->addSipGeneral('accept_outofcall_message','yes');
	}
}
