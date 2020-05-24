var _home = require("../../modules/home.js"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        city: []
    },
    onLoad: function() {
        var e = this;
        app.setNavigation(), homeModule.getCity("city").then(function(t) {
            e.setData({
                city: t
            });
        });
    },
    onShow: function() {},
    onReady: function() {
        app.setNavigation();
    },
    bindtap: function(t) {},
    input: function(t) {
        this.value = t.detail.value;
    },
    searchMt: function() {
        this.value || (this.value = ""), this.setData({
            value: this.value
        });
    }
});