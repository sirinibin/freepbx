<?php
// vim: set ai ts=4 sw=4 ft=php:
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2013 Schmooze Com Inc.
//
namespace FreePBX\modules;

class Sipstation implements \BMO {

	public $ss = null;
	private $tollfree = "/(^888)|(^877)|(^866)|(^855)|(^844)|(^800)/";

	private static $oobeobj = false;

	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new \Exception("Not given a FreePBX Object");
		}
		if(!class_exists('sipstation')){
			include(__DIR__.'/functions.inc/sipstation.inc.php');
		}
		$this->ss = new \sipstation();
		$this->key = $this->ss->get_key();
		$this->ssconfig = $this->ss->get_config($this->key,false);
		$this->ssapi = new \Pest($this->ss->api_url);
		$this->freepbx = $freepbx;
		$modinfo = $freepbx->Modules->getInfo('sipstation');
		$this->modversion = isset($modinfo['sipstation']['version'])?$modinfo['sipstation']['version']:'unknown';
		$this->db = $freepbx->Database;
		$path = $this->freepbx->Config->get('AMPBIN',true);
		$fullpath = $path.'/freepbx_sipstation_check';
		$cron = '@daily [ -x '.$fullpath.' ] && '.$fullpath;
		\FreePBX::Cron()->addLine($cron);

	}

	public function doConfigPageInit($page) {
	}

	public function install() {

	}
	public function uninstall() {

	}
	public function backup(){

	}
	public function restore($backup){

	}
	public function genConfig() {
	}
	public function getSSRoutes(){
		$sql = 'SELECT data FROM module_xml WHERE id = ?';
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array('ss_route'));
		$ret = $stmt->fetch(\PDO::FETCH_ASSOC);
	 	return !empty($ret['data'])?json_decode($ret['data'],true):array();
	}
	public function getSSTrunks(){
		$sstrunks = array();
		$alltrunks = core_trunks_listbyid();
		$t1 = 'fpbx-1-'.$this->ssconfig['sip_username'];
		$t2 = 'fpbx-2-'.$this->ssconfig['sip_username'];
		foreach ($alltrunks as $trunk) {
			if($trunk['channelid'] == $t1){
				$sstrunks['gw1'] = $trunk;
			}
			if($trunk['channelid'] == $t2){
				$sstrunks['gw2'] = $trunk;
			}
			if(isset($sstrunks['gw1']) && isset($sstrunks['gw2'])){
				break;
			}
		}
		return $sstrunks;
	}
	public function getRoutes(){
		$return = array();
		$this->freepbx->Modules->loadFunctionsInc('core');
		$routes = $this->freepbx->Core->getAllRoutes();
		$i = 0;
		foreach($routes as $route) {
			$return[$i]['label'] = sprintf("%'03s: %s",$route['seq'],$route['name']);
			$return[$i]['name']  = $route['name'].$route['route_id'];
			$return[$i]['id']  = $route['route_id'];
			$trunks = core_routing_getroutetrunksbyid($route['route_id']);
			$patterns = core_routing_getroutepatternsbyid($route['route_id']);
			$return[$i]['gw1_checked'] = false;
			$return[$i]['gw2_checked'] = false;
			$sip_user = $this->ssconfig['sip_username'];
			$e911_checked = '';
			$prepend_digits = array();
			foreach($patterns as $pattern) {
				if($pattern['match_pattern_pass'] == '911') {
					$e911_checked = 'checked';
				}
			}
			foreach($trunks as $trunknum) {
				$det = core_trunks_getDetails($trunknum);
				$dialrules = core_trunks_get_dialrules($trunknum);

				if($det['tech'] == 'sip' && $det['name'] == "fpbx-1-$sip_user") {
					$return[$i]['gw1_checked'] = true;
					if (is_array($dialrules) && count($dialrules)) {
						foreach ($dialrules as $rule) {
							if($rule['match_pattern_pass'] == 'NXXXXXX') {
								$prepend_digits[] = $rule['prepend_digits'];
							}
						}
					}
				} elseif($det['tech'] == 'sip' && $det['name'] == "fpbx-2-$sip_user") {
					$return[$i]['gw2_checked'] = true;
					if (is_array($dialrules) && count($dialrules)) {
						foreach ($dialrules as $rule) {
							if($rule['match_pattern_pass'] == 'NXXXXXX') {
								$prepend_digits[] = $rule['prepend_digits'];
							}
						}
					}
				}
			}
			$return[$i]['prepend_digits'] = $prepend_digits;
			$i++;
		}
		return $return;
	}

	public function ucpDelGroup($id,$display,$data) {
	}

	public function ucpAddGroup($id, $display, $data) {
		$this->ucpUpdateGroup($id,$display,$data);
	}

	public function ucpUpdateGroup($id,$display,$data) {
		if($display == 'userman' && isset($_POST['type']) && $_POST['type'] == 'group') {
			if(!empty($_REQUEST['ucp_sipstation-sms-did']) && $this->smsEnabled() && $this->freepbx->Modules->checkStatus('sms')) {
				$this->freepbx->Ucp->setSettingByGID($id,'Sipstation','sms-assigned',$_REQUEST['ucp_sipstation-sms-did']);
			} elseif($this->freepbx->Modules->checkStatus('sms')) {
				$this->freepbx->Ucp->setSettingByGID($id,'Sipstation','sms-assigned',array());
			}
			if(!empty($_REQUEST['sms_enable']) && $_REQUEST['sms_enable'] == "yes") {
				$this->freepbx->Ucp->setSettingByGID($id,'Sipstation','sms_enable',true);
			} elseif(!empty($_REQUEST['sms_enable']) && $_REQUEST['sms_enable'] == "no") {
				$this->freepbx->Ucp->setSettingByGID($id,'Sipstation','sms_enable',false);
			}
		}
	}

	/**
	* Hook functionality from userman when a user is deleted
	* @param {int} $id      The userman user id
	* @param {string} $display The display page name where this was executed
	* @param {array} $data    Array of data to be able to use
	*/
	public function ucpDelUser($id, $display, $ucpStatus, $data) {

	}

	/**
	* Hook functionality from userman when a user is added
	* @param {int} $id      The userman user id
	* @param {string} $display The display page name where this was executed
	* @param {array} $data    Array of data to be able to use
	*/
	public function ucpAddUser($id, $display, $ucpStatus, $data) {
		$this->ucpUpdateUser($id, $display, $ucpStatus, $data);
	}

	/**
	* Hook functionality from userman when a user is updated
	* @param {int} $id      The userman user id
	* @param {string} $display The display page name where this was executed
	* @param {array} $data    Array of data to be able to use
	*/
	public function ucpUpdateUser($id, $display, $ucpStatus, $data) {
		if($display == 'userman' && isset($_POST['type']) && $_POST['type'] == 'user') {
			if(!empty($_REQUEST['ucp_sipstation-sms-did']) && $this->smsEnabled() && $this->freepbx->Modules->checkStatus('sms')) {
				$this->freepbx->Sms->addUserRouting($id,$_REQUEST['ucp_sipstation-sms-did']);
			} elseif($this->freepbx->Modules->checkStatus('sms')) {
				$this->freepbx->Sms->addUserRouting($id,array());
			}
			if(!empty($_REQUEST['sms_enable']) && $_REQUEST['sms_enable'] == "yes") {
				$this->freepbx->Ucp->setSettingByID($id,'Sipstation','sms_enable',true);
			} elseif(!empty($_REQUEST['sms_enable']) && $_REQUEST['sms_enable'] == "no") {
				$this->freepbx->Ucp->setSettingByID($id,'Sipstation','sms_enable',false);
			} elseif(!empty($_REQUEST['sms_enable']) && $_REQUEST['sms_enable'] == "inherit") {
				$this->freepbx->Ucp->setSettingByID($id,'Sipstation','sms_enable',null);
			}
		}
	}

	public function ucpConfigPage($mode, $user, $action) {
		$html = array();
		if($this->smsEnabled() && $this->freepbx->Modules->checkStatus('sms')) {
			$dids = $this->getDIDs(false,true);
			if(!empty($dids)) {
				if($mode == "group") {
					if(empty($user)) {
						$enable = true;
					} else {
						$enabled = $this->freepbx->Ucp->getSettingByGID($user['id'],'Sipstation','sms_enable');
					}
					$html[0] = array(
						"title" => _("SIPStation SMS"),
						"rawname" => "sipstationsms",
						"content" => load_view(dirname(__FILE__)."/views/ucp_config.php",array("mode" => "group", "enable" => $enabled, "dids" => $dids, "assigned" => $this->freepbx->Ucp->getSettingByGID($_REQUEST['group'],'Sipstation','sms-assigned')))
					);
				} else {
					if(empty($user)) {
						$enable = null;
					} else {
						$enabled = $this->freepbx->Ucp->getSettingByID($user['id'],'Sipstation','sms_enable');
					}
					$html[0] = array(
						"title" => _("SIPStation SMS"),
						"rawname" => "sipstationsms",
						"content" => load_view(dirname(__FILE__)."/views/ucp_config.php",array("mode" => "user", "enable" => $enabled, "dids" => $dids, "assigned" => $this->freepbx->Sms->getAssignedDIDs($user['id'])))
					);
				}
			}
		}
		return $html;
	}
	public function ajaxRequest($req, &$setting) {
		if ($req == "setupKeyCode") {
			$setting['authenticate'] = true;
			$setting['allowremote'] = false;
			return true;
		}
		switch ($req) {
			case 'updateE911':
			case 'updateDest':
			case 'updateCID':
			case 'updateFailover':
			case 'getroutes':
			case 'getdids':
			case 'updateroute':
			case 'clearFailover':
				return true;
		}
		return false; // Returning false, or anything APART from (bool) true will abort the request
	}


	public function ajaxHandler() {
		$req = $_REQUEST;
		switch ($req['command']) {
			case 'setupKeyCode':
				$this->freepbx->Modules->loadFunctionsInc('core');
				$ret = array("status" => false, "message" => "");
				$account_key = $req["account_key"];
				if (empty($account_key)) {
					$ret["message"] = _("Invalid Account Key Code provided");
					return $ret;
				}
				$set_key_status = $this->ss->set_key($account_key,'AJAX');
				$data = $this->ss->get_config($account_key);
				$this->ss->add_routes($data['sip_username'],false);
				$ret["status"] = true;
				return $ret;
			break;
			case 'updateE911':
				if(!isset($req['did'])){
					return array('status' => false, 'message' => _("DID not provided"));
				}
				$did = $req['did'];
				$name = isset($req['name'])?$req['name']:'';
				$address1 = isset($req['address1'])?$req['address1']:'';
				$address2 = isset($req['address2'])?$req['address2']:'';
				$city = isset($req['city'])?$req['city']:'';
				$state = isset($req['state'])?$req['state']:'';
				$zip = isset($req['zip'])?$req['zip']:'';
				$master = isset($req['master'])?$req['master']:false;
				return $this->updateE911($did,$name, $address1,$address2,$city,$state,$zip,$master);
			break;
			case "clearFailover":
				$did = isset($req['did'])?$req['did']:'';
				$ret = $this->clearFailover($did);
				return is_array($ret)?$ret:json_decode($ret,true);
			case "updateFailover":
				$num = array('status' => true);
				$dest = array('status' => true);
				$master = isset($req['did'])?false:true;
				$did = isset($req['did'])?$req['did']:'';
				if(isset($req['num'])){
					$num = $this->updateFailover($did,'num',$req['num'], $master);
					$num = is_array($num)?$num:json_decode($num,true);
				}
				if(isset($req['dest'])){
					$dest = $this->updateFailover($did,'dest',$req['dest'], $master);
					$dest = is_array($dest)?$dest:json_decode($dest,true);
				}
				if(($num['status'] === true && $dest['status'] === true)){
					return array('status' => true, 'message' => _("Failover Updated"));
				}elseif ($num['status'] === true) {
					return array('status' => true, 'message' => _("Failover Number Updated, Destination Was not Updated"));
				}elseif ($dest['status'] === true) {
					return array('status' => true, 'message' => _("Failover Destination Updated, Number Was not Updated"));
				}else{
					return array('status' => false, 'message' => _("Failover Update Failed"));
				}
			break;
			case 'getroutes':
				return $this->getRoutes();
			break;
			case 'updateroute':
				$route_id = $req['route'];
				$include = $req['action'];
				$ret = $this->updateRoute($route_id,$include);
				return array('status' => (bool) array_product($ret));
			break;
			case 'getdids':
				return $this->getDIDs();
			break;
			case 'updateCID':
				$did = isset($req['did'])?$req['did']:'';
				$cid = isset($req['cid'])?$req['cid']:'';
				$ecid = isset($req['ecid'])?$req['ecid']:'';
				return $this->updatCID($did,$cid,$ecid);
			break;
			case 'updateDest':
				$did = isset($req['did'])?$req['did']:'';
				$dest = isset($req['dest'])?$req['dest']:'';
				if(empty($did) || empty($dest)){
					return array('status'=> false, 'message'=>_("Data Missing from request"));
				}
				return $this->updateDest($did, $dest);
			break;
		}
		return false;
	}
	public function updateCID($did,$cid,$ecid){

	}
	public function updateDest($did,$dest){
		$alldids = $this->freepbx->Core->getAllDIDs();
		$rets = array();
		$updated = 0;
		foreach($alldids as $thisdid){
			if($thisdid['extension'] == $did){
				$thisdid['destination'] = trim($dest);
				$rets[] = $this->freepbx->core->editDIDProperties($thisdid);
				$updated++;
			}
		}
		return array('status' => true, 'message' => sprintf(_("%s Route(s) updated"),$updated), 'returns'=> $rets);
	}
	public function updateRoute($route_id,$include){
		$this->freepbx->Modules->loadFunctionsInc('core');
		$trunks = core_routing_getroutetrunksbyid($route_id);
		$sstrunks = $this->getSSTrunks();
		$gw1trunk = isset($sstrunks['gw1']['trunkid'])?$sstrunks['gw1']['trunkid']:'';
		$gw2trunk = isset($sstrunks['gw2']['trunkid'])?$sstrunks['gw2']['trunkid']:'';
		switch ($include) {
			case 'setgw1':
				$trunks = array_unique(array_merge($trunks,array($gw1trunk)));
			break;
			case 'setgw2':
				$trunks = array_unique(array_merge($trunks,array($gw2trunk)));
			break;
			case 'unsetgw1':
				foreach ($trunks as $key => $value) {
					if($value === $gw1trunk){
						unset($trunks[$key]);
					}
				}
			break;
			case 'unsetgw2':
				foreach ($trunks as $key => $value) {
					if($value === $gw2trunk){
						unset($trunks[$key]);
					}
				}
			break;
			case true:
				$trunks = array_unique(array_merge($trunks,array($gw1trunk,$gw2trunk)));
			break;
			case false:
				foreach ($trunks as $key => $value) {
					if(in_array($value, array($gw1trunk, $gw2trunk))){
						unset($trunks[$key]);
					}
				}
				break;
		}

		return \core_routing_updatetrunks($route_id, $trunks, true);
	}
	/**
	 * Get all Active DIDs for this Account
	 * @param {bool} $online       = true  Whether to force an online check
	 * @param {bool} $skiptollfree = false Whether to skip tollfree numbers
	 */
	public function getDIDs($online = true, $skiptollfree = false) {
		$key = $this->ss->get_key();
		if(!empty($key)) {
			$c = $this->ss->get_config($key, $online);
			if(!empty($c['dids'])) {
				if($skiptollfree) {
					$final = array();
					foreach($c['dids'] as $did) {
						if(!preg_match($this->tollfree,$did['did'])) {
							$final[] = $did;
						}
					}
				} else {
					$final = $c['dids'];
				}
				return $final;
			}
		}
		return array();
	}
	public static function myDialplanHooks() {
		return true;
	}

	public function doDialplanHook(&$ext, $engine, $priority) {
		$ssapp = 'sipstation-welcome';
		$ext->add($ssapp, '_X.', '', new \ext_set('ISNUM','${REGEX("[0-9]" ${CALLERID(number)})}'));
		$ext->add($ssapp, '_X.', '', new \ext_db_put('sipstation/${EXTEN}/lastcall', 'cnum','${CALLERID(number)}'));
		$ext->add($ssapp, '_X.', '', new \ext_db_put('sipstation/${EXTEN}/lastcall', 'cnam','${CALLERID(name)}'));
		$ext->add($ssapp, '_X.', '', new \ext_db_put('sipstation/${EXTEN}/lastcall', 'time','${EPOCH}'));
		$ext->add($ssapp, '_X.', '', new \ext_answer(''));
		$ext->add($ssapp, '_X.', '', new \ext_wait(1));
		$ext->add($ssapp, '_X.', '', new \ext_playback('you-have-reached-a-test-number&silence/1'));
		$ext->add($ssapp, '_X.', '', new \ext_saydigits('${EXTEN}'));
		$ext->add($ssapp, '_X.', '', new \ext_playback('your&calling&from&silence/1'));
		$ext->add($ssapp, '_X.', '', new \ext_gotoif('$["${ISNUM}" = "1"]','valid','notvalid'));
		$ext->add($ssapp, '_X.', 'valid', new \ext_saydigits('${CALLERID(number)}'));
		$ext->add($ssapp, '_X.', '', new \ext_hangup());
		$ext->add($ssapp, '_X.', 'notvalid', new \ext_playback('unavailable&number'));
		$ext->add($ssapp, '_X.', '', new \ext_hangup());
	}

	/**
	 * Send the adaptor if needed
	 */
	public function smsAdaptor() {
		include(__DIR__.'/functions.inc/SipstationSMS.class.php');
		return \FreePBX\modules\Sms\Adaptor\Sipstation::Create($this->ss);
	}

	/**
	 * Check if SMS is enabled on the SIPStation Servers
	 */
	private function smsEnabled() {
		$key = $this->ss->get_key();
		if(!empty($key)) {
			$c = $this->ss->get_config($key, false);
			if(!empty($c['server_settings']['sms'])) {
				return true;
			}
		}
		return false;
	}

	public function O() {
		if (!self::$oobeobj) {
			if (!class_exists('FreePBX\\modules\\Sipstation\\Oobe')) {
				include __DIR__."/Oobe.class.php";
			}
			self::$oobeobj  = new \FreePBX\modules\Sipstation\Oobe();
		}
		return self::$oobeobj;
	}

	public function oobeHook() {
		try {
			return $this->O()->showOobe();
		} catch (\Exception $e) {
			// Woah. It broke. Mark it as broken, so it gets reset later.
			$o = \FreePBX::OOBE()->getConfig('crashed');
			if (!is_array($o)) {
				$o = array("sipstation" => array("time" => time()));
			} else {
				$o['sipstation'] = array("time" => time());
			}
			\FreePBX::OOBE()->setConfig('crashed', $o);
			return true;
		}
	}
	public function drawTrunkGroupFailover($id, $value=''){
		if($this->ssconfig['account_type'] == "TRIAL"){
			return '<input type="text" value="'._("Not Availible for Trial Accounts").'" class="form-control" readonly>';
		}
		if(isset($this->ssconfig['trunk_groups'])&& count($this->ssconfig['trunk_groups']) > 0 ){
			$input = "<select name='".$id."' id='".$id."' class='form-control'>";
			$input .= '<option>'._("Not Set").'</option>';
			foreach ($this->ssconfig['trunk_groups'] as $tg) {
				$disabled = ((int)$this->ssconfig['trunk_group_id'] === (int)$tg['id'] && is_numeric($this->ssconfig['trunk_group_id']))?'DISABLED':'';
				$selected = ((int)$tg['id'] === (int)$value && is_numeric($value))?'SELECTED':'';
				$input .= sprintf('<option value="%s" %s %s>%s</option>',$tg['id'],$selected,$disabled,$tg['title']);
			}
			$input .="</select>";
		}else{
			$input = '<input type="text" name="'.$id.'" id="'.$id.'" class="form-control" value="'._("No Trunk Groups Defined").'" disabled>';
		}
		return $input;
	}
	//API Calls//

	public function clearFailover($did=''){
		$data = empty($did)?array():array('did' => $did);
		try{
			return $this->ssapi->delete('/2/failover/'.$this->key,$data,array('CLIENT_TYPE' => 'ssmodule-'.$this->modversion));
		} catch (Exception $e) {
			$d = json_decode($e->getMessage(),true);
			$json['status'] = false;
			$json['status_message'] = _('Remote Server Error. Please try again in 10 minutes, If you continue to have problems please contact support and give them this error code') . ':(' . $d['message'] . ')';
			return $json;
		}
	}

	/**
	 * pdated the failover information with the SIPSTATION API
	 * @param  string  $did    Affected DID ommit for global_failover
	 * @param  string  $type   Failover type either num or dest
	 * @param  string  $value  what to set the value to
	 * @param  boolean $master is this the master failover default false.
	 * @return array   array((boolean)status, (string)Message )
	 */
	public function updateFailover($did='',$type,$value, $master = false){
		//Can't make this call with no key
		if(!isset($this->key)){
			return array('status' => false, 'message' => _("Sipstation Key not set"));
		}
		if($value == _("Not Set")){
			$value = '';
		}
		$data = null;
		switch ($type) {
			case 'num':
				//numbers only
				$value = trim(preg_replace('~\D~', '', $value));
				if(!empty($value)){
					$data = array(
									"num" => $value
								);
				}else{
					return array('status'=> false, 'message' => _("Phone number appears to be invalid."));
				}
			break;
			case 'dest':
				switch (false) {
					case filter_var($value, FILTER_VALIDATE_URL):
					case filter_var($value, FILTER_VALIDATE_IP):
					case filter_var($value, FILTER_VALIDATE_INT):
					$data = array(
						"dest" => $value
					);
					break;
					default:
						return array('status'=> false, 'message' => _("Destination appears to be an invalid URI."));
					break;
				}
			break;
		}
		if($data === null){
			return array('status'=> false, 'message' => _("No valid data received"));
		}
		if(!empty($did)){
			$data['did'] = '$did';
		}
		try{
			return $this->ssapi->post('/2/failover/'.$this->key,$data,array('CLIENT_TYPE' => 'ssmodule-'.$this->modversion));
		} catch (Exception $e) {
			$d = json_decode($e->getMessage(),true);
			$json['status'] = false;
			$json['status_message'] = _('Remote Server Error. Please try again in 10 minutes, If you continue to have problems please contact support and give them this error code') . ':(' . $d['message'] . ')';
			return $json;
		}
	}
	public function updateE911($did,$name, $address1,$address2,$city,$state,$zip,$master=false){
		//Can't make this call with no key
		if(!isset($this->key)){
			return array('status' => false, 'message' => _("Sipstation Key not set"));
		}
		$data = array(
				"address1" => $address1,
				"address2" => $address2,
				"state" => $state,
				"city" => $city,
				"zip" => $zip,
				"name" => $name
			);
		if($master){
			$data['master'] = '1';
		}
		$key = $this->key;
		try{
			return $this->ssapi->post('/2/e911/'.$did.'/'.$key,$data,array('CLIENT_TYPE' => 'ssmodule-'.$this->modversion));
		} catch (Exception $e) {
			$d = json_decode($e->getMessage(),true);
			$json['status'] = false;
			$json['status_message'] = _('Remote Server Error. Please try again in 10 minutes, If you continue to have problems please contact support and give them this error code') . ':(' . $d['message'] . ')';
			return $json;
		}
	}

	//END API CALLS//


}
