var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        address: "",
        name: "",
        tel: "",
        valid: 0,
        month_money: 0,
        lat: "",
        lng: "",
        id: 0,
        count_order: 0,
        form_id: 0
    },
    onLoad: function(e) {
        var t = e.id || 0;
        this.setData({
            id: t
        });
        var a = wx.createAnimation({
            duration: 400,
            timingFunction: "linear",
            delay: 0,
            transformOrigin: "50% 50% 0"
        });
        this._animation = a;
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.getInfo(this.data.id);
    },
    onHide: function() {},
    myMoney: function() {
        wx.navigateTo({
            url: "/make_speed/my_money/my_money?is_business=1"
        });
    },
    recharge: function() {
        wx.navigateTo({
            url: "/make_speed/recharge/recharge?is_business=1&money=" + this.data.valid
        });
    },
    staff: function() {
        wx.navigateTo({
            url: "/make_speed/big_customer/staff/staff"
        });
    },
    order: function() {
        wx.navigateTo({
            url: "/make_speed/order_list/order_list?is_business=1"
        });
    },
    orderBtn: function(e) {
        var n = this;
        if ("function" != typeof wx.requestSubscribeMessage) {
            var t = {};
            t.lat = this.data.lat, t.lng = this.data.lng;
            var a = {
                location: t
            };
            wx.setStorageSync("business", a), wx.navigateTo({
                url: "/make_speed/big_customer/a_key_order/a_key_order"
            });
        } else {
            var o = app.globalData.syStem;
            wx.requestSubscribeMessage({
                tmplIds: [ o.template_id, o.accepted_template_id, o.complete_template_id ],
                complete: function(e) {
                    var t = {};
                    t.lat = n.data.lat, t.lng = n.data.lng;
                    var a = {
                        location: t
                    };
                    wx.setStorageSync("business", a), wx.navigateTo({
                        url: "/make_speed/big_customer/a_key_order/a_key_order"
                    });
                }
            });
        }
    },
    formId: function(e) {
        var t = this, a = app.globalData.syStem;
        wx.requestSubscribeMessage({
            tmplIds: [ a.template_id, a.accepted_template_id, a.complete_template_id ],
            complete: function(e) {
                t._animation.translateY(-60).opacity(1).step(), t.setData({
                    animation: t._animation.export()
                }), setTimeout(function() {
                    t._animation.translateY(0).opacity(0).step({
                        duration: 0
                    });
                    var e = parseInt(t.data.form_id) + 1;
                    t.setData({
                        animation: t._animation.export(),
                        form_id: e
                    });
                }, 500);
            }
        });
    },
    getInfo: function(e) {
        var t = this;
        app.util.getUserInfo(function() {
            homeModule.businessStatus().then(function(e) {
                e[0] <= 0 ? wx.reLaunch({
                    url: "/make_speed/router/router"
                }) : (app.globalData.business_id = e[0], homeModule.businessInfo({
                    id: e[0]
                }).then(function(e) {
                    e.length <= 0 || t.setData({
                        address: e.address,
                        name: e.name,
                        tel: e.phone,
                        lat: e.lat,
                        lng: e.lng,
                        valid: e.valid,
                        month_money: e.month_money,
                        count_order: e.count_order
                    });
                }, function(e) {}));
            }, function(e) {});
        });
    },
    onUnload: function() {}
});