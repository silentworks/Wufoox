<?php
/**
 * @var modAction $action
 * @var modMenu $menu
 */
$action = $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 1,
    'namespace' => 'extra_name',
    'parent' => 0,
    'controller' => 'index',
    'haslayout' => true,
    'lang_topics' => 'extra_name:default',
    'assets' => '',
), '', true, true);

$menu = $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'extra_name',
    'parent' => 'components',
    'description' => 'extra_name.desc',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
), '', true, true);
$menu->addOne($action);
unset($menus);

return $menu;
