Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function n(e, a) {
        for (var t = 0; t < a.length; t++) {
            var n = a[t];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), 
            Object.defineProperty(e, n.key, n);
        }
    }
    return function(e, a, t) {
        return a && n(e.prototype, a), t && n(e, t), e;
    };
}();

function _classCallCheck(e, a) {
    if (!(e instanceof a)) throw new TypeError("Cannot call a class as a function");
}

var app = function() {
    function e() {
        _classCallCheck(this, e);
    }
    return _createClass(e, [ {
        key: "app_request",
        value: function(e) {
            var t = this, n = e.that, o = e.url, a = e.data, r = void 0 === a ? {} : a, i = e.cachetime, s = void 0 === i ? 0 : i, u = e.module, c = void 0 === u ? "make_rider" : u;
            return r.m = c, new Promise(function(e, a) {
                t._app_request(n, o, r, e, a, s);
            });
        }
    }, {
        key: "_app_request",
        value: function(e, a, t, n, o, r) {
            e.util.request({
                url: "entry/wxapp/" + a,
                data: t,
                cachetime: r,
                showLoading: !1,
                success: function(e) {
                    e.data.data ? n(e.data.data) : (e.data.message && (wx.hideLoading(), wx.showToast({
                        title: e.data.message,
                        icon: "none",
                        duration: 2e3
                    })), o(e.data.data));
                },
                fail: function(e) {
                    console.log("出错了"), console.log(e), o(e);
                }
            });
        }
    } ]), e;
}();

exports.app = app;