<div id="tv{$tv->id}-btn"></div>
<input type="hidden" id="tv{$tv->id}" name="tv{$tv->id}" value="{$tv->get('value')|escape}" />

<div id="popup" style="z-index: 99999;">
    <div id="iframe-goes-here"></div>
    <img src="http://wufoo.com/images/iframe/demo/fancy_close.png" alt="Close">
</div>

{literal}
<script type="text/javascript">
// <![CDATA[
Ext.onReady(function() {
	var popup = Ext.get('popup');

    MODx.load({{/literal}
        xtype: 'button'
        ,id: 'tv{$tv->id}-wufoox-button'
        ,text: '{$wfb.normal}'
        ,renderTo: 'tv{$tv->id}-btn'
        ,handler: function (btn, e) {
        	popup.show();
			Wufoox.Framework.display();
		}
    {literal}});

    popup.on('click', function(){
    	popup.hide();
    	Wufoox.Framework.destroy();
    });{/literal}

    // Pass the tvid over
    Wufoox.config.tvid = "tv{$tv->id}";

    if (Ext.get('tv{$tv->id}').getValue() !== '') {
    	Ext.getCmp(Wufoox.config.tvid + "-wufoox-button").setText("{$wfb.change}");
    }
{literal}
});
// ]]>
</script>
{/literal}
