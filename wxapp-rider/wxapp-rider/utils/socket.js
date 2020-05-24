Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function t(e, n) {
        for (var o = 0; o < n.length; o++) {
            var t = n[o];
            t.enumerable = t.enumerable || !1, t.configurable = !0, "value" in t && (t.writable = !0), 
            Object.defineProperty(e, t.key, t);
        }
    }
    return function(e, n, o) {
        return n && t(e.prototype, n), o && t(e, o), e;
    };
}();

function _classCallCheck(e, n) {
    if (!(e instanceof n)) throw new TypeError("Cannot call a class as a function");
}

var websocket = function() {
    function o(e) {
        e.heartCheck, e.isReconnection;
        var n = e.data;
        _classCallCheck(this, o), this._isLogin = !1, this._netWork = !0, this._isClosed = !1, 
        this._timeout = 5e4, this._timeoutObj = null, this._connectNum = 0, this._heartCheck = !0, 
        this._isReconnection = !0, this._onSocketOpened(n), this.open = 0;
    }
    return _createClass(o, [ {
        key: "_reset",
        value: function() {
            return clearTimeout(this._timeoutObj), this;
        }
    }, {
        key: "_start",
        value: function() {
            var n = this;
            this._timeoutObj = setInterval(function() {
                wx.sendSocketMessage({
                    data: JSON.stringify({
                        heart: "heart"
                    }),
                    success: function(e) {
                        console.log("发送心跳成功");
                    },
                    fail: function(e) {
                        console.log(e), n._reset();
                    }
                });
            }, this._timeout);
        }
    }, {
        key: "onSocketClosed",
        value: function(n) {
            var o = this;
            wx.onSocketClose(function(e) {
                console.log("当前websocket连接已关闭,错误信息为:" + JSON.stringify(e)), o._heartCheck && o._reset(), 
                o._isLogin = !1, o._isClosed || o._isReconnection && o._reConnect(n);
            });
        }
    }, {
        key: "onNetworkChange",
        value: function(n) {
            var o = this;
            wx.onNetworkStatusChange(function(e) {
                console.log("当前网络状态:" + e.isConnected), o._netWork || (o._isLogin = !1, o._isReconnection && o._reConnect(n));
            });
        }
    }, {
        key: "_onSocketOpened",
        value: function(n) {
            var o = this;
            console.log(n), wx.onSocketOpen(function(e) {
                console.log("websocket已打开"), o._isLogin = !0, o._heartCheck && o._reset()._start(), 
                wx.sendSocketMessage({
                    data: n,
                    success: function(e) {
                        o.open = 1;
                    },
                    fail: function(e) {}
                }), o._netWork = !0;
            });
        }
    }, {
        key: "onMessage",
        value: function(n) {
            wx.onSocketMessage(function(e) {
                "function" == typeof n ? n(e) : console.log("参数的类型必须为函数");
            });
        }
    }, {
        key: "initWebSocket",
        value: function(n) {
            console.log(n);
            var o = this;
            this._isLogin ? console.log("您已经登录了") : wx.getNetworkType({
                success: function(e) {
                    "none" != e.networkType ? wx.connectSocket({
                        url: n.url,
                        success: function(e) {
                            "function" == typeof n.success ? n.success(e) : console.log("参数的类型必须为函数");
                        },
                        fail: function(e) {
                            "function" == typeof n.fail ? n.fail(e) : console.log("参数的类型必须为函数");
                        }
                    }) : (console.log("网络已断开"), o._netWork = !1, wx.showModal({
                        title: "网络错误",
                        content: "请重新打开网络",
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && console.log("用户点击确定");
                        }
                    }));
                }
            });
        }
    }, {
        key: "sendMsg",
        value: function(n) {
            wx.sendSocketMessage({
                data: n.data,
                success: function(e) {
                    "function" == typeof n.success ? n.success(e) : console.log("参数的类型必须为函数");
                },
                fail: function(e) {
                    "function" == typeof n.fail ? n.fail(e) : console.log("参数的类型必须为函数");
                }
            });
        }
    }, {
        key: "_reConnect",
        value: function(e) {
            var n = this;
            this._connectNum < 20 ? setTimeout(function() {
                n.initWebSocket(e);
            }, 3e3) : this._connectNum < 50 ? setTimeout(function() {
                n.initWebSocket(e);
            }, 1e4) : setTimeout(function() {
                n.initWebSocket(e);
            }, 45e4), this._connectNum += 1;
        }
    }, {
        key: "closeWebSocket",
        value: function() {
            wx.closeSocket(), this._isLogin = !1;
        }
    } ]), o;
}();

exports.default = websocket;