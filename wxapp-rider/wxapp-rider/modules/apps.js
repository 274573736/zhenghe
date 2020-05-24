Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.apps = void 0;

var _createClass = function() {
    function n(e, t) {
        for (var r = 0; r < t.length; r++) {
            var n = t[r];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), 
            Object.defineProperty(e, n.key, n);
        }
    }
    return function(e, t, r) {
        return t && n(e.prototype, t), r && n(e, r), e;
    };
}(), _app2 = require("../utils/app.js");

function _classCallCheck(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

function _possibleConstructorReturn(e, t) {
    if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    return !t || "object" != typeof t && "function" != typeof t ? e : t;
}

function _inherits(e, t) {
    if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
    e.prototype = Object.create(t && t.prototype, {
        constructor: {
            value: e,
            enumerable: !1,
            writable: !0,
            configurable: !0
        }
    }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t);
}

var apps = function(e) {
    function t() {
        return _classCallCheck(this, t), _possibleConstructorReturn(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments));
    }
    return _inherits(t, _app2.app), _createClass(t, [ {
        key: "_getRiderStatus",
        value: function(e) {
            return this.app_request({
                that: e,
                url: "getRiderStatus",
                data: {},
                cachetime: 0
            });
        }
    }, {
        key: "getRiderStatus",
        value: function(t) {
            this._getRiderStatus(t).then(function(e) {
                if (0 == e.status) {
                    if ("auth" == t.getCurrentPagePath()) return;
                    wx.redirectTo({
                        url: "../auth/auth"
                    });
                } else if (1 == e.status) wx.redirectTo({
                    url: "../register/register"
                }); else if (2 == e.status) wx.redirectTo({
                    url: "../train/train"
                }); else if (3 == e.status) wx.redirectTo({
                    url: "../appointment_success/appointment_success"
                }); else if (5 == e.status) wx.redirectTo({
                    url: "../appointment_success/appointment_success?message=" + e.message
                }); else if (4 == e.status) {
                    if (console.log(e), wx.getStorageSync("phone")) {
                        if ("index" == t.getCurrentPagePath()) return;
                        return void wx.redirectTo({
                            url: "../index/index"
                        });
                    }
                    if ("auth" == t.getCurrentPagePath()) return;
                    wx.redirectTo({
                        url: "../auth/auth"
                    });
                }
            });
        }
    }, {
        key: "getNewOrder",
        value: function(e, t) {
            return this.app_request({
                that: e,
                url: "acceptOrderDetail",
                data: t,
                cachetime: 0
            });
        }
    }, {
        key: "carSocket",
        value: function(e) {
            return this.app_request({
                that: e,
                url: "test",
                cachetime: 0
            });
        }
    }, {
        key: "getSystem",
        value: function(e) {
            return this.app_request({
                that: e,
                url: "getSetting",
                cachetime: 0
            });
        }
    }, {
        key: "saveFormid",
        value: function(e, t) {
            return this.app_request({
                that: e,
                url: "setFormid",
                data: t
            });
        }
    }, {
        key: "postRiderPosition",
        value: function(e, t) {
            return this.app_request({
                that: e,
                url: "setRiderLocation",
                data: t
            });
        }
    }, {
        key: "getLatLng",
        value: function() {
            return new Promise(function(t, r) {
                wx.getLocation({
                    type: "gcj02",
                    success: function(e) {
                        e ? t(e) : r();
                    },
                    fail: function(e) {
                        r();
                    }
                });
            });
        }
    }, {
        key: "developFile",
        value: function(r) {
            var n = this;
            return new Promise(function(e, t) {
                n._developFile(r, e, t);
            });
        }
    }, {
        key: "_developFile",
        value: function(e, t, r) {
            wx.downloadFile({
                url: e,
                success: function(e) {
                    t(e.tempFilePath);
                },
                fail: function(e) {
                    r(e);
                }
            });
        }
    } ]), t;
}();

exports.apps = apps;