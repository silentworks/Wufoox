<?php
/**
 * Handles plugin events for Gallery's Custom TV
 *
 * @package wufoox
 */
$corePath = $modx->getOption('wufoox.core_path', null, $modx->getOption('core_path') . 'components/wufoox/');
switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath.'elements/tv/input/');
        break;
    case 'OnTVInputPropertiesList':
        //$modx->event->output($corePath.'elements/tv/inputoptions/');
        break;
    case 'OnDocFormPrerender':
        $wufoox = $modx->getService('wufoox', 'Wufoox', $modx->getOption('wufoox.core_path', null, $modx->getOption('core_path') . 'components/wufoox/') . 'model/', $scriptProperties);
        if (!($wufoox instanceof Wufoox)) return '';

        /* assign wufoox lang to JS */
        $modx->response->addLangTopic('wufoox:tv');

        $modx->controller->addHtml('<link href="http://www.wufoo.com/stylesheets/integrations/embedkit/css/example.16588.css" rel="stylesheet">');
        $modx->controller->addHtml('<script src="http://wufoo.com/scripts/embed/iframe.js?targetElement=action-area"></script>');
        $modx->controller->addHtml('<script src="http://wufoo.com/scripts/iframe/formEmbedKit.js"></script>');

        $modx->controller->addJavascript($wufoox->config['assetsUrl'] . 'js/mgr/wufoox.js');
        $modx->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Wufoox.config = {};
            Wufoox.Framework = WufooFormEmbedKit({"userDefinedCallback":userDefinedCallback, "displayElement":"iframe-goes-here", "host":"wufoo.com"});
        });

        function userDefinedCallback(message) {
            Ext.get("popup").hide();

            var objMessage = JSON.parse(message),
                tvid = Wufoox.config.tvid,
                field = Ext.get(tvid);

            field.dom.value = objMessage.setup + objMessage.display;

            // Destroy Wufoo Form
            Wufoox.Framework.destroy();

            Ext.getCmp("modx-panel-resource").markDirty();
            Ext.getCmp(tvid + "-wufoox-button").setText(_("wufoox.btn.change"));
        }
        </script>');
        break;
}
return;
