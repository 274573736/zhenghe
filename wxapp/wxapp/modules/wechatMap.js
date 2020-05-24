Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function o(e, t) {
        for (var n = 0; n < t.length; n++) {
            var o = t[n];
            o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), 
            Object.defineProperty(e, o.key, o);
        }
    }
    return function(e, t, n) {
        return t && o(e.prototype, t), n && o(e, n), e;
    };
}();

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var app = getApp(), wechatMap = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, [ {
        key: "openLocationMap",
        value: function() {
            var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, n = this, o = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0, a = 2 < arguments.length && void 0 !== arguments[2] && arguments[2];
            wx.getSetting({
                success: function(e) {
                    e && e.authSetting["scope.userLocation"] ? wx.getLocation({
                        type: "gcj02",
                        success: function(e) {
                            e && n.openMap(e.latitude, e.longitude, t, o, a);
                        },
                        fail: function(e) {}
                    }) : n._setLocationAuth();
                },
                fail: function(e) {}
            });
        }
    }, {
        key: "openMap",
        value: function() {
            0 < arguments.length && void 0 !== arguments[0] && arguments[0], 1 < arguments.length && void 0 !== arguments[1] && arguments[1];
            var o = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0, a = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : 0, c = 4 < arguments.length && void 0 !== arguments[4] && arguments[4];
            wx.chooseLocation({
                scale: 18,
                success: function(e) {
                    if (e && e.name) {
                        var t = {
                            location: {
                                lat: e.latitude,
                                lng: e.longitude
                            },
                            id: -1,
                            title: e.name,
                            person_name: "",
                            person_tel: "",
                            address: e.address,
                            person_address: ""
                        };
                        if (3 == o && 1 == a) {
                            wx.setStorageSync("shouhuo", t);
                            var n = wx.getStorageSync("fahuo");
                            n.person_tel && c && (app.delRepeat(n, 0, 0), wx.navigateTo({
                                url: "/make_speed/skin/replace_driver/replace_driver"
                            }));
                        } else 1 != o || 0 != a || c ? 2 == o && 1 == a ? wx.setStorageSync("shouhuo_temporary", t) : 5 == o && 0 == a && wx.setStorageSync("fahuo_temporary", t) : wx.setStorageSync("fahuo", t);
                    }
                },
                fail: function(e) {
                    console.log("你是谁？");
                }
            });
        }
    }, {
        key: "_setLocationAuth",
        value: function() {
            wx.showModal({
                title: "位置授权",
                content: "我们需要获取您当前所在的位置",
                confirmText: "去授权",
                success: function(e) {
                    e.confirm && wx.openSetting({
                        success: function(e) {}
                    });
                }
            });
        }
    } ]), e;
}();

exports.wechatMap = wechatMap;