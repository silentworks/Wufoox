<?php
$modx->lexicon->load('tv_widget', 'wufoox:tv');
$corePath = $modx->getOption('wufoox.core_path', null, $modx->getOption('core_path') . 'components/wufoox/');

$lang = $modx->lexicon->fetch('wufoox.btn.', true);
$modx->smarty->assign('wfb', $lang);

return $this->xpdo->smarty->fetch($corePath . 'elements/tv/wufooitem.input.tpl');
