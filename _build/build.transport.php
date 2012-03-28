<?php
/**
 * Build Transport script
 *
 * @package venuex
 * @subpackage build
 */
function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php', '?>'), '', $o));
    return $o;
}

$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);

/* define package names */
define('PKG_NAME', 'Wufoox');
define('PKG_NAME_LOWER', 'wufoox');
define('PKG_VERSION', '1.0.0');
define('PKG_RELEASE', 'beta1');

/* define build paths */
$root = dirname(dirname(__FILE__)) . '/';
$sources = array(
    'root' => $root,
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'resolvers' => $root . '_build/resolvers/',
    'chunks' => $root . 'core/components/' . PKG_NAME_LOWER . '/chunks/',
    'lexicon' => $root . 'core/components/' . PKG_NAME_LOWER . '/lexicon/',
    'docs' => $root . 'core/components/' . PKG_NAME_LOWER . '/docs/',
    'elements' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/',
    'snippets' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/snippets/',
    'chunks' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/',
    'plugins' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/',
    'source_assets' => $root . 'assets/components/' . PKG_NAME_LOWER,
    'source_core' => $root . 'core/components/' . PKG_NAME_LOWER,
);
unset($root);

/* override with your own defines here (see build.config.sample.php) */
require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
echo '<pre>'; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder', '', false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/' . PKG_NAME_LOWER . '/');

$category= $modx->newObject('modCategory');
$category->set('id', 1);
$category->set('category', PKG_NAME);

/* add chunks */
/*$modx->log(modX::LOG_LEVEL_INFO, 'Packaging in chunks...');
$chunks = include $sources['data'] . 'transport.chunks.php';
if (empty($chunks)) $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in chunks.');
$category->addMany($chunks);
unset($chunks);*/

/* add snippets */
/*$modx->log(modX::LOG_LEVEL_INFO, 'Packaging in snippets...');
$snippets = include $sources['data'] . 'transport.snippets.php';
if (empty($snippets)) $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in snippets.');
$category->addMany($snippets);
unset($snippets);*/

/* Settings */
/*$settings = include_once $sources['data'].'transport.settings.php';
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'key',
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => false,
);
if (!is_array($settings)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding settings failed.'); }
foreach ($settings as $setting) {
    $vehicle = $builder->createVehicle($setting, $attr);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO, 'Packaged in '.count($settings).' system settings.');
unset($settings, $setting, $attr);*/

/* add plugins */
$plugins = include $sources['data'].'transport.plugins.php';
if (!is_array($plugins)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding plugins failed.'); }
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'PluginEvents' => array(
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::UNIQUE_KEY => array('pluginid', 'event'),
        ),
    ),
);
foreach ($plugins as $plugin) {
    $vehicle = $builder->createVehicle($plugin, $attr);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($plugins).' plugins.');
unset($plugins, $plugin, $attr);

/* create category vehicle */
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Chunks' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
    ),
);
$vehicle = $builder->createVehicle($category, $attr);

$modx->log(modX::LOG_LEVEL_INFO, 'Adding file resolvers to category...');
$vehicle->resolve('file', array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));

$vehicle->resolve('file', array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));

$builder->putVehicle($vehicle);

/*$modx->log(modX::LOG_LEVEL_INFO, 'Packaging in menu...');
$menu = include $sources['data'] . 'transport.menu.php';
if (empty($menu)) $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in menu.');
$vehicle= $builder->createVehicle($menu, array (
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'text',
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Action' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array ('namespace', 'controller'),
        ),
    ),
));
$modx->log(modX::LOG_LEVEL_INFO, 'Adding in PHP resolvers...');
$vehicle->resolve('php',array(
    'source' => $sources['resolvers'] . 'resolve.tables.php',
));

$builder->putVehicle($vehicle);
unset($vehicle, $menu);*/

/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
    /*'setup-options' => array(
        'source' => $sources['build'].'setup.options.php',
    ),*/
));

$modx->log(modX::LOG_LEVEL_INFO,'Added package attributes and setup options.');

/* zip up package */
$modx->log(modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->pack();

$tend= explode(" ", microtime());
$tend= $tend[1] + $tend[0];
$totalTime= sprintf("%2.4f s", ($tend - $tstart));
$modx->log(modX::LOG_LEVEL_INFO, "\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");
exit ();
