Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.home = void 0;

var _createClass = function() {
    function u(e, t) {
        for (var r = 0; r < t.length; r++) {
            var u = t[r];
            u.enumerable = u.enumerable || !1, u.configurable = !0, "value" in u && (u.writable = !0), 
            Object.defineProperty(e, u.key, u);
        }
    }
    return function(e, t, r) {
        return t && u(e.prototype, t), r && u(e, r), e;
    };
}(), _http2 = require("../utils/http.js");

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

var home = function(e) {
    function t() {
        return _classCallCheck(this, t), _possibleConstructorReturn(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments));
    }
    return _inherits(t, _http2.http), _createClass(t, [ {
        key: "homemakingInfo",
        value: function() {
            return this.request({
                url: "technician_info"
            });
        }
    }, {
        key: "applyHomemaking",
        value: function(e) {
            return this.request({
                url: "apply_technician",
                data: e
            });
        }
    }, {
        key: "getHomemakingList",
        value: function() {
            return this.request({
                url: "get_category"
            });
        }
    }, {
        key: "freightDriver",
        value: function(e) {
            return this.request({
                url: "register_driver",
                data: e,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "freightDriverInfo",
        value: function(e) {
            return this.request({
                url: "driver_info",
                data: e,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "getCar",
        value: function(e) {
            return this.request({
                url: "getcar",
                data: e,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "businessType",
        value: function(e) {
            return this.request({
                url: "register_business",
                data: e
            });
        }
    }, {
        key: "confirmPay",
        value: function(e) {
            return this.confirmPayRequest({
                result: e
            });
        }
    }, {
        key: "postDriver",
        value: function(e) {
            return this.request({
                url: "addriderdriver",
                data: e
            });
        }
    }, {
        key: "getCode",
        value: function(e) {
            return this.request({
                url: "getCode",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "getNewOrderDetail",
        value: function(e, t) {
            return this.request({
                url: e,
                data: {
                    id: t
                }
            });
        }
    }, {
        key: "login",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "riderLogin",
                data: e
            });
        }
    }, {
        key: "updateRiderInfo",
        value: function(e) {
            return this.request({
                url: "updateRiderInfo",
                data: e
            });
        }
    }, {
        key: "getImgUrl",
        value: function() {
            return this.request({
                url: ""
            });
        }
    }, {
        key: "register",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "riderRegister",
                data: e
            });
        }
    }, {
        key: "riderAuth",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "riderAuth",
                data: e
            });
        }
    }, {
        key: "getCity",
        value: function(e) {
            return this.request({
                url: e
            });
        }
    }, {
        key: "getTrainDate",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "getTrainTime",
                data: e
            });
        }
    }, {
        key: "getTrain",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "getTrain",
                data: e
            });
        }
    }, {
        key: "postTrain",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "addTrain",
                data: e
            });
        }
    }, {
        key: "appointmentSuccess",
        value: function() {
            return this.request({
                url: "getTrainInfo"
            });
        }
    }, {
        key: "riderIsAccept",
        value: function(e) {
            return this.request({
                url: "riderIsAccept",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "getRiderStatus",
        value: function() {
            return this.request({
                url: "getRiderStatus",
                data: {},
                cachetime: 0
            });
        }
    }, {
        key: "postRiderPosition",
        value: function(e) {
            return this.request({
                url: "setRiderLocation",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "robOrder",
        value: function(e) {
            return this.request({
                url: "acceptOrder",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "getRiderOrder",
        value: function(e) {
            return this.request({
                url: "getRiderOrder",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "getAnewCode",
        value: function(e) {
            return this.request({
                url: "resend_sms",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "postGoodsCode",
        value: function(e) {
            return this.request({
                url: "rider_update_order",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "riderAcceptSetting",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "riderAcceptSetting",
                data: e
            });
        }
    }, {
        key: "riderInfo",
        value: function() {
            return this.request({
                url: "riderInfo"
            });
        }
    }, {
        key: "getSystem",
        value: function() {
            return this.request({
                url: "getSetting",
                cachetime: 0
            });
        }
    }, {
        key: "myMoney",
        value: function() {
            return this.request({
                url: "RiderWallet"
            });
        }
    }, {
        key: "riderCashList",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "riderCashList",
                data: e
            });
        }
    }, {
        key: "recharge",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "riderRecharge",
                data: e
            });
        }
    }, {
        key: "withdraw",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "riderWithdraw",
                data: e
            });
        }
    }, {
        key: "getProtocol",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "getRiderAgreement",
                data: e
            });
        }
    }, {
        key: "getOrderCount",
        value: function() {
            return this.request({
                url: "riderOrderCount"
            });
        }
    }, {
        key: "getLogo",
        value: function() {
            return this.request({
                url: "getRiderLogo"
            });
        }
    }, {
        key: "getRiderId",
        value: function() {
            return this.request({
                url: "getRiderId"
            });
        }
    }, {
        key: "riderInviteLog",
        value: function() {
            return this.request({
                url: "riderInviteLog"
            });
        }
    }, {
        key: "getRiderPoster",
        value: function() {
            return this.request({
                url: "getRiderPoster"
            });
        }
    }, {
        key: "getRiderCode",
        value: function() {
            return this.request({
                url: "getRiderCode"
            });
        }
    }, {
        key: "getRiderMsg",
        value: function() {
            return this.request({
                url: "riderInfoDetail"
            });
        }
    }, {
        key: "getUserCode",
        value: function() {
            return this.request({
                url: "getUserCode"
            });
        }
    }, {
        key: "riderEditMobile",
        value: function(e) {
            return this.request({
                url: "riderEditMobile",
                data: e
            });
        }
    }, {
        key: "goodsList",
        value: function(e) {
            return this.request({
                url: "riderequipList",
                data: e
            });
        }
    }, {
        key: "goodsDetail",
        value: function(e) {
            return this.request({
                url: "riderequipDetail",
                data: e
            });
        }
    }, {
        key: "goodsPay",
        value: function(e) {
            return this.request({
                url: "riderequipPay",
                data: e
            });
        }
    }, {
        key: "myGoods",
        value: function(e) {
            return this.request({
                url: "riderMyEquip",
                data: e
            });
        }
    }, {
        key: "riderHandboook",
        value: function(e) {
            return this.request({
                url: "riderHandbookList",
                data: e
            });
        }
    }, {
        key: "riderHandboookDetail",
        value: function(e) {
            return this.request({
                url: "riderHandbookDetail",
                data: e
            });
        }
    }, {
        key: "rewardList",
        value: function(e) {
            return this.request({
                url: "riderSanction",
                data: e
            });
        }
    }, {
        key: "complain",
        value: function(e) {
            return this.request({
                url: "riderAddAppeal",
                data: e
            });
        }
    }, {
        key: "msg",
        value: function(e, t) {
            return this.request({
                url: e,
                data: t
            });
        }
    }, {
        key: "saveFormid",
        value: function(e) {
            return this.request({
                url: "setFormid",
                data: e
            });
        }
    }, {
        key: "getOrderDetail",
        value: function(e) {
            return this.request({
                url: "AcceptOrderDetail",
                data: e
            });
        }
    }, {
        key: "cancelOrder",
        value: function(e) {
            return this.request({
                url: "cancelAccept",
                data: e
            });
        }
    }, {
        key: "developFile",
        value: function(r) {
            var u = this;
            return new Promise(function(e, t) {
                u._developFile(r, e, t);
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

exports.home = home;