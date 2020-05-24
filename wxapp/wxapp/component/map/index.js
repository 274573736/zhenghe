var _address = require("../../modules/address.js"), _home = require("../../modules/home"), homeModule = new _home.home(), addressModule = new _address.address(), app = getApp();

Component({
    properties: {
        address_type: {
            type: Number,
            value: 0
        },
        order_type: {
            type: Number,
            value: 0
        },
        location: {
            type: Object
        },
        type: {
            type: Number,
            value: 0,
            observer: function(t, e, i) {
                t != e && this.data.latitude && this.data.longitude && this.ridersPositions(this.data.latitude, this.data.longitude, t);
            }
        }
    },
    data: {
        latitude: "",
        longitude: "",
        isLocation: 0,
        city: "",
        markers: [],
        scale: 14,
        search_page: 0,
        pick_set_num: 0,
        rider_icon: "",
        rider_icon_url: "",
        info_icon: {}
    },
    lifetimes: {
        attached: function() {
            var e = this;
            this.mapCtx = wx.createMapContext("map", this), homeModule.mapIcon().then(function(t) {
                e.setData({
                    info_icon: t
                });
            }, function(t) {});
        },
        detached: function() {}
    },
    pageLifetimes: {
        show: function() {
            var e = this, i = wx.getStorageSync("city"), a = this.data.city;
            if (a && a != i) wx.showModal({
                title: "温馨提示",
                content: "当前所选的地址城市为" + a + "是否要切换为" + i,
                success: function(t) {
                    t.confirm ? e.cityLocation(i) : t.cancel && wx.setStorageSync("city", a);
                }
            }); else {
                var t = wx.getStorageSync("fahuo");
                if (t && t.location && t.location.lat && t.location.lng) {
                    var n = this.data.latitude, o = this.data.longitude;
                    t.location.lat == n && t.location.lng == o || this.setData({
                        latitude: t.location.lat,
                        longitude: t.location.lng
                    });
                } else t && t.location && t.location.lat || this.location();
            }
        }
    },
    methods: {
        telBtn: function() {
            wx.makePhoneCall({
                phoneNumber: app.globalData.syStem.kefu_phone
            });
        },
        tabCity: function() {
            wx.navigateTo({
                url: "/make_speed/city/city"
            });
        },
        InfoBtn: function(t) {
            var e = t.currentTarget.dataset.path;
            e && ("/make_speed/big_customer/info/info" != e ? wx.navigateTo({
                url: t.currentTarget.dataset.path
            }) : this.toBusiness());
        },
        toBusiness: function() {
            homeModule.businessStatus().then(function(t) {
                var e = t[0];
                0 == e ? wx.showModal({
                    title: "提示",
                    content: "大客户审核暂未通过，是否要前往修改提交信息~",
                    success: function(t) {
                        t.confirm ? wx.navigateTo({
                            url: "/make_speed/big_customer/join/join?type=1"
                        }) : t.cancel && console.log("用户点击取消");
                    }
                }) : -1 == e ? wx.navigateTo({
                    url: "/make_speed/big_customer/join/join?type=0"
                }) : 0 < e && (app.globalData.business_id = e, wx.navigateTo({
                    url: "/make_speed/big_customer/info/info?id=" + e
                }));
            }, function(t) {});
        },
        location: function() {
            var e = this;
            addressModule.getLocation().then(function(t) {
                e.setData({
                    latitude: t.latitude,
                    longitude: t.longitude,
                    scale: 14
                }), wx.setStorageSync("isLocation", 1), e.getAddressDetail(t.latitude, t.longitude, 1);
            }, function(t) {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"];
                    }
                });
            });
        },
        setLocationAuth: function() {
            wx.showModal({
                title: "地址授权请求",
                content: "我们需要获取您当前所在的位置",
                success: function(t) {
                    t.confirm ? wx.openSetting({
                        success: function(t) {}
                    }) : t.cancel;
                }
            });
        },
        regionchange: function(t) {
            "update" != t.causedBy && "end" == t.type && (0 == this.data.search_page ? this.getLongitude() : this.setData({
                search_page: 0
            }));
        },
        getLongitude: function() {
            var i = this;
            this.mapCtx.getCenterLocation({
                success: function(t) {
                    if (!t.latitude || !t.longitude || t.latitude < 1 || t.longitude < 1) {
                        if (i.data.pick_set_num < 3) {
                            var e = ++i.data.pick_set_num;
                            return void i.setData({
                                pick_set_num: e
                            });
                        }
                        i.setLocationAuth();
                    } else i.getAddressDetail(t.latitude, t.longitude, 0);
                },
                fail: function(t) {}
            });
        },
        getAddressDetail: function(a, n) {
            var o = this, s = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0;
            addressModule.getCity(a, n, 0, app.globalData.syStem.tencent_key).then(function(t) {
                var e = wx.getStorageSync("fahuo"), i = t.ad_info.city;
                t.ad_info && !t.ad_info.city || e.id != t.id && (o.ridersPositions(a, n, o.data.type), 
                o.setData({
                    city: i
                }), 1 == s && i && wx.setStorageSync("city", i), wx.setStorageSync("fahuo_temporary", t), 
                o.triggerEvent("examineAddress", {
                    fahuo: t
                }, {}));
            });
        },
        cityLocation: function(e) {
            var i = this;
            addressModule.getAddress("政府", e, app.globalData.syStem.tencent_key).then(function(t) {
                i.setData({
                    city: e,
                    longitude: t[0].location.lng,
                    latitude: t[0].location.lat
                }), wx.setStorageSync("fahuo_temporary", t[0]), i.triggerEvent("examineAddress", {
                    fahuo: t[0]
                }, {});
            });
        },
        ridersPositions: function(t, e) {
            var a = this, i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0;
            i = 3 == i ? 1 : 0, homeModule.getRiders({
                latitude: t,
                longitude: e,
                type: i
            }).then(function(e) {
                var t = a.data.rider_icon, i = a.data.rider_icon_url;
                t && i && i == e.icon ? a.riderMarker(e, t) : e.icon && homeModule.developFile(e.icon).then(function(t) {
                    a.setData({
                        rider_icon: t,
                        rider_icon_url: e.icon
                    }), a.riderMarker(e, t);
                }, function(t) {});
            });
        },
        riderMarker: function(t, e) {
            for (var i = {}, a = [], n = 0; n < t.rider.length; n++) i = {
                id: n,
                latitude: t.rider[n].lat,
                longitude: t.rider[n].lng,
                iconPath: e,
                width: 25,
                height: 25
            }, a.push(i);
            this.setData({
                markers: a
            });
        }
    }
});