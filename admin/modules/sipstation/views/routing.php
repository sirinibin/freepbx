<?php
$routes = array();
$dids = array();
?>

<div class="alert alert-info">
	<?php echo _("Select/Unselect the butons and submit to add/remove this service as the primary trunks to any listed route. Both gateways should be configured to allow for redundancy. If gateways are already configured in the route, the box will be checked, even if they are not the primary trunks for that route. Click on the route name to link directly to the Outbound Routes page for any route.") ?>
	<br/>
	<?php echo sprintf(_("Check Primary (%s) and Secondary (%s) Trunk for each route that should be configured with the %s service. The trunks will be inserted into the corresponding routes upon clicking the %s button. You can enable 7 digit dialing with the trunk by entering your area code as well."),"<i>gw1</i>","<i>gw2</i>","SIPStation","<i>"._("Update Route/Trunk Configurations")."</i>") ?>
</div>
	<div id="toolbar-routes">
	<!--Area Code-->
	<div class="element-container">
		<div class="row">
			<div class="form-group">
				<div class="col-md-5">
					<label class="control-label" for="areacode"><?php echo _("Area Code")?></label>
				</div>
				<div class="col-md-5">
					<input type="text" maxlength="3" class="form-control" id="areacode" name="areacode" value="<?php echo isset($prepend_digits)?$prepend_digits:''?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5">
				<span id="areacode-help" class="help-block fpbx-help-block"><?php echo _("Provide your 3 digit area code if you would like your trunks to allow 7 digit dialing and automatically prepend your area code. This requires the route to be configured to send a 7 digit number.")?></span>
			</div>
		</div>
	</div>
	<!--END Area Code-->
</div>
	<table id="ssroutes" data-toolbar="#toolbar-routes" data-maintain-selected="true" data-checkbox-header="false" data-show-columns="true" data-show-toggle="true" data-toggle="table" data-pagination="true" data-search="true" data-url="ajax.php?module=sipstation&amp;command=getroutes" class="table table-striped">
		<thead>
			<tr class="trunk_routes_section">
				<th data-sortable="true" data-field="name"><?php echo _("Route Name")?></th>
				<th data-field="gw1_checked" 	data-formatter="route_gateway_formatter1"><?php echo _("Primary Gateway")?></th>
				<th data-field="gw2_checked" 	data-formatter="route_gateway_formatter2"><?php echo _("Secondary Gateway")?></th>
			</tr>
		</thead>
	</table>
</form>

<form autocomplete="off" id="editdid" name="editdid" action="" method="post">
	<input type="hidden" name="type" value="editdid">
	<div class="alert alert-info">
		<?php echo _("Here you can manage your DIDs<br>Specifically you can do the following: ") ?>
		<ul>
			<li><strong><?php echo _("DID"); ?>:</strong> <?php echo _("Your DID, Clicking here will take you to the inbound route setup for this DID")?></li>
			<li><strong><?php echo _("Set E911"); ?>:</strong> <?php echo _("Set and edit the E911 address for a DID. (Fees apply for multiple E911 addresses.)")?></li>
			<li><strong><?php echo _("Failover Number"); ?>:</strong> <?php echo _("Set and edit your per-DID failover numbers.")?></li>
			<li><strong><?php echo _("Description"); ?>:</strong> <?php echo _("Set A Description for the Inbound Routes Page")?></li>
			<li><strong><?php echo _("Route To"); ?>:</strong> <?php echo _("Route Your DID to a specified location")?></li>
			<li><strong><?php echo _("Set CID"); ?>:</strong> <?php echo _("Automatically set the extension's CID to match the DID, if this DID is routed to an extension.")?></li>
			<li><strong><?php echo _("Set ECID"); ?>:</strong> <?php echo _("Set the extension's Emergency CID to match one of your E911-enabled DIDs.")?></li>
		</ul>
	</div>
	<table id="ssdids" data-maintain-selected="true" data-show-columns="true" data-show-toggle="true" data-toggle="table" data-pagination="true" data-search="true" class="table table-striped" data-url="ajax.php?module=sipstation&amp;command=getdids">
	<thead>
		<tr class="account-settings did_section">
			<th data-sortable="true" data-field="did"><?php echo _("DID") ?></th>
			<th data-field="e911" data-formatter="e911Formatter"><?php echo _("Set E911") ?></th>
			<th data-field="failover" data-formatter="failoverFormatter"><?php echo _("Failover Num") ?></th>
			<th data-field="description" data-formatter="descriptionFormatter"><?php echo _("Description") ?></th>
			<th data-field="destination" data-formatter="destinationFormatter"><?php echo _("Route To") ?></th>
			<th data-field="cid" data-formatter="cidFormatter"><?php echo _("Set CID") ?></th>
			<th data-field="ecid" data-formatter="cidFormatter"><?php echo _("Emergency CID") ?></th>
			<th data-field="lastcall"><?php echo _("Last Call") ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($dids as $did) { continue;?>
			<tr class="account-settings did_section">
				<td><input type="hidden" name="dids[]" value="<?php echo $did['did']?>"><input type="hidden" name="failover_old_<?php echo $did['did']?>" value="<?php echo $did['failover']['num'] ?>"><a href="config.php?display=did&amp;extdisplay=<?php echo $did['did']; ?>" id="did-color-<?php echo $did['did']?>" style="color:<?php echo !empty($did['e911']['name']) ? ($did['e911']['master'] ? 'green' : 'orange') : 'black' ?>"><?php echo $did['did'] ?></a></td>
				<td><a href="#" id="did-name-<?php echo $did['did']?>" onclick="$( '#dialog-<?php echo $did['did']?>' ).dialog( 'open' );return false;"><?php echo (isset($did['e911']['name']) && !empty($did['e911']['name'])) ? 'Modify' : 'Set'?></a></td>
				<td><input type="text" class="form-control" max="10" name="failover_<?php echo $did['did']?>" maxlength="10" value ="<?php echo $did['failover']['num'] ?>" <?php echo $disabled; ?>></td>
				<td><input type="text" class="form-control" name="description_<?php echo $did['did']?>" value ="<?php echo $did['description'] ?>"></td>
				<td><?php echo drawselects($did['destination'], $did['did'], false, false)?></td>
				<td>
					<select id="setcid-<?php echo $did['did']?>" class="form-control" name="setcid_<?php echo $did['did']?>" style="<?php if(!preg_match('/from-did-direct/',$did['destination'])) {?>display:none;<?php } ?>">
						<option value="unchanged">Unchanged</option>
						<option value="none" <?php echo empty($did['cid']) ? 'selected' : '' ?>>None</option>
						<?php foreach($dids as $subdid) { ?>
							<option value="<?php echo $subdid['did']?>" <?php echo ($subdid['did'] == $did['cid']) ? 'selected' : ''?>><?php echo $subdid['did']?></option>
						<?php } ?>
					</select>
				</td>
				<td>
					<select id="selectecid-<?php echo $did['did']?>" class="form-control" name="selectecid_<?php echo $did['did']?>" style="<?php if(!preg_match('/from-did-direct/',$did['destination'])) {?>display:none;<?php } ?>">
						<option value="unchanged">Unchanged</option>
						<option value="none" <?php echo empty($did['ecid']) ? 'selected' : '' ?>>None</option>
						<?php foreach($e911_list as $list) {?>
							<option value="<?php echo $list['did']?>" <?php echo ($list['did'] == $did['ecid']) ? 'selected' : ''?>><?php echo $list['did']?></option>
						<?php } ?>
						</select>
				</td>
				<td>
					<?php
					$number = $did['lastcall'];
					echo $number;
					?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>
	<input class="account-settings did_section" type="submit" id="did-submit-button"  value="<?php echo _("Update DID Configurations")?>" tabindex="<?php echo ++$tabindex;?>" />
</form>


		<?php foreach($dids as $did) { ?>
			<div id="dialog-<?php echo $did['did']?>" title="<?php echo $did['did']?> Options" style="display: none">
				<h2><?php echo _('Address On Record')?>:</h2>
				<form method="post" id="didform-<?php echo $did['did']?>">
					<div class="form-group">
						<label for="name-<?php echo $did['did']?>"><?php echo _("Caller Name:")?></label>
						<input type="text" class="form-control" name="name-<?php echo $did['did']?>" id="name-<?php echo $did['did']?>" value="<?php echo isset($did['e911']['name']) ? $did['e911']['name'] : '' ?>" <?php echo $disabled; ?>>
					</div>
					<div class="form-group">
						<label for="address1-<?php echo $did['did']?>"><?php echo _("Address1:")?></label>
						<input type="text" class="form-control" name="address1-<?php echo $did['did']?>" id="address1-<?php echo $did['did']?>" value="<?php echo isset($did['e911']['street1']) ? $did['e911']['street1'] : ''?>" <?php echo $disabled; ?>>
					</div>
					<div class="form-group">
						<label for="address2-<?php echo $did['did']?>"><?php echo _("Address2:")?></label>
						<input type="text" class="form-control" name="address2-<?php echo $did['did']?>" id="address2-<?php echo $did['did']?>" value="<?php echo isset($did['e911']['street2']) ? $did['e911']['street2'] : ''?>" <?php echo $disabled; ?>>
					</div>
					<div class="form-group">
						<label for="city-<?php echo $did['did']?>"><?php echo _("City:")?></label>
						<input type="text" class="form-control" name="city-<?php echo $did['did']?>" id="city-<?php echo $did['did']?>" value="<?php echo isset($did['e911']['city']) ? $did['e911']['city'] : ''?>" <?php echo $disabled; ?>>
					</div>
					<div class="form-group">
						<label for="state-<?php echo $did['did']?>"><?php echo _("State:")?></label>
						<input type="text" class="form-control" name="state-<?php echo $did['did']?>" id="state-<?php echo $did['did']?>" value="<?php echo isset($did['e911']['state']) ? $did['e911']['state'] : ''?>" <?php echo $disabled; ?>>
					</div>
					<div class="form-group">
						<label for="zip-<?php echo $did['did']?>"><?php echo _("Zip:")?></label>
						<input type="text" class="form-control" name="zip-<?php echo $did['did']?>" id="zip-<?php echo $did['did']?>" value="<?php echo isset($did['e911']['zip']) ? $did['e911']['zip'] : ''?>" <?php echo $disabled; ?>>
					</div>
					<span id="agreement-span-<?php echo $did['did']?>" style="<?php if(isset($did['e911']['master']) && $did['e911']['master']) {?>display:none<?php } ?>"><label><input type="checkbox" name="agreement-<?php echo $did['did']?>" <?php echo (isset($did['e911']['name']) && !empty($did['e911']['name'])) ? 'checked' : '' ?> <?php echo $disabled; ?>>I agree to additional charges and have read the documentation here: <a style="color:blue" target="_blank" href="http://wiki.freepbx.org/display/ST/Additional+e911+Addresses">Additional E911 Addresses</a></label><br /></span>
					<input type="hidden" name="type" value="updatee911">
					<input type="hidden" id="e911master-<?php echo $did['did']?>" name="e911master" value="<?php if(!isset($did['e911']['master']) || !$did['e911']['master']) {?>no<?php } else { ?>yes<?php } ?>">
					<input type="hidden" name="didmaster" value="<?php echo $did['did']?>">
					<input type="button" id="updatee911-<?php echo $did['did']?>" name="updatee911" value="<?php if(isset($did['e911']['name'])) {?>Update<?php } else { ?>Add<?php } ?>" onclick="update911('update','<?php echo $did['did']?>')">
					<input type="button" id="sete911master-<?php echo $did['did']?>" name="sete911master" value="Set As Master E911" onclick="update911('master','<?php echo $did['did']?>')" style="<?php if(!isset($did['e911']['name']) || $did['e911']['master']) {?>display:none<?php } ?>">
					<input type="button" id="deletee911-<?php echo $did['did']?>" name="deletee911" value="Delete E911 for DID" onclick="update911('delete','<?php echo $did['did']?>')" style="<?php if(!isset($did['e911']['name']) || $did['e911']['master']) {?>display:none<?php } ?>">
			</form>
		</div>

		<?php } ?>
		<div class="modal fade" tabindex="-1" role="dialog" id="routecidmodal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><?php echo _("Edit CallerID Information")?></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" id="routeciddid" value="">
						<!--Caller ID-->
						<div class="element-container">
							<div class="row">
								<div class="form-group">
									<div class="col-md-3">
										<label class="control-label" for="routecid"><?php echo _("Caller ID") ?></label>
										<i class="fa fa-question-circle fpbx-help-icon" data-for="routecid"></i>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control" id="routecid" name="routecid" value="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="routecid-help" class="help-block fpbx-help-block"><?php echo _("Caller ID For this DID")?></span>
								</div>
							</div>
						</div>
						<!--END Caller ID-->
						<!--Emergency Caller ID-->
						<div class="element-container">
							<div class="row">
								<div class="form-group">
									<div class="col-md-3">
										<label class="control-label" for="routeecid"><?php echo _("Emergency Caller ID") ?></label>
										<i class="fa fa-question-circle fpbx-help-icon" data-for="routeecid"></i>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control" id="routeecid" name="routeecid" value="">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="routeecid-help" class="help-block fpbx-help-block"><?php echo _("Caller ID for Emergency calls")?></span>
								</div>
							</div>
						</div>
						<!--END Emergency Caller ID-->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _("Close")?></button>
						<button type="button" id = "cidroutesave" class="btn btn-primary"><?php echo _("Save changes")?></button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" tabindex="-1" role="dialog" id="e911routemodal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><?php echo _("Edit E911 Information")?></h4>
					</div>
					<div class="modal-body">
						<input type="hidden" name="routehiddendid" id="routehiddendid" value="">
						<!--E911 Caller ID-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="routenoocidw"><?php echo _("E911 Caller ID") ?></label>
											</div>
											<div class="col-md-9">
												<span id="routedid"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--END E911 Caller ID-->
						<!--Name-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="routename"><?php echo _("Name") ?></label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="routename" name="routename" value="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--END Name-->
						<!--Address 1-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="routeaddress1"><?php echo _("Address 1") ?></label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="routeaddress1" name="routeaddress1" value="" placeholder="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--END Address 1-->
						<!--Address 2-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="routeaddress2"><?php echo _("Address 2") ?></label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="routeaddress2" name="address2" value="" >
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--END Address 2-->
						<!--City-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="routecity"><?php echo _("City") ?></label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="routecity" name="routecity" value="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--END City-->
						<!--State-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="routestate"><?php echo _("State") ?></label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="routestate" name="routestate" value="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--END State-->
						<!--Zip-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="routezip"><?php echo _("Zip") ?></label>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="routezip" name="routezip" value="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--END Zip-->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _("Close")?></button>
						<button type="button" id = "e911routesave" class="btn btn-primary"><?php echo _("Save changes")?></button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="routedestmodal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><?php echo _("Edit Destination Information")?></h4>
					</div>
					<div class="modal-body" id="routedestbody">
						<input type="hidden" id="routedestdid">
						<!--Destination-->
						<div class="element-container">
							<div class="row">
								<div class="form-group">
									<div class="col-md-3">
										<label class="control-label" for="routedestination"><?php echo _("Destination") ?></label>
									</div>
									<div class="col-md-9">
										<?php echo drawselects($goto, 0, false, true,'', false, false, false, false,'');?>
									</div>
								</div>
							</div>
						</div>
						<!--END Destination-->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _("Close")?></button>
						<button type="button" id = "routedestsave" class="btn btn-primary"><?php echo _("Save changes")?></button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="didfailover">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title"><?php echo _("Edit Global Failover")?></h4>
		      </div>
		      <div class="modal-body">
						<input type='hidden' id="did_failover_did" value="">
						<!--Global Failover-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="did_failover_num"><?php echo _("Failover Number") ?></label>
												<i class="fa fa-question-circle fpbx-help-icon" data-for="did_failover_num"></i>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="did_failover_num" name="did_failover_num" value="" placeholder="<?php echo $unavailintrial?>" <?php echo $disabled; ?>>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="did_failover-help" class="help-block fpbx-help-block"><?php echo _("")?></span>
								</div>
							</div>
						</div>
						<!--END Global Failover-->
						<!--Trunk Group-->
						<div class="element-container trunkgroup hidden">
							<div class="row">
								<div class="form-group">
									<div class="col-md-3">
										<label class="control-label" for="did_failover_trunkgroup"><?php echo _("Trunk Group") ?></label>
										<i class="fa fa-question-circle fpbx-help-icon" data-for="did_failover_trunkgroup"></i>
									</div>
									<div class="col-md-9">
										<?php echo FreePBX::Sipstation()->drawTrunkGroupFailover('did_failover_trunkgroup', '')?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="did_failover_trunkgroup-help" class="help-block fpbx-help-block"><?php echo _("Trunk Group for calls to fail over to.")?></span>
								</div>
							</div>
						</div>
						<!--END Trunk Group-->
						<!--Failover Destination-->
						<div class="element-container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="form-group">
											<div class="col-md-3">
												<label class="control-label" for="did_failover_dest"><?php echo _("Failover Destination") ?></label>
												<i class="fa fa-question-circle fpbx-help-icon" data-for="did_failover_dest"></i>
											</div>
											<div class="col-md-9">
												<input type="text" class="form-control" id="did_failover_dest" name="did_failover_dest" value="<?php echo $did_failover_dest ?>" placeholder="<?php echo $unavailintrial?>" <?php echo $disabled; ?>>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span id="did_failover-help" class="help-block fpbx-help-block"><?php echo _("")?></span>
								</div>
							</div>
						</div>
						<!--END Failover Destination-->
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _("Close")?></button>
		        <button type="button" class="btn btn-primary" id = "didfailoversave"><?php echo _("Save changes")?></button>
		      </div>
		    </div>
		  </div>
		</div>
		<script>
		function bind_did_table() {
			<?php foreach($dids as $did) { ?>
				if($('select#goto<?php echo $did['did']?>').val() == 'Extensions') {
					$(document).on('change', 'select#Extensions<?php echo $did['did']?>', function() {
						var select = $(this).val();
						var match = select.match(/from-did-direct,(.*),/)
						getextinfo(match[1],'<?php echo $did['did']?>');
					});
				}
				$(document).on('change', 'select#goto<?php echo $did['did']?>', function() {
					var did = $(this).attr('data-id');
					if($(this).val() == 'Extensions') {
						$('#setcid-'+did).show()
						$('#selectecid-'+did).show();
						$(document).on('change', 'select#Extensions<?php echo $did['did']?>', function() {
							var select = $(this).val();
							var match = select.match(/from-did-direct,(.*),/)
							getextinfo(match[1],did);
						});
						var select = $('select#Extensions<?php echo $did['did']?>').val();
						var match = select.match(/from-did-direct,(.*),/)
						getextinfo(match[1],did);
					} else {
						$('#setcid-'+did).hide()
						$('#selectecid-'+did).hide();
						$(document).off('change', 'select#Extensions<?php echo $did['did']?>');
					}
				});
				$( "#dialog-<?php echo $did['did']?>" ).dialog({
					autoOpen: false,
					height: 620,
					width: 500,
					modal: true
				})
			<?php } ?>
		}
		function route_gateway_formatter1(v,r){
			if(r['gw1_checked'] == true){
				var yeschecked = 'checked';
				var nochecked = '';
			}else{
				var yeschecked = '';
				var nochecked = 'checked';
			}
			var html = '';
			html += '<span class="radioset">';
			html += '<input type="radio" data-gw="1" data-route="'+r['id']+'" name="route'+r['id']+'_1" id="routeyes'+r['id']+'_1" value="set" '+yeschecked+'>';
			html += '<label for="routeyes'+r['id']+'_1">'+ _("Yes")+'</label>';
			html += '<input type="radio" data-gw = "1" data-route="'+r['id']+'" name="route'+r['id']+'_1" id="routeno'+r['id']+'_1" value="unset" '+nochecked+'>';
			html += '<label for="routeno'+r['id']+'_1">'+ _("No")+'</label>';
			html += '</span>';
			return html;
		}
		function route_gateway_formatter2(v,r){
			if(r['gw2_checked'] == true){
				var yeschecked = 'checked';
				var nochecked = '';
			}else{
				var yeschecked = '';
				var nochecked = 'checked';
			}
			var html = '';
			html += '<span class="radioset">';
			html += '<input type="radio" data-gw="2" data-route="'+r['id']+'" name="route'+r['id']+'_2" id="routeyes'+r['id']+'_2" value="set" '+yeschecked+'>';
			html += '<label for="routeyes'+r['id']+'_2">'+ _("Yes")+'</label>';
			html += '<input type="radio" data-gw="2" data-route="'+r['id']+'" name="route'+r['id']+'_2" id="routeno'+r['id']+'_2" value="unset" '+nochecked+'>';
			html += '<label for="routeno'+r['id']+'_2">'+ _("No")+'</label>';
			html += '</span>';
			return html;
		}
		var destinations = <?php echo json_encode(FreePBX::Modules()->getDestinations())?>;
		$('#ssroutes').on('post-body.bs.table', function () {
			$('input[type=radio][name^=route]').change(function(e) {
				var gateway = $(this).data('gw');
				var route = $(this).data('route');
				var inc = $(this).val();
				var command = inc+"gw"+gateway;
				$.getJSON( "ajax.php", {module:'sipstation',action:command,route:route,command:'updateroute'}, function( data ) {
					fpbxToast(_('Route Updated, Apply Config'));
				});
			});
		});
		function failoverFormatter(v,r){
			if(Sipstation.account_type == "TRIAL"){
				return _("Not Availible on Trial accounts");
			}
			var failover = _("Not Set");
			if(v.num != null){
				failover = v.num;
			}else if(v.dest != null){
				failover = v.dest;
			}
			return '<a href="#"  class="failoverlink" data-failover="'+v+'" data-did="'+r.did+'"><i class="fa fa-edit"></i> '+failover+'</a>';
		}
		function destinationFormatter(v,r){
			return '<a href="#"  class="destlink" data-dest="'+v+'" data-did="'+r.did+'"><i class="fa fa-edit"></i> '+destinations[v].description+'</a>';
		}
		function e911Formatter(v,r){
			if(Sipstation.account_type == "TRIAL"){
				return _("Not Availible on Trial accounts");
			}
			return '<a href="#" class="e911link" data-did="'+r.did+'" data-name="'+v.name+'" data-street1="'+v.street1+'" data-street2="'+v.street2+'" data-city="'+v.city+'" data-state="'+v.state+'" data-zip="'+v.zip+'"><i class="fa fa-edit"> <?php echo _("Edit/Update")?></i></a>';
		}
		function cidFormatter(v,r){
			return '<a href="#" class="cidlink" data-did="'+r.did+'" data-cid="'+r.cid+'" data-ecid="'+r.ecid+'"><i class="fa fa-edit"> <?php echo _("Edit/Update")?></i></a>';
		}
		function descriptionFormatter(v,r){
			if(v == ""){
				v = "SIPStation DID "+r.did;
			}
			return v
		}
		//Resets Drawselects
		function resetDrawselects(){
			$(".destdropdown").each(function() {
				$(this).val($("this option:first").val())
				var v = $(this).val(),
						i = $(this).data("id");
				if(v !== "") {
					$(".destdropdown2").not("#" + v + i).addClass("hidden");
					$("#"+ v + i).removeClass("hidden");
				} else {
					$(".destdropdown2").addClass("hidden");
				}
			});
		}
		/*
		 * setDrawselect - Sets draw select location.
		 * @id = element id such as goto0
		 * @val = destination such as Announcements,s,1
		 */
		function setDrawselect(id,val){
			var item = destinations[val];
			console.log(item);
			if(typeof item === "undefined"){
				resetDrawselects();
				return;
			}
			var idx = $('#'+id).data('id');
			$('#'+id+' > option[value="'+item.name.replace(" ","_")+'"]').prop("selected","selected");
			$("#"+id).trigger("change");
			$('#'+item.category+idx+' > option[value="'+item.destination+'"]').prop("selected","selected");
			$('#'+item.category+idx).trigger("change");
		}
		$('#ssdids').on('post-body.bs.table', function () {
			$(".cidlink").on('click',function(e){
				e.preventDefault();
				$("#routeciddid").val($(this).data('did'));
				$("#routecid").val($(this).data('cid'));
				$("#routecid").val($(this).data('ecid'));
				$("#routecidmodal").modal('show');
			});
			$("#cidroutesave").on('click',function(){
				var did = $("#routeciddid").val();
				var cid = $("#routecid").val();
				var ecid = $("#routecid").val();
				updateCID(did,cid,ecid,function(data){
					$("#routecidmodal").modal('hide');
				});
			});
			$(".destlink").on('click',function(e){
				e.preventDefault();
				var dest = $(this).data('dest');
				var did = $(this).data('did');
				setDrawselect('goto0', dest);
				$('#routedestdid').val(did);
				$("#routedestmodal").modal('show');
			});
			$("#routedestsave").on('click',function(){
				var did = $('#routedestdid').val();
				var gotoc = $('#goto0').val();
				var gotoid = $('#goto0').data('id');
				var dest = $("#"+gotoc+gotoid).val();
				updateDest(did,dest,function(data){
					if(data.status == true){
						fpbxToast(data.message);
						resetDrawselects();
						$('#routedestdid').val('');
						$("#routedestmodal").modal('hide');
						$('#ssdids').bootstrapTable('refresh');
					}
				});
			});
			$(".failoverlink").on('click',function(e){
				e.preventDefault();
				var did = $(this).data('did');
				var failover = $(this).data('failover');
				$("#did_failover_did").val(did);
				$("#did_failover_num").val(failover.num);
				$("#did_failover_dest").val(failover.dest);
				$('#didfailover').modal('show');
			});
			$("#didfailoversave").on('click',function(){
				var did = $("#did_failover_did").val();
				var num = $("#did_failover_num").val();
				var dest = $("#did_failover_dest").val();
				if(did == _("Not Set")){
					did = '';
				}
				if(dest == _("Not Set")){
					did = '';
				}
				updateFailover(did,dest,num,function(data){
					if(data.status == true){
						$('#didfailover').modal('hide');
						fpbxToast(_("Failover Information Updated"));
						$("#did_failover_did").val('');
						$("#did_failover_num").val('');
						$("#did_failover_dest").val('');
						$('#ssdids').bootstrapTable('refresh');
					}
				});
			});
			$(".e911link").on('click', function(e){
				e.preventDefault();
				$('#routedid').html($(this).data('did'));
				$('#routehiddendid').val($(this).data('did'));
				$('#routename').val($(this).data('name'));
				$('#routeaddress1').val($(this).data('street1'));
				$('#routeaddress2').val($(this).data('street2'));
				$('#routecity').val($(this).data('city'));
				$('#routestate').val($(this).data('state'));
				$('#routezip').val($(this).data('zip'));
				$('#e911routemodal').modal('show');
			});
			$("#e911routemodal").on('hidden.bs.modal', function(e){
				$('#routedid').html('');
				$('#routehiddendid').val('');
				$('#routename').val('');
				$('#routeaddress1').val('');
				$('#routeaddress2').val('');
				$('#routecity').val('');
				$('#routestate').val('');
				$('#routezip').val('');
			});
			$("#e911routesave").on('click',function(){
				var did = $('#routehiddendid').val();
				var name = $('#routename').val();
				var address1 = $('#routeaddress1').val();
				var address2 = $('#routeaddress2').val();
				var city = $('#routecity').val();
				var state = $('#routestate').val();
				var zip = $('#routezip').val();
				updatee911(did,name,address1,address2,city,state,zip,false,function(data){
					$('#e911routemodal').modal('hide');
					$('#ssdids').bootstrapTable('refresh');
					fpbxToast(_("E911 UPDATED"))
				});
			});
		});
		</script>
