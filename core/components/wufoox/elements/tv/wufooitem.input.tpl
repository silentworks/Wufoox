<div id="tv{$tv->id}-btn"></div>
<input type="hidden" id="tv{$tv->id}" name="tv{$tv->id}" value="{$tv->get('value')|escape}" />
<div id="show-form{$tv->id}" class="form-rendered" style="border: 1px solid #ccc; display: none; height: 300px; overflow: auto; padding: 5px; margin-top: 20px;">{$tv->get('value')}</div>

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
    Wufoox.formDisplay = Ext.get("show-form{$tv->id}");
    Wufoox.formDisplay.setVisibilityMode(2);
    Wufoox.Btn = Ext.getCmp("tv{$tv->id}-wufoox-button");

    if (Ext.get('tv{$tv->id}').getValue() !== '') {
    	Wufoox.Btn.setText("{$wfb.change}");
        Wufoox.formDisplay.show();
    }

    Ext.get("modx-tv-reset-{$tv->id}").on('click', function () {
        Wufoox.Btn.setText("{$wfb.normal}");
        Wufoox.formDisplay.hide();
    })
{literal}
});
// ]]>
</script>
{/literal}
