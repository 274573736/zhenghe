var _address = require("../../modules/address"), _home = require("../../modules/home"), homeModule = new _home.home(), addressModule = new _address.address(), app = getApp();

Component({
    properties: {},
    data: {
        city: ""
    },
    lifetimes: {
        attached: function() {
            app.goingOrder(homeModule);
        },
        detached: function() {}
    },
    pageLifetimes: {
        show: function() {
            this.examineCity();
        }
    },
    methods: {
        toInfo: function(t) {
            app.setFormId(t.detail.formId), app.getApplicationIsAuth().then(function(t) {
                1 == t && wx.navigateTo({
                    url: "/make_speed/info/info"
                });
            }, function(t) {});
        },
        toCity: function() {
            wx.navigateTo({
                url: "../city/city"
            });
        },
        toType: function() {
            if (!this.data.city) return app.hint("请先选择下单城市~");
            wx.navigateTo({
                url: "../business_type/business_type"
            });
        },
        examineCity: function() {
            if (!this.data.city) return addressModule.getCurrentCity(this);
            var t = wx.getStorageSync("district"), e = wx.getStorageSync("city");
            wx.getStorageSync("local_city") == e ? this.setData({
                city: t
            }) : this.setData({
                city: e
            });
        }
    }
});