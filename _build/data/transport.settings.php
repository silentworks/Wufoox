<?php
$s = array(
    'settings_name' => 'Settings value',
);

$settings = array();

foreach ($s as $key => $val) {
    if (is_string($val['value']) || is_int($val['value'])) { $type = 'textfield'; }
    elseif (is_bool($val['value'])) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }

    $settings['extra_name.'.$key] = $modx->newObject('modSystemSetting');
    $settings['extra_name.'.$key]->set('key', 'extra_name.'.$key);
    $settings['extra_name.'.$key]->fromArray(array(
        'value' => $val,
        'xtype' => $type,
        'namespace' => 'extra_name',
        'area' => 'Default'
    ));
}

return $settings;
