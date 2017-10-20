<?php

if (isset($error)) {
    echo $error . '<br><br>';
}

?>

<h2> <?php echo _("Pair Sangoma MCU")?> </h2>
<form method="post" action="">
  <input type="hidden" name="action" value="save_pair">
  <!--MCU URL-->
  <div class="element-container">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="form-group">
            <div class="col-md-3">
              <label class="control-label" for="host"><?php echo _("MCU URL") ?></label>
              <i class="fa fa-question-circle fpbx-help-icon" data-for="host"></i>
            </div>
            <div class="col-md-9">
              <input type="text" class="form-control" id="host" name="host" value="<?php echo isset($host)?$host:''?>">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <span id="host-help" class="help-block fpbx-help-block"><?php echo _("URL to MCU Device")?></span>
      </div>
    </div>
  </div>
  <!--END MCU URL-->
  <!--Requires API token-->
  <div class="element-container">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="form-group">
            <div class="col-md-3">
              <label class="control-label" for="auth"><?php echo _("Requires API token") ?></label>
              <i class="fa fa-question-circle fpbx-help-icon" data-for="auth"></i>
            </div>
            <div class="col-md-9 radioset">
              <input type="radio" name="auth" id="authyes" value="true" <?php echo ($auth == "true"?"CHECKED":"") ?>>
              <label for="authyes"><?php echo _("Yes");?></label>
              <input type="radio" name="auth" id="authno" value="false"<?php echo ($auth == "true"?"":"CHECKED") ?>>
              <label for="authno"><?php echo _("No");?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <span id="auth-help" class="help-block fpbx-help-block"><?php echo _("Does this connection require the use of an API token?")?></span>
      </div>
    </div>
  </div>
  <!--END Requires API token-->
  <!--API Token-->
  <div class="element-container">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="form-group">
            <div class="col-md-3">
              <label class="control-label" for="token"><?php echo _("API Token") ?></label>
              <i class="fa fa-question-circle fpbx-help-icon" data-for="token"></i>
            </div>
            <div class="col-md-9">
              <input type="text" class="form-control token" id="token" name="token" value="<?php echo isset($token)?$token:''?>">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <span id="token-help" class="help-block fpbx-help-block"><?php echo _("Provide the API token that is configured in the Sangoma MCU Web Administration Interface")?></span>
      </div>
    </div>
  </div>
  <!--END API Token-->
  <input type="submit" name="submit" value="<?php echo _("Sumbit")?>">
</form>
