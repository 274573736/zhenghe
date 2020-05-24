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
            type: Object,
            observer: function(t, e, a) {}
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
        freight_rider_icon: "",
        freight_rider_icon_url: ""
    },
    lifetimes: {
        attached: function() {
            this.mapCtx = wx.createMapContext("map", this);
        },
        detached: function() {}
    },
    pageLifetimes: {
        show: function() {
            if (1 == app.globalData.search_address) {
                var t = "";
                return t = 0 == wx.getStorageSync("address_type") ? wx.getStorageSync("fahuo_temporary") : wx.getStorageSync("shouhuo_temporary"), 
                this.setData({
                    search_page: 1,
                    latitude: t.location.lat,
                    longitude: t.location.lng
                }), void (app.globalData.search_address = 0);
            }
            var e = "";
            e = 0 == wx.getStorageSync("address_type") ? wx.getStorageSync("fahuo") || wx.getStorageSync("fahuo_temporary") : wx.getStorageSync("shouhuo") || wx.getStorageSync("shouhuo_temporary");
            var a = this.data.latitude, o = this.data.longitude;
            e && e.location && e.location.lat && e.location.lng ? e.location.lat == a && e.location.lng == o || this.setData({
                latitude: e.location.lat,
                longitude: e.location.lng
            }) : e && e.location && e.location.lat || this.location();
        }
    },
    methods: {
        location: function() {
            var e = this;
            addressModule.getLocation().then(function(t) {
                e.setData({
                    latitude: t.latitude,
                    longitude: t.longitude
                }), wx.setStorageSync("isLocation", 1), e.getAddressDetail(t.latitude, t.longitude, 1);
            }, function(t) {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"] || e.setLocationAuth();
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
            var e = this;
            this.mapCtx.getCenterLocation({
                success: function(t) {
                    !t.latitude || !t.longitude || t.latitude < 1 || t.longitude < 1 ? e.setLocationAuth() : e.getAddressDetail(t.latitude, t.longitude, 0);
                },
                fail: function(t) {}
            });
        },
        getAddressDetail: function(i, n) {
            var r = this;
            2 < arguments.length && void 0 !== arguments[2] && arguments[2];
            addressModule.getCity(i, n, 0, app.globalData.syStem.tencent_key).then(function(t) {
                var e = r.data.address_type, a = wx.getStorageSync("fahuo"), o = wx.getStorageSync("shouhuo");
                t.ad_info && !t.ad_info.city || 0 == e && a.id == t.id || 1 == e && o.id == t.id || (0 == e ? (wx.setStorageSync("fahuo_temporary", t), 
                5 == r.data.order_type && r.ridersPositions(i, n)) : wx.setStorageSync("shouhuo_temporary", t), 
                r.triggerEvent("examineAddress", {
                    address_type: e,
                    is_change: 1
                }, {}));
            });
        },
        ridersPositions: function(t, e) {
            var o = this;
            homeModule.getFreightRiders({
                lat: t,
                lng: e
            }).then(function(e) {
                var t = o.data.freight_rider_icon, a = o.data.freight_rider_icon_url;
                t || a || a == e.iconPath ? o.riderMarker(e, t) : e.iconPath && homeModule.developFile(e.iconPath).then(function(t) {
                    o.setData({
                        freight_rider_icon: t,
                        freight_rider_icon_url: e.iconPath
                    }), o.riderMarker(e, t);
                }, function(t) {});
            });
        },
        riderMarker: function(t, e) {
            for (var a = {}, o = [], i = 0; i < t.drivers.length; i++) a = {
                id: i,
                latitude: t.drivers[i].lat,
                longitude: t.drivers[i].lng,
                iconPath: e,
                width: t.drivers[i].width,
                height: t.drivers[i].height
            }, o.push(a);
            this.setData({
                markers: o
            });
        },
        cityLocation: function(e) {
            var a = this;
            addressModule.getAddress("政府", e, app.globalData.syStem.tmap).then(function(t) {
                a.setData({
                    city: e,
                    longitude: t[0].location.lng,
                    latitude: t[0].location.lat
                });
                wx.setStorageSync("fahuo", t[0]), a.triggerEvent("getAddress", {
                    city: e,
                    tap_city: 1
                }, {});
            });
        }
    }
});