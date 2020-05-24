var _home = require("../../modules/home.js"), app = getApp(), homeModule = new _home.home();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
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
    onShow: function() {
        app.listenWss(this);
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