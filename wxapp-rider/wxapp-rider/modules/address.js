Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.address = void 0;

var _createClass = function() {
    function s(e, t) {
        for (var n = 0; n < t.length; n++) {
            var s = t[n];
            s.enumerable = s.enumerable || !1, s.configurable = !0, "value" in s && (s.writable = !0), 
            Object.defineProperty(e, s.key, s);
        }
    }
    return function(e, t, n) {
        return t && s(e.prototype, t), n && s(e, n), e;
    };
}(), _qqmapWxJssdk = require("../utils/qqmap-wx-jssdk.js");

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var address = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, [ {
        key: "getLocation",
        value: function() {
            return new Promise(function(t, n) {
                wx.getLocation({
                    type: "gcj02",
                    success: function(e) {
                        e ? t(e) : n();
                    },
                    fail: function(e) {
                        n();
                    }
                });
            });
        }
    }, {
        key: "getCity",
        value: function(e, t, r, o) {
            return new Promise(function(n, s) {
                new _qqmapWxJssdk.QQMapWX({
                    key: o
                }).reverseGeocoder({
                    location: {
                        latitude: e,
                        longitude: t
                    },
                    get_poi: 1,
                    success: function(e) {
                        if (e) if (1 == r) {
                            var t = e.result.pois[0].ad_info.city;
                            n(t.substr(0, t.length - 1));
                        } else 0 == r ? n(e.result.pois[0]) : s(); else s();
                    },
                    fail: function(e) {
                        s(e);
                    }
                });
            });
        }
    } ]), e;
}();

exports.address = address;