var _address = require("../../modules/address"), _home = require("../../modules/home"), app = getApp(), homeModule = new _home.home(), addressModule = new _address.address();

Page({
    data: {
        hidden: !0,
        city: "",
        week: [ "一", "二", "三", "四", "五", "六", "天" ],
        days: [],
        select_idx: -1,
        select_date: "",
        time_idx: -1,
        time_val: "",
        train_name: "",
        train_id: 0,
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        img_url: app.globalData.imgUrl,
        change_city: !1
    },
    confirm: function() {
        var t = this.data.city, e = this.data.select_date, a = this.data.time_idx, i = this.data.train_name, n = this.data.train_id;
        if (!t) return app.hint("请选择您当前所在的城市");
        if (!i) return app.hint("请选择培训站点");
        if (!e) return app.hint("请选择预约的日期");
        if (a <= -1) return app.hint("请选择预约时间");
        var s = app.globalData.syStem;
        wx.requestSubscribeMessage({
            tmplIds: [ s.audit_rider_tpl ],
            success: function(t) {
                homeModule.postTrain({
                    select_date: e,
                    time_idx: a,
                    train_id: n
                }).then(function(t) {
                    wx.redirectTo({
                        url: "../appointment_success/appointment_success"
                    }), app.hint("预约成功~", "success");
                }, function(t) {});
            },
            fail: function(t) {}
        });
    },
    getCity: function() {
        if (!this.data.city) return app.hint("业务需求必须获取您的位置信息"), void this.location();
        wx.navigateTo({
            url: "../city/city"
        });
    },
    getTrain: function() {
        var t = this.data.city;
        t || app.hint("请先选择当前所在的城市"), wx.navigateTo({
            url: "../select_train_address/select_train_address?city=" + t
        });
    },
    selectDate: function(t) {
        var e = t.currentTarget.dataset.idx, a = t.currentTarget.dataset.date;
        t.currentTarget.dataset.status && this.setData({
            select_idx: e,
            select_date: a
        });
    },
    selectTime: function(t) {
        var e = t.currentTarget.dataset.idx, a = t.currentTarget.dataset.time;
        this.setData({
            time_idx: e,
            time_val: a
        });
    },
    getDate: function(t) {
        var e = this;
        homeModule.getTrainDate({
            id: t
        }).then(function(t) {
            e.setData({
                days: t
            });
        }, function(t) {});
    },
    onLoad: function(t) {
        t.change_city && this.setData({
            change_city: !0
        }), app.setNavigation(), this.location();
    },
    location: function() {
        var a = this;
        addressModule.getLocation().then(function(t) {
            var e = wx.getStorageSync("system");
            e && addressModule.getCity(t.latitude, t.longitude, 0, e.rider_tencent_key).then(function(t) {
                var e = t.ad_info.city;
                wx.setStorageSync("city", e), a.setData({
                    city: e
                });
            });
        }, function(t) {
            wx.getSetting({
                success: function(t) {
                    t.authSetting["scope.userLocation"] || a.setLocationAuth();
                }
            });
        });
    },
    setLocationAuth: function() {
        var e = this;
        wx.showModal({
            title: "地址授权请求",
            content: "获取您当前所在的城市名",
            success: function(t) {
                t.confirm ? wx.openSetting({
                    success: function(t) {}
                }) : t.cancel && e.setLocationAuth();
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("city");
        if (t) {
            var e = this.data.city;
            e && e != t && (wx.removeStorageSync("train"), this.setData({
                train_name: ""
            })), this.setData({
                city: t
            });
        }
        var a = wx.getStorageSync("train");
        a ? (this.setData({
            train_name: a.name,
            train_id: a.id
        }), this.getDate(a.id)) : (this.setData({
            train_name: "",
            train_id: 0
        }), this.getDate(0));
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