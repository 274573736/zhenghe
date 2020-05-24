var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        new_order_num: 0,
        count_time: 30,
        accept_order: !0,
        order_switch: 0,
        rote: !1,
        underwayOrder: [],
        img_url: app.globalData.imgUrl,
        order_total_num: 0,
        order_total_price: 0,
        is_onload: !1,
        waitcount: 0,
        is_cash: 1
    },
    onLoad: function(t) {
        var e = setInterval(function() {
            app.globalData.syStem && (clearInterval(e), wx.setNavigationBarTitle({
                title: app.globalData.syStem.rider_program_title
            }));
        }, 10);
        this.underwayOrder(), this.getRiderId();
        var r = t.id;
        r && this.riderTemplateOrder(r);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        var t = this;
        app.listenWss(this), this.riderIsAccept(), this.orderRefresh();
        var e = setInterval(function() {
            app.globalData.syStem && (clearInterval(e), t.setData({
                is_cash: app.globalData.syStem.is_can_accept
            }));
        }, 10);
    },
    cancelOrder: function(t) {
        var e = t.detail.idx, r = this.data.underwayOrder;
        return r.splice(e, 1), this.setData({
            underwayOrder: r
        }), app.hint("取消接单成功~");
    },
    riderTemplateOrder: function(t) {
        var e = this;
        homeModule.getOrderDetail({
            order_id: t
        }).then(function(t) {
            e.setData({
                new_order_status: !1,
                new_order: t
            }), app.playMusic(e, !1);
        }, function(t) {});
    },
    orderSwitch: function() {
        var t = this.data.order_switch;
        t = 1 == t ? 0 : 1, this.riderIsAccept(t);
    },
    riderIsAccept: function() {
        var e = this, t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : -1;
        homeModule.riderIsAccept({
            type: t
        }).then(function(t) {
            e.setData({
                order_switch: t.type,
                waitcount: t.waitcount
            }), app.globalData.order_switch = t.type, app.globalData.wait_count = t.waitcount, 
            t.rider_id && (e.data.is_onload || (app.globalData.rider_id = t.rider_id, app.connectWs("type=bind_rider&rider_id=" + t.rider_id), 
            app.listenWss(e)), e.setData({
                order_switch: t.type,
                order_total_num: t.count,
                order_total_price: t.price,
                is_onload: !0
            }));
        });
    },
    orderRefresh: function() {
        var t = this;
        this.setData({
            rote: !0
        }), setTimeout(function() {
            t.setData({
                rote: !1
            }), t.underwayOrder();
        }, 1e3);
    },
    robOrderSuccess: function() {
        this.underwayOrder(), this.riderIsAccept();
    },
    underwayOrder: function() {
        var e = this;
        homeModule.getRiderOrder({
            status: -1
        }).then(function(t) {
            e.setData({
                underwayOrder: t
            });
        }, function(t) {
            e.setData({
                underwayOrder: []
            });
        });
    },
    acceptBtn: function() {},
    cancelAccept: function() {},
    getRiderId: function() {
        homeModule.getRiderId().then(function(t) {
            app.globalData.rider_id = t.rider_id;
        }, function(t) {});
    },
    orderStatus: function(t) {
        wx.navigateTo({
            url: "../rob_order/rob_order"
        });
    },
    toInfo: function(t) {
        wx.navigateTo({
            url: "../info/info"
        });
    },
    toMsg: function(t) {
        app.globalData.syStem;
        wx.navigateTo({
            url: "../msg_notification/msg_notification"
        });
    },
    dataPanel: function(t) {
        var e = this.data.order_total_num, r = this.data.order_total_price;
        wx.navigateTo({
            url: "../order-data/order-data?order_total_num=" + e + "&order_total_price=" + r
        });
    },
    acceptMap: function(t) {
        wx.navigateTo({
            url: "../accept_map/accept_map"
        });
    },
    orderSetting: function(t) {
        wx.navigateTo({
            url: "../order_setting/order_setting"
        });
    },
    acceptOrder: function(t) {
        wx.navigateTo({
            url: "../accept_order/accept_order"
        });
    },
    myMoney: function() {
        wx.navigateTo({
            url: "../my_money/my_money"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        homeModule.getSystem().then(function(t) {
            e.riderIsAccept(), e.orderRefresh(), app.globalData.syStem = t, wx.setStorageSync("system", t), 
            wx.stopPullDownRefresh();
        }, function(t) {});
    },
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});