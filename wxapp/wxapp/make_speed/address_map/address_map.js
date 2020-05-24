var _setting = require("../../modules/setting.js"), _address = require("../../modules/address"), addressModule = new _address.address(), settingModule = new _setting.setting(), app = getApp();

Page({
    data: {
        location_lat: "",
        location_lng: "",
        scale: 15,
        city: "",
        id: 0,
        address_list: []
    },
    onLoad: function(t) {
        this.mapCtx = wx.createMapContext("map");
        var e = t.id, a = wx.getStorageSync("city");
        this.setData({
            id: e,
            city: a
        }), this.onloadList(e, a);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    setLocationAuth: function() {
        wx.showModal({
            title: "地址授权请求",
            content: "我们需要获取您当前所在的位置",
            success: function(t) {
                t.confirm && wx.openSetting({
                    success: function(t) {}
                });
            }
        });
    },
    location: function() {
        var e = this;
        addressModule.getLocation().then(function(t) {
            e.setData({
                location_lat: t.latitude,
                location_lng: t.longitude
            }), e.coordinate(t.latitude, t.longitude);
        }, function(t) {
            wx.getSetting({
                success: function(t) {
                    t.authSetting["scope.userLocation"] || e.setLocationAuth();
                }
            });
        });
    },
    onloadList: function() {
        var e = this, t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, a = arguments[1], n = "", o = [];
        if (0 == t ? (n = wx.getStorageSync("fahuo_temporary"), o = wx.getStorageSync("fahuo_address_list") || []) : (n = wx.getStorageSync("shouhuo_temporary"), 
        o = wx.getStorageSync("shouhuo_address_list") || []), n && n.title && 0 < o.length) {
            for (var i = !1, s = 0; s < o.length; s++) if (o[s].id == n.id) {
                i = !0;
                var l = o[s];
                o.splice(s, 1), o.unshift(l);
                break;
            }
            i || ((o = [])[0] = n), this.setData({
                location_lat: n.location.lat,
                location_lng: n.location.lng,
                title: n.title,
                address_list: o
            });
        } else n && n.title && o.length <= 0 ? (o[0] = n, this.setData({
            location_lat: n.location.lat,
            location_lng: n.location.lng,
            title: n.title,
            address_list: o
        })) : settingModule.auth(1).then(function(t) {
            t ? addressModule.getCurrentCityMessage().then(function(t) {
                if (t[0].ad_info.city != a) return e.tabCity(a);
                e.setData({
                    location_lat: t[0].location.lat,
                    location_lng: t[0].location.lng,
                    title: t[0].title,
                    address_list: t
                });
            }, function(t) {
                e.tabCity(a);
            }) : e.tabCity(a);
        }, function(t) {});
    },
    searAddress: function() {
        wx.navigateTo({
            url: "../search_address/search_address?id=" + this.data.id
        });
    },
    selectAddress: function(t) {
        var e = t.currentTarget.dataset.id, a = this.data.id, n = this.data.address_list;
        addressModule.confirm(n[e], a), 0 == a ? wx.setStorageSync("fahuo_address_list", n) : wx.setStorageSync("shouhuo_address_list", n), 
        wx.navigateBack({
            delta: 1
        });
    },
    tabCity: function(t) {
        var e = this;
        addressModule.getAddress("政府", t, app.globalData.syStem.tencent_key).then(function(t) {
            e.setData({
                address_list: t,
                location_lat: t[0].location.lat,
                location_lng: t[0].location.lng,
                map_change: 0,
                title: t[0].title
            });
        }, function(t) {});
    },
    bindMap: function(t) {
        var e = this;
        "update" != t.causedBy && "end" == t.type && (console.log("地图发生改变"), this.mapCtx.getCenterLocation({
            success: function(t) {
                e.coordinate(t.latitude, t.longitude);
            },
            fail: function(t) {}
        }));
    },
    coordinate: function(t, e) {
        var a = this;
        addressModule.getCity(t, e, 2, app.globalData.syStem.tencent_key).then(function(t) {
            a.setData({
                address_list: t,
                title: t[0].title
            });
        }, function(t) {});
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return app.getShare(), {
            title: app.globalData.syStem.user_program_title,
            path: "/make_speed/router/router?recommend_id=" + app.globalData.user_id,
            imageUrl: app.globalData.syStem.user_share_img ? app.globalData.syStem.user_share_img : ""
        };
    }
});