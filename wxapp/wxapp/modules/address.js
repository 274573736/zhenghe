Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.address = void 0;

var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, _createClass = function() {
    function i(t, e) {
        for (var n = 0; n < e.length; n++) {
            var i = e[n];
            i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), 
            Object.defineProperty(t, i.key, i);
        }
    }
    return function(t, e, n) {
        return e && i(t.prototype, e), n && i(t, n), t;
    };
}(), _qqmapWxJssdk = require("../utils/qqmap-wx-jssdk.js"), _amapWx = require("../utils/amap-wx.js");

function _classCallCheck(t, e) {
    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
}

var app = getApp(), address = function() {
    function t() {
        _classCallCheck(this, t);
    }
    return _createClass(t, [ {
        key: "getAddress",
        value: function() {
            var n = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : "政府", i = this, o = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "南宁", a = arguments[2];
            return o = o || "南宁", a ? new Promise(function(t, e) {
                i._getAddress(n, o, a, t, e);
            }) : app.hint("腾讯地图的key值未设置");
        }
    }, {
        key: "_getAddress",
        value: function(t, e, n, i, o) {
            new _qqmapWxJssdk.QQMapWX({
                key: n
            }).getSuggestion({
                keyword: t,
                region: e,
                region_fix: 1,
                policy: 1,
                success: function(t) {
                    t.data ? i(t.data) : o();
                },
                fail: function(t) {
                    o(t);
                }
            });
        }
    }, {
        key: "getLocation",
        value: function() {
            return new Promise(function(e, n) {
                wx.getLocation({
                    type: "gcj02",
                    success: function(t) {
                        t ? e(t) : n();
                    },
                    fail: function(t) {
                        n();
                    }
                });
            });
        }
    }, {
        key: "getCity",
        value: function(t, e, o, a) {
            return a ? new Promise(function(n, i) {
                new _qqmapWxJssdk.QQMapWX({
                    key: a
                }).reverseGeocoder({
                    location: {
                        latitude: t,
                        longitude: e
                    },
                    get_poi: 1,
                    success: function(t) {
                        if (t) if (0 == o) n(t.result.pois[0]); else if (1 == o) {
                            var e = t.result.pois[0].ad_info.city;
                            n(e);
                        } else 2 == o ? n(t.result.pois) : i(); else i();
                    },
                    fail: function(t) {
                        i(t);
                    }
                });
            }) : app.hint("腾讯地图的key值未设置");
        }
    }, {
        key: "getCurrentCity",
        value: function(i) {
            var o = this;
            this.getLocation().then(function(t) {
                var e = setInterval(function() {
                    app.globalData.syStem.tencent_key && (clearInterval(e), o.getCity(t.latitude, t.longitude, 0, app.globalData.syStem.tencent_key).then(function(t) {
                        if (t && t.ad_info && t.ad_info.district && t.ad_info.city) {
                            var e = t.ad_info.city, n = t.ad_info.district;
                            i.setData({
                                city: n,
                                district: n
                            }), wx.setStorageSync("city", e), wx.setStorageSync("local_city", e), wx.setStorageSync("district", n);
                        } else o.getCurrentCityMessage(i);
                    }, function(t) {}));
                }, 10);
            }, function(t) {
                o.getAddressAuth();
            });
        }
    }, {
        key: "getCurrentCityMessage",
        value: function() {
            var i = this;
            return new Promise(function(e, n) {
                i.getLocation().then(function(t) {
                    i.getCity(t.latitude, t.longitude, 2, app.globalData.syStem.tencent_key).then(function(t) {
                        e(t);
                    }, function(t) {
                        n(t);
                    });
                }, function(t) {
                    i.getAddressAuth(), n(t);
                });
            });
        }
    }, {
        key: "getAddressAuth",
        value: function() {
            var e = this;
            wx.getSetting({
                success: function(t) {
                    t.authSetting["scope.userLocation"] || e.setLocationAuth();
                },
                fail: function(t) {}
            });
        }
    }, {
        key: "setLocationAuth",
        value: function() {
            wx.showModal({
                title: "地址授权请求",
                content: "我们需要获取您当前所在的位置",
                success: function(t) {
                    t.confirm && wx.openSetting({
                        success: function(t) {}
                    });
                }
            });
        }
    }, {
        key: "confirm",
        value: function(t, e) {
            var n = wx.getStorageSync("history_list");
            if (n || (n = []), 0 < n.length) {
                for (var i = 0; i < n.length; i++) n[i].id == t.id && n.splice(i, 1);
                5 <= n.length && n.pop();
            }
            var o = t.city;
            console.log(void 0 === o ? "undefined" : _typeof(o)), "object" == (void 0 === o ? "undefined" : _typeof(o)) && (o = o.city);
            var a = {};
            a.city = o, t.ad_info = a, 0 == e ? wx.setStorageSync("fahuo_temporary", t) : wx.setStorageSync("shouhuo_temporary", t), 
            n.unshift(t), wx.setStorageSync("history_list", n);
        }
    }, {
        key: "getDistance",
        value: function() {
            var n = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, i = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", o = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : {}, a = this, s = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : {}, c = 4 < arguments.length && void 0 !== arguments[4] ? arguments[4] : 0;
            return i ? new Promise(function(t, e) {
                a._getDistance(t, e, n, i, o, s, c);
            }) : app.hint("高德地图的key值未设置");
        }
    }, {
        key: "_getDistance",
        value: function(e, n, i, t, o, a, s) {
            var c = this, r = new _amapWx.AMapWX({
                key: t
            });
            1 == s ? r.getDrivingRoute({
                origin: o.location.lng + "," + o.location.lat,
                destination: a.location.lng + "," + a.location.lat,
                strategy: 4,
                success: function(t) {
                    c.aMapData(e, n, i, t);
                },
                fail: function(t) {
                    n(t);
                }
            }) : r.getRidingRoute({
                origin: o.location.lng + "," + o.location.lat,
                destination: a.location.lng + "," + a.location.lat,
                success: function(t) {
                    c.aMapData(e, n, i, t);
                },
                fail: function(t) {
                    console.log(t), n(t);
                }
            });
        }
    }, {
        key: "aMapData",
        value: function(t, e, n, i) {
            if (i && 1 == n || 0 == n) {
                var o = [];
                if (i.paths && i.paths[0] && i.paths[0].steps) for (var a = i.paths[0].steps, s = 0; s < a.length; s++) for (var c = a[s].polyline.split(";"), r = 0; r < c.length; r++) o.push({
                    longitude: parseFloat(c[r].split(",")[0]),
                    latitude: parseFloat(c[r].split(",")[1])
                });
                var u = (i.paths[0].distance / 1e3).toFixed(1), l = Math.ceil(i.paths[0].duration / 60), f = {};
                f.distance = u, f.duration = l, f.points = o, t(f);
            } else if (i && 2 == n) {
                t((i.paths[0].distance / 1e3).toFixed(1));
            } else if (i && 3 == n) {
                t({
                    distance: (i.paths[0].distance / 1e3).toFixed(1),
                    duration: Math.ceil(i.paths[0].duration / 60)
                });
            } else e(i);
        }
    } ]), t;
}();

exports.address = address;