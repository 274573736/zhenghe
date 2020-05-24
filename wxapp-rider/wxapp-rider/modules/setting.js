Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function c(e, t) {
        for (var n = 0; n < t.length; n++) {
            var c = t[n];
            c.enumerable = c.enumerable || !1, c.configurable = !0, "value" in c && (c.writable = !0), 
            Object.defineProperty(e, c.key, c);
        }
    }
    return function(e, t, n) {
        return t && c(e.prototype, t), n && c(e, n), e;
    };
}();

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var setting = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, [ {
        key: "auth",
        value: function() {
            var c = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0;
            return new Promise(function(t, n) {
                wx.getSetting({
                    success: function(e) {
                        switch (c) {
                          case 0:
                            t(e.authSetting["scope.userInfo"]);
                            break;

                          case 1:
                            t(e.authSetting["scope.userLocation"]);
                            break;

                          case 2:
                            t(1);
                            break;

                          case 3:
                            t(e.authSetting["scope.record"]);
                            break;

                          case 4:
                            t(e.authSetting["scope.camera"]);
                            break;

                          default:
                            t(1);
                        }
                    },
                    fail: function(e) {
                        n(e);
                    }
                });
            });
        }
    }, {
        key: "getLocation",
        value: function() {
            var c = this;
            return new Promise(function(t, n) {
                wx.getSetting({
                    success: function(e) {
                        if (!e.authSetting["scope.userLocation"]) return c.setLocationAuth(), n();
                        wx.getLocation({
                            type: "gcj02",
                            success: function(e) {
                                t(e);
                            },
                            fail: function(e) {
                                n();
                            }
                        });
                    },
                    fail: function(e) {
                        n();
                    }
                });
            });
        }
    }, {
        key: "setLocationAuth",
        value: function() {
            wx.hideLoading(), wx.showModal({
                title: "定位当前位置",
                content: "位置信息项，需要选择允许",
                success: function(e) {
                    e.confirm && wx.openSetting({
                        success: function(e) {}
                    });
                }
            });
        }
    }, {
        key: "addressAuth",
        value: function() {
            return new Promise(function(t, e) {
                wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.userLocation"] && t(e.authSetting["scope.userLocation"]);
                    }
                });
            });
        }
    } ]), e;
}();

exports.setting = setting;