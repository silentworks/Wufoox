<?php
$plugins = array();

/* create the plugin object */
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id', 1);
$plugins[0]->set('name', 'wufooTv');
$plugins[0]->set('description', 'Loads in custom TV for wufoo integration');
$plugins[0]->set('plugincode', getSnippetContent($sources['elements'].'plugins/wufootv.plugin.php'));
$plugins[0]->set('category', 0);

$events = array();

$evs = array(
    'OnTVInputRenderList',
    'OnDocFormPrerender',
);

foreach ($evs as $ev) {
    $events[(string)$ev] = $modx->newObject('modPluginEvent');
    $events[(string)$ev]->fromArray(array(
        'event' => (string)$ev,
        'priority' => 0,
        'propertyset' => 0,
    ),'',true,true);
}

if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO, 'Packaged in '.count($events).' Plugin Events for plugin_name.');
    flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not find plugin events for plugin_name!');
}
unset($events);

return $plugins;
