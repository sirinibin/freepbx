<?php
// vim: set ai ts=4 sw=4 ft=php:

class Parking implements BMO {
	public function __construct($freepbx = null) {
		if ($freepbx == null)
			throw new Exception("Not given a FreePBX Object");

		$this->FreePBX = $freepbx;
		$this->db = $freepbx->Database;
	}

	public function install() {

	}
	public function uninstall() {

	}
	public function backup(){

	}
	public function restore($backup){

	}
	public function doConfigPageInit($page){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$parking_defaults = array(
			"name" => "Lot Name",
			"type" => "public",
			"parkext" => "",
			"parkpos" => "",
			"numslots" => 4,
			"parkingtime" => 45,
			"parkedmusicclass" => "default",
			"generatehints" => "yes",
			"generatefc" => "yes",
			"findslot" => "first",
			"parkedplay" => "both",
			"parkedcalltransfers" => "caller",
			"parkedcallreparking" => "caller",
			"alertinfo" => "",
			"cidpp" => "",
			"autocidpp" => "",
			"announcement_id" => null,
			"comebacktoorigin" => "yes",
			"dest" => "",
			"rvolume" => ""
		);

		$data = array();
		switch ($_REQUEST['action']) {
			case 'add':
			case 'update':
				$vars = array();
				foreach(array_keys($parking_defaults) as $k) {
					if(isset($_REQUEST[$k]))
						$vars[$k] = $_REQUEST[$k];
				}
				if(!empty($vars)) {
					$vars['dest'] = (isset($_REQUEST['goto0']) && isset($_REQUEST[$_REQUEST['goto0'].'0'])) ? $_REQUEST[$_REQUEST['goto0'].'0'] : '';
					if($_REQUEST['action'] == 'update') {
						$vars['id'] = $_REQUEST['id'];
					}
					$id = parking_save($vars);
					if($id !== false){
						$_REQUEST['action'] = 'modify';
						$_REQUEST['id'] = $id;
					}
				}
			break;
			case 'delete':
				if(function_exists('parkpro_del')) {
					if(parkpro_del($id)) {
						$_REQUEST['action'] = '';
						$_REQUEST['id'] = '';
					}
				}
			break;
			default:
			break;
		}
	}
	public function search($query, &$results) {
		if(!ctype_digit($query)) {
			$sql = "SELECT * FROM parkplus WHERE parkext LIKE ?";
			$sth = $this->db->prepare($sql);
			$sth->execute(array("%".$query."%"));
			$rows = $sth->fetchAll(\PDO::FETCH_ASSOC);
			foreach($rows as $row) {
				$results[] = array("text" => _("ParkingLot")." ".$row['parkext'], "type" => "get", "dest" => "?display=parking&action=modify&id=".$row['id']);
			}
		} else {
			$sql = "SELECT * FROM parkplus WHERE name LIKE ?";
			$sth = $this->db->prepare($sql);
			$sth->execute(array("%".$query."%"));
			$rows = $sth->fetchAll(\PDO::FETCH_ASSOC);
			foreach($rows as $row) {
				$results[] = array("text" => $row['name'] . " (".$row['parkext'].")", "type" => "get", "dest" => "?display=parking&action=modify&id=".$row['id']);
			}
		}
	}
	public function genConfig() {
		global $version;

		if (function_exists('parkpro_get_config')) {
			return null;
		}

		if(version_compare($version, '12', 'ge')) {
			$lot = parking_get();
			$parkpos1	= $lot['parkpos'];
			$parkpos2	= $parkpos1 + $lot['numslots'] - 1;
			$park_context = 'default';
			$hint_context = 'parkedcalls';
			$conf['res_parking.conf'][$park_context] = array(
				'parkext' => $lot['parkext'],
				'parkpos' => $parkpos1."-".$parkpos2,
				'context' => $hint_context,
				'parkingtime' => $lot['parkingtime'],
				'comebacktoorigin' => 'no',
				'parkedplay' => $lot['parkedplay'],
				'courtesytone' => 'beep',
				'parkedcalltransfers' => $lot['parkedcalltransfers'],
				'parkedcallreparking' => $lot['parkedcallreparking'],
				'parkedmusicclass' => $lot['parkedmusicclass'],
				'findslot' => $lot['findslot']
			);
			$conf['res_parking.conf'][][] = "#include res_parking_custom.conf";
			return $conf;
		}
	}
	public function writeConfig($conf){
		$this->FreePBX->WriteConfig($conf);
	}
	public function getActionBar($request) {
		$buttons = array();
		switch($request['display']) {
			case 'parking':
				$buttons = array(
					'delete' => array(
						'name' => 'delete',
						'id' => 'delete',
						'value' => _("Delete")
					),
					'reset' => array(
						'name' => 'reset',
						'id' => 'reset',
						'value' => _('Reset')
					),
					'submit' => array(
						'name' => 'submit',
						'id' => 'submit',
						'value' => _('Submit')
					)
				);
				if (empty($request['id']) || !function_exists('parkpro_view')) {
					unset($buttons['delete']);
				}
				if(!isset($request['action']) && function_exists('parkpro_view')){
					$buttons = array();
				}
			break;
		}
		return $buttons;
	}
	public function getRightNav($request) {
		if(function_exists('parkpro_view')){
			return \FreePBX::Parkpro()->getRightNav($request);
		}
	}
}
