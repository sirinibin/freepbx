<?php
namespace FreePBX\modules;
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
//

class Directory implements \BMO {
	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new Exception("Not given a FreePBX Object");
		}
		$this->FreePBX = $freepbx;
		$this->db = $freepbx->Database;
	}
	public function install() {}
	public function uninstall() {}
	public function backup() {}
	public function restore($backup) {}
	public function doConfigPageInit($page) {
		$request = $_REQUEST;
		$request['action'] = !empty($request['action']) ? $request['action'] : "";
		switch($page){
			case 'directory':
				//check for ajax request and process that immediately
				if(isset($_REQUEST['ajaxgettr'])){//got ajax request
					$opts = $opts=explode('|', urldecode($_REQUEST['ajaxgettr']));
					if($opts[0] == 'all') {
						echo directory_draw_entries_all_users($opts[1]);
					} else {
						if ($opts[0] != '') {
							$real_id = $opts[0];
							$name = '';
							$realname = $opts[1];
							$audio = 'vm';
						} else {
							$real_id = 'custom';
							$name = $opts[1];
							$realname = 'Custom Entry';
							$audio = 'tts';
						}
						echo directory_draw_entries_tr($opts[0], $real_id, $name, $realname, $audio,'',$opts[2]);
					}
					exit;
				}
				$requestvars = array('id', 'action', 'entries', 'newentries', 'def_dir', 'Submit');
				foreach ($requestvars as $var){
					switch($var) {
						case 'def_dir':
							$rvars_def = false;
							break;
						default:
							$rvars_def = '';
							break;
					}
					$$var = isset($_REQUEST[$var]) ? $_REQUEST[$var] : $rvars_def;
				}

				if (isset($Submit) && $Submit == 'Submit' && isset($def_dir) && $def_dir !== false) {
					directory_save_default_dir($def_dir);
				}
			break;
		}
		if($page == 'directory'){
			//get variables for directory_details
			$requestvars = array('id','dirname','description','announcement',
							'callid_prefix','alert_info','repeat_loops',
							'repeat_recording','invalid_recording',
							'invalid_destination','retivr','say_extension','rvolume');
			foreach($requestvars as $var){
				$vars[$var] = isset($_REQUEST[$var]) 	? $_REQUEST[$var]		: null;
			}
			$action		= isset($_REQUEST['action'])	? $_REQUEST['action']	: null;
			$entries	= isset($_REQUEST['entries'])	? $_REQUEST['entries']	: null;
			//$entries=(($entries)?array_values($entries):'');//reset keys
			switch($action){
				case 'edit':
					//get real dest
					$vars['invalid_destination'] = $_REQUEST[$_REQUEST['goto0'].'0'];
					$vars['id'] = directory_save_dir_details($vars);
					\directory_save_dir_entries($vars['id'],$entries);
					$this_dest = directory_getdest($vars['id']);
					\fwmsg::set_dest($this_dest[0]);
					needreload();
					$_REQUEST['id'] = $vars['id'];
				break;
				case 'delete':
					directory_delete($vars['id']);
					needreload();
				break;
			}
		}
	}
	public function getGrid(){
		$results = $this->listDirectories();
		$def_dir = $this->getDefault();
		$dirs = array();
		if($results){
			foreach ($results as $key=>$result){
				$result['default'] = false;
				if (!$result['dirname']) {
					$result['dirname'] = 'Directory '.$result['id'];
				}
				if ($result['id'] == $def_dir) {
					$result['default'] = true;
				}
				$dirs[] = array(
						'id' => $result['id'],
						'name' => $result['dirname'],
						'link' => array('id' => $result['id'], 'name' => $result['dirname']),
						'default' => array('id'=> $result['id'],'default' => $result['default'])
					);
			}
		}
		return $dirs;
	}
	public function listDirectories(){
		$sql='SELECT id,dirname FROM directory_details ORDER BY dirname';
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$results = $stmt->fetchall(\PDO::FETCH_ASSOC);
		return $results;
	}
	public function getDefault(){
		$sql = "SELECT value FROM `admin` WHERE `variable` = 'default_directory'";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$ret = $stmt->fetchColumn();
		return $ret ? $ret : '';
	}
	public function getActionBar($request) {
		$buttons = array();
		switch($request['display']) {
			case 'directory':
				$buttons = array(
					'delete' => array(
						'name' => 'delete',
						'id' => 'delete',
						'value' => _('Delete')
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
				if (empty($request['id'])) {
					unset($buttons['delete']);
				}
				if(empty($request['view']) || $request['view'] != 'form'){
					$buttons = array();
				}
			break;
		}
		return $buttons;
	}
	public function ivrHook($request){
		if(isset($request['id'])){
			$ivr = \FreePBX::Ivr()->getDetails($request['id']);
		}
		$directdial = isset($ivr['directdial'])?$ivr['directdial']:'';
		$dirs = directory_list();
		$options = '$("<option />", {text: \''._("Disabled").'\'}).appendTo(sel);';
		$options .= '$("<option />", {val: \'ext-local\', text: \''._("Enabled").'\'}).appendTo(sel);';
		foreach ($dirs as $dir) {
			$name = $dir['dirname'] ? $dir['dirname'] : 'Directory ' . $dir['id'];
			$options .= '$("<option />", {val: \''.$dir['id'].'\', text: \''.$name.'\'}).appendTo(sel);';
		}
		$html = '
			<script type="text/javascript">
				var sel = $("<select id=\"directdial\" name=\"directdial\" class=\"form-control\" />");
				var target = $("#directdialyes").parent();
			';
		$html .= $options;
		$html .='
				$(target).html(sel);
				$("#directdial").find("option").each( function() {
  				var $this = $(this);
  					if ($this.val() == "'.$directdial.'") {
     					$this.attr("selected","selected");
     					return false;
  					}
					});
			</script>
		';
		return $html;
	}
	public function ajaxRequest($req, &$setting) {
		switch ($req) {
			case 'getJSON':
				return true;
			break;
			default:
				return false;
			break;
		}
	}
	public function ajaxHandler(){
		switch ($_REQUEST['command']) {
			case 'getJSON':
				switch ($_REQUEST['jdata']) {
					case 'grid':
						return $this->getGrid();
					break;

					default:
						return false;
					break;
				}
			break;

			default:
				return false;
			break;
		}
	}
	public function getRightNav($request) {
		if(isset($request['view']) && $request['view'] == 'form'){
    	return load_view(__DIR__."/views/bootnav.php",array());
		}
	}
}
