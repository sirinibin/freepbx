<?php

if ((!$action && !$id) || $action == 'del') {
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h2><?php echo _("Welcome")?></h2>
  </div>
  <div class="panel-body">
    <img src="/admin/modules/sng_mcu/assets/images/mcu.jpg" height="275"/>
    <p><b> <?php echo _("This module is used to setup and manage the Sangoma MCU")?> </b></p>
    <p><b> <?php echo _("This module is not used if you do not own a Sangoma MCU")?> </b></p>
    <p> <?php echo sprintf(_("More information on the Sangoma MCU can be found %s"),'<a href="http://www.sangoma.com/products/vega-video-mcu/" target="_blank">'._("Here").'</a>')?> </p>
    <a class="btn btn-default" href="config.php?type=setup&display=sng_mcu&action=add">
        <?php echo _("Pair MCU")?>
    </a>
  </div>
</div>

<?php
}
?>
