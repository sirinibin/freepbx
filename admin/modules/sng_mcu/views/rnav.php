<?php

$li[] = '<a class="list-group-item" href="config.php?display='. urlencode($display) . '&action=add">' . _("Pair MCU") . '</a>';


if (isset($sng_mcu_results)){
    foreach ($sng_mcu_results as $r) {
        $r['host'] = $r['host'] ? $r['host'] : 'MCU ID: ' . $r['id'];
        $li[] = '<a class="list-group-item" id="' . ( $id == $r['id'] ? 'current' : '')
            . '" href="config.php?display=' . urlencode($display) . '&amp;action=update&amp;id='
            . $r['id'] . '">'
            . $r['host'] .'</a>';
    }
}

echo implode(PHP_EOL, $li);
