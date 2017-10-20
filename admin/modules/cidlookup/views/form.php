<?php
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
extract($request);
if (!empty($itemid)){
    $thisItem = cidlookup_get($itemid);
    $dids_using_arr = cidlookup_did_list($itemid);
    $dids_using = count($dids_using_arr);
    $thisItem_description = isset($thisItem['description']) ? htmlspecialchars($thisItem['description']):'';
    $opencnamopt = ($thisItem['sourcetype'] == 'opencnam')?'<option value="opencnam" selected>'. _("OpenCNAM").'</option>':'';
} else {
    $thisItem = Array( 'description' => '', 'sourcetype' => null, 'cache' => null, 'itemid' => null, 'opencnam_account_sid' => null, 'cm_group' => '', 'cm_format' => '4');
    $thisItem_description = '';
    $itemid = '';
    $opencnamopt = '<option value="opencnam" selected>'. _("OpenCNAM").'</option>';
}
$sthelphtml = _("Select the source type, you can choose between:")
.'<ul>'
.'<li>'. _("OpenCNAM:") . _(" Use OpenCNAM [https://www.opencnam.com/]").'</li>'
.'<li>'. _("Internal:") . _(" use astdb as lookup source, use phonebook module to populate it").'</li>'
.'<li>'. _("ENUM:") . _(" Use DNS to lookup caller names, it uses ENUM lookup zones as configured in enum.conf").'</li>'
.'<li>'. _("HTTP:") . _(" It executes an HTTP GET passing the caller number as argument to retrieve the correct name").'</li>'
.'<li>'. _("HTTPS:") . _(" It executes an HTTPS GET passing the caller number as argument to retrieve the correct name").'</li>'
.'<li>'. _("MySQL:") . _("It queries a MySQL database to retrieve caller name").'</li>'
.'<li>'. _("Contact Manager:") . _("Searches a contact manager group").'</li>'
.'</ul>';

//OpenCNAM PRO
$cnampro = false;
if($thisItem['opencnam_account_sid'] && $thisItem['opencnam_auth_token']){
	$cnampro = true;
}

if(FreePBX::Modules()->checkStatus('contactmanager')){
    $groups = FreePBX::Contactmanager()->getGroups();
    $groupselect = explode('_', $thisItem['cm_group']);
    foreach ($groups as $group) {
        $selected = in_array($group['id'], $groupselect)?'SELECTED':'';
        $cmopts .= '<option value = "'.$group['id'].'" '.$selected.'>'.$group['name'].'</option>';
    }
}else{
  $cmopts = '<option value = "" disabled>'._("Contact Manager Not Installed").'</option>';
}


//In Use Data
if ($itemid && $dids_using > 0){
	$inusehtml = '<div class="well">';
	$inusehtml .= '<p>'.sprintf(_("There are %s DIDs using this source that will no longer have lookups if deleted."),$dids_using).'</p>';
	$inusehtml .= '</div>';
	echo $inusehtml;
}
?>

<form autocomplete="off" class="fpbx-submit" name="edit" id="edit" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return edit_onsubmit();" data-fpbx-delete="config.php?display=cidlookup&view=form&amp;itemid=<?php echo $itemid?>&amp;action=delete"">
<input type="hidden" name="display" value="cidlookup">
<input type="hidden" name="action" value="<?php echo ($itemid ? 'edit' : 'add') ?>">

<!--Source Description-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="form_description"><?php echo _("Source Description") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="form_description"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="form_description" name="description" value="<?php echo $thisItem_description; ?>" maxlength="50">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="form_description-help" class="help-block fpbx-help-block"><?php echo _("Enter a description for this source.")?></span>
		</div>
	</div>
</div>
<!--END Source Description-->
<!--Source type-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="sourcetype"><?php echo _("Source type") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="sourcetype"></i>
					</div>
					<div class="col-md-9">
						<select id="sourcetype" name="sourcetype" class="form-control">
              <?php echo $opencnamopt?>
							<option value="internal" <?php echo ($thisItem['sourcetype'] == 'internal' ? 'selected' : '')?>><?php echo _("Internal")?></option>
							<option value="contactmanager" <?php echo ($thisItem['sourcetype'] == 'contactmanager' ? 'selected' : '')?>><?php echo _("Contact Manager")?></option>
							<option value="enum" <?php echo ($thisItem['sourcetype'] == 'enum' ? 'selected' : '')?>>ENUM</option>
							<option value="http" <?php echo ($thisItem['sourcetype'] == 'http' ? 'selected' : '')?>>HTTP</option>
							<option value="https" <?php echo ($thisItem['sourcetype'] == 'https' ? 'selected' : '')?>>HTTPS</option>
							<option value="mysql" <?php echo ($thisItem['sourcetype'] == 'mysql' ? 'selected' : '')?>>MySQL</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="sourcetype-help" class="help-block fpbx-help-block"><?php echo $sthelphtml ?></span>
		</div>
	</div>
</div>
<!--END Source type-->
<!--Cache Results-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="cache"><?php echo _("Cache Results") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="cache"></i>
					</div>
					<div class="col-md-9 radioset">
						<input type="radio" name="cache" id="cacheyes" value="1" <?php echo ($thisItem['cache'] == "1"?"CHECKED":"") ?>>
						<label for="cacheyes"><?php echo _("Yes");?></label>
						<input type="radio" name="cache" id="cacheno" <?php echo ($thisItem['cache'] == "1"?"":"CHECKED") ?> value="0">
						<label for="cacheno"><?php echo _("No");?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="cache-help" class="help-block fpbx-help-block"><?php echo _("Decide whether or not cache the results to astDB; it will overwrite present values. It does not affect Internal source behavior")?></span>
		</div>
	</div>
</div>
<!--END Cache Results-->
<!--Contact Manager-->
<div id="contactmanager" style="display: none">
  <!--Group-->
  <div class="element-container cm">
  	<div class="row">
  		<div class="col-md-12">
  			<div class="row">
  				<div class="form-group">
  					<div class="col-md-3">
  						<label class="control-label" for="cm_group"><?php echo _("Contact Manager Group(s)") ?></label>
  						<i class="fa fa-question-circle fpbx-help-icon" data-for="cm_group"></i>
  					</div>
  					<div class="col-md-9">
              <select id='cm_group' name = 'cm_group[]' class="form-control" multiple="multiple">
                <?php echo $cmopts?>
              </select>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-12">
  			<span id="cm_group-help" class="help-block fpbx-help-block"><?php echo _("Filter results to these contact manager groups")?></span>
  		</div>
  	</div>
  </div>
  <!--END Group-->

  <!--Format-->
  <div class="element-container cm">
  	<div class="row">
  		<div class="col-md-12">
  			<div class="row">
  				<div class="form-group">
  					<div class="col-md-3">
  						<label class="control-label" for="cm_format"><?php echo _("Caller ID Format") ?></label>
  						<i class="fa fa-question-circle fpbx-help-icon" data-for="cm_format"></i>
  					</div>
  					<div class="col-md-9">
              <select id='cm_format' name = 'cm_format' class="form-control">
                <option value "4" <?php echo ($thisItem['cm_group'] == '4')?'SELECTED':'';?>><?php echo _("First Last")?></option>
                <option value "3" <?php echo ($thisItem['cm_group'] == '3')?'SELECTED':'';?>><?php echo _("Last First")?></option>
                <option value "2" <?php echo ($thisItem['cm_group'] == '2')?'SELECTED':'';?>><?php echo _("Company")?></option>
                <option value "1" <?php echo ($thisItem['cm_group'] == '1')?'SELECTED':'';?>><?php echo _("Display Name")?></option>
              </select>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-12">
  			<span id="cm_format-help" class="help-block fpbx-help-block"><?php echo _("How to format the returned data")?></span>
  		</div>
  	</div>
  </div>
  <!--END Group-->
</div>
<!--OPEN CNAM ELEMENTS-->
<div id="opencnam" style="display: none">
<div class="well">
    <?php echo _("<p>If you need to create an OpenCNAM account, you can visit their website: <a href=\"https://www.opencnam.com/register\" target=\"_blank\">https://www.opencnam.com/register</a></p>")?>
</div>
<!--Account SID:-->
<div class="element-container opencnam">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="opencnam_account_sid"><?php echo _("Account SID:") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="opencnam_account_sid"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="opencnam_account_sid" name="opencnam_account_sid" value="<?php echo (isset($thisItem['opencnam_account_sid']) ? $thisItem['opencnam_account_sid'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="opencnam_account_sid-help" class="help-block fpbx-help-block"><?php echo _("Your OpenCNAM Account SID. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard")?></span>
		</div>
	</div>
</div>
<!--END Account SID:-->
<!--Auth Token-->
<div class="element-container opencnam">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="opencnam_auth_token"><?php echo _("Auth Token") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="opencnam_auth_token"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="opencnam_auth_token" name="opencnam_auth_token" value="<?php echo (isset($thisItem['opencnam_auth_token']) ? $thisItem['opencnam_auth_token'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="opencnam_auth_token-help" class="help-block fpbx-help-block"><?php echo _("Your OpenCNAM Auth Token. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard")?></span>
		</div>
	</div>
</div>
<!--END Auth Token-->
</div>
<!--END OPEN CNAM ELEMENTS-->
<!--HTTP(s) ELEMENTS -->
<div id="http" style="display: none">
<!--Host-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="http_host"><?php echo _("Host") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="http_host"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="http_host" name="http_host" value="<?php echo (isset($thisItem['http_host']) ? $thisItem['http_host'] : ''); ?>" maxlength="100">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="http_host-help" class="help-block fpbx-help-block"><?php echo _("Host name or IP address")?></span>
		</div>
	</div>
</div>
<!--END Host-->
<!--Port-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="http_port"><?php echo _("Port") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="http_port"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="http_port" name="http_port" value="<?php echo (isset($thisItem['http_port']) ? $thisItem['http_port'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="http_port-help" class="help-block fpbx-help-block"><?php echo _("Port HTTP(s) server is listening at (default http 80, https 443)")?></span>
		</div>
	</div>
</div>
<!--END Port-->
<!--Username-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="http_username"><?php echo _("Username") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="http_username"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="http_username" name="http_username" value="<?php echo (isset($thisItem['http_username']) ? $thisItem['http_username'] : ''); ?>" maxlength="100">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="http_username-help" class="help-block fpbx-help-block"><?php echo _("Username to use in HTTP authentication")?></span>
		</div>
	</div>
</div>
<!--END Username-->
<!--Password-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="http_password"><?php echo _("Password") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="http_password"></i>
					</div>
					<div class="col-md-9">
						<input type="password" class="form-control" id="http_password" name="http_password" value="<?php echo (isset($thisItem['http_password']) ? $thisItem['http_password'] : ''); ?>" maxlength="100">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="http_password-help" class="help-block fpbx-help-block"><?php echo _("Password to use in HTTP authentication")?></span>
		</div>
	</div>
</div>
<!--END Password-->
<!--Path-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="http_path"><?php echo _("Path") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="http_path"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="http_path" name="http_path" value="<?php echo (isset($thisItem['http_path']) ? $thisItem['http_path'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="http_path-help" class="help-block fpbx-help-block"><?php echo _("Path of the file to GET<br/>e.g.: /cidlookup.php<br>Special token '[NUMBER]' will be replaced with caller number<br/>e.g.: /cidlookup/[NUMBER]/<br/>'[NAME]' will be replaced with existing caller id name<br/>'[LANGUAGE]' will be replaced with channel language")?></span>
		</div>
	</div>
</div>
<!--END Path-->
<!--Query-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="http_query"><?php echo _("Query") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="http_query"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="http_query" name="http_query" value="<?php echo (isset($thisItem['http_query']) ? $thisItem['http_query'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="http_query-help" class="help-block fpbx-help-block"><?php echo _("Query string, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: number=[NUMBER]&source=crm<br/>'[NAME]' will be replaced with existing caller id name<br/>'[LANGUAGE]' will be replaced with channel language")?></span>
		</div>
	</div>
</div>
<!--END Query-->
</div>
<!--END HTTP(s) ELEMENTS -->
<!--MySQL Elements -->
<div id="mysql" style="display: none">
<!--Host-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="mysql_host"><?php echo _("Host") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="mysql_host"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="mysql_host" name="mysql_host" value="<?php echo (isset($thisItem['mysql_host']) ? $thisItem['mysql_host'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="mysql_host-help" class="help-block fpbx-help-block"><?php echo _("MySQL Host")?></span>
		</div>
	</div>
</div>
<!--END Host-->
<!--Database-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="mysql_dbname"><?php echo _("Database") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="mysql_dbname"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="mysql_dbname" name="mysql_dbname" value="<?php echo (isset($thisItem['mysql_dbname']) ? $thisItem['mysql_dbname'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="mysql_dbname-help" class="help-block fpbx-help-block"><?php echo _("Database Name")?></span>
		</div>
	</div>
</div>
<!--END Database-->
<!--Query-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="mysql_query"><?php echo _("Query") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="mysql_query"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="mysql_query" name="mysql_query" value="<?php echo (isset($thisItem['mysql_query']) ? $thisItem['mysql_query'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="mysql_query-help" class="help-block fpbx-help-block"><?php echo _("Query, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: SELECT name FROM phonebook WHERE number LIKE '%[NUMBER]%'")?></span>
		</div>
	</div>
</div>
<!--END Query-->
<!--Username-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="mysql_username"><?php echo _("Username") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="mysql_username"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="mysql_username" name="mysql_username" value="<?php echo (isset($thisItem['mysql_username']) ? $thisItem['mysql_username'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="mysql_username-help" class="help-block fpbx-help-block"><?php echo _("MySQL Username")?></span>
		</div>
	</div>
</div>
<!--END Username-->
<!--Password-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="mysql_password"><?php echo _("Password") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="mysql_password"></i>
					</div>
					<div class="col-md-9">
						<input type="password" class="form-control" id="mysql_password" name="mysql_password" value="<?php echo (isset($thisItem['mysql_password']) ? $thisItem['mysql_password'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="mysql_password-help" class="help-block fpbx-help-block"><?php echo _("MySQL Password")?></span>
		</div>
	</div>
</div>
<!--END Password-->
<!--Character Set-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="mysql_charset"><?php echo _("Character Set") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="mysql_charset"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="mysql_charset" name="mysql_charset" value="<?php echo (isset($thisItem['mysql_charset']) ? $thisItem['mysql_charset'] : ''); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="mysql_charset-help" class="help-block fpbx-help-block"><?php echo _("MySQL Character Set. Leave blank for MySQL default latin1")?></span>
		</div>
	</div>
</div>
<!--END Character Set-->
</div>
<!--END MySQL Elements -->
<div id="sugarcrm" style="display: none">
	<div class = "well">
		<p><?php echo _("Not yet implemented")?></p>
	</div>
</div>
<div id="superfecta" style="display: none">
		<div class = "well">
		<p><?php echo _("Not yet implemented")?></p>
	</div>
</div>

</form>
