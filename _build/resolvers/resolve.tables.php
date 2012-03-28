<?php
if ($object->xpdo) {

    /* Model Classes names */
    $objects = array('swEntries');

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('swoosha.core_path', null, $modx->getOption('core_path') . 'components/swoosha/') . 'model/';
            $modx->addPackage('swoosha', $modelPath);

            $manager = $modx->getManager();

            foreach ($objects as $object) {
                $manager->createObjectContainer($object);
            }

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;
