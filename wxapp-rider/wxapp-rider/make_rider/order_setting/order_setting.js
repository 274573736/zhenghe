var _home = require("../../modules/home.js"), homeModule = new _home.home(), app = getApp(), socket = null;

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        real_time: 0,
        appointment_time: 0,
        car_type: [ "小车", "轿车", "小黄车" ],
        hidden: !0,
        car: "",
        img_url: app.globalData.imgUrl,
        is_socket: !1,
        is_address: !1,
        is_address_close: !1
    },
    onLoad: function(t) {
        var a = this;
        app.setNavigation(), this.postData(), (socket = app.getWebSocket()) && this.setData({
            is_socket: socket._isLogin
        }), app.globalData.socket_location_switch && app.globalData.socket_location && wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userLocationBackground"] && a.setData({
                    is_address: !0
                });
            }
        });
    },
    bindSocket: function(t) {
        var a = this;
        if (socket._isLogin) return this.setData({
            is_socket: !0
        }), app.hint("实时接单通知正常，无需开启~");
        socket._isLogin || app.connectWs("type=bind_rider&rider_id=" + app.globalData.rider_id).then(function() {
            return a.setData({
                is_socket: !0
            }), app.hint("开启成功~");
        }, function(t) {
            return a.setData({
                is_socket: !1
            }), app.hint("开启失败~");
        });
    },
    bindAddress: function(t) {
        var a = this;
        return wx.canIUse("startLocationUpdateBackground") ? socket._isLogin ? void (t.detail.value ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userLocationBackground"] ? (a.setData({
                    is_address: !0
                }), app.globalData.socket_location_switch = !0, app.getBackgroundLocation()) : (a.setData({
                    is_address: !1
                }), app.socketLocationAuth());
            }
        }) : wx.stopLocationUpdate({
            success: function(t) {
                app.globalData.socket_location_switch = !1, app.globalData.socket_location = !1, 
                console.log(t);
            },
            fail: function(t) {
                console.log(t), console.log("取消失败");
            }
        })) : (this.setData({
            is_address: !1
        }), app.hint("必须先开启实时订单通知")) : (this.setData({
            is_address: !1
        }), app.hint("微信低于7.0.6~"));
    },
    bindAddressClose: function() {},
    selectCar: function() {
        this.setData({
            hidden: !1
        });
    },
    hiddenCar: function(t) {
        if (0 <= t.detail.idx) {
            var a = this.data.car_type[t.detail.idx];
            this.setData({
                car: a
            });
        }
        this.setData({
            hidden: !0
        });
    },
    selectBtn: function(t) {
        var a = this.data.appointment_time, e = this.data.real_time;
        1 == t.currentTarget.dataset.id ? (console.log("预约"), a = a ? 0 : 1) : (console.log("实时"), 
        e = e ? 0 : 1), this.postData(e, a);
    },
    postData: function() {
        var a = this, t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : -1, e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : -1;
        homeModule.riderAcceptSetting({
            shishi: t,
            yuyue: e
        }).then(function(t) {
            a.setData({
                real_time: t.shishi,
                appointment_time: t.yuyue
            });
        }, function(t) {});
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});