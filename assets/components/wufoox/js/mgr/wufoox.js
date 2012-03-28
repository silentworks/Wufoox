var Wufoox = function(config) {
    config = config || {};
    Wufoox.superclass.constructor.call(this, config);
};

Ext.extend(Wufoox, Ext.Component, {
    page:{}, window:{}, button: {}, grid:{}, tree:{}, panel:{}, combo:{}, config:{}
});

Ext.reg('wufoox', Wufoox);
Wufoox = new Wufoox();
