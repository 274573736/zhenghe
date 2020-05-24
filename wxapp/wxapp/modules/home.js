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

var app = getApp(), home = function(e) {
    function t() {
        return _classCallCheck(this, t), _possibleConstructorReturn(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments));
    }
    return _inherits(t, _http2.http), _createClass(t, [ {
        key: "getTest",
        value: function() {
            return this.request({
                url: "index"
            });
        }
    }, {
        key: "getHomemakingList",
        value: function() {
            return this.request({
                url: "get_category",
                cachetime: 30
            });
        }
    }, {
        key: "getHomemakingDes",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "category_service_desc",
                data: e,
                cachetime: 30
            });
        }
    }, {
        key: "getHomemakingprice",
        value: function(e) {
            return this.request({
                url: "get_category_price",
                data: e
            });
        }
    }, {
        key: "applyDistributor",
        value: function(e) {
            return this.request({
                url: "apply_distributor",
                data: e
            });
        }
    }, {
        key: "distributionConfig",
        value: function(e) {
            return this.request({
                url: "distribution_config",
                data: e
            });
        }
    }, {
        key: "distributionLine",
        value: function(e) {
            return this.request({
                url: "referrals",
                data: e
            });
        }
    }, {
        key: "distributionWithdrawList",
        value: function(e) {
            return this.request({
                url: "Withdraw_list",
                data: e
            });
        }
    }, {
        key: "distributionWithdraw",
        value: function(e) {
            return this.request({
                url: "withdraw",
                data: e
            });
        }
    }, {
        key: "distributionInfo",
        value: function(e) {
            return this.request({
                url: "distribution_center",
                data: e
            });
        }
    }, {
        key: "distributionOrder",
        value: function(e) {
            return this.request({
                url: "distribution_order",
                data: e
            });
        }
    }, {
        key: "driverType",
        value: function(e) {
            return this.request({
                url: "designate_driver_config",
                data: e
            });
        }
    }, {
        key: "driverTrack",
        value: function(e) {
            return this.request({
                url: "track",
                data: e
            });
        }
    }, {
        key: "closeFreightOrder",
        value: function(e) {
            return this.request({
                url: "cancelOrder",
                data: e,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "getFreightRiders",
        value: function(e) {
            return this.request({
                url: "nearby_drivers",
                data: e,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "carDetail",
        value: function(e) {
            return this.request({
                url: "car_detail",
                data: e,
                module: "make_speed_plugin_freight",
                cachetime: 30
            });
        }
    }, {
        key: "payFreight",
        value: function(e) {
            return this.request({
                url: "pay",
                data: e,
                cachetime: 0,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "postOrder",
        value: function(e) {
            return this.request({
                url: "createOrder",
                data: e,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "predictPrice",
        value: function(e) {
            return this.request({
                url: "priceCount",
                data: e,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "address_msg",
        value: function(e) {
            return this.request({
                url: "address_msg",
                data: e,
                cachetime: 60,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "topSwiper",
        value: function() {
            return this.request({
                url: "banner",
                cachetime: 60,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "carType",
        value: function() {
            return this.request({
                url: "getcar",
                cachetime: 60,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "newCoupon",
        value: function(e) {
            return this.request({
                url: "new_user_coupon",
                data: e,
                module: "make_speed_plugin_freight"
            });
        }
    }, {
        key: "mapIcon",
        value: function() {
            return this.request({
                url: "get_setting"
            });
        }
    }, {
        key: "getFormId",
        value: function() {
            return this.request({
                url: "formid_count"
            });
        }
    }, {
        key: "getUserPhone",
        value: function(e) {
            return this.request({
                url: "getWxMobile",
                data: e
            });
        }
    }, {
        key: "getBusinessType",
        value: function() {
            return this.request({
                url: "getYewu",
                cachetime: 30
            });
        }
    }, {
        key: "businessCash",
        value: function(e) {
            return this.request({
                url: "businessCash",
                data: e,
                cachetime: 30
            });
        }
    }, {
        key: "businessRecharge",
        value: function(e) {
            return this.request({
                url: "businessrecharge",
                data: e
            });
        }
    }, {
        key: "businessOrder",
        value: function(e) {
            return this.request({
                url: "businessOrder",
                data: e
            });
        }
    }, {
        key: "aKeyOrder",
        value: function(e) {
            return this.request({
                url: "addbusorder",
                data: e
            });
        }
    }, {
        key: "aKeyOrderPrice",
        value: function(e) {
            return this.request({
                url: "getBusinessPrice",
                data: e
            });
        }
    }, {
        key: "staffList",
        value: function(e) {
            return this.request({
                url: "personnelList",
                data: e
            });
        }
    }, {
        key: "staffDel",
        value: function(e) {
            return this.request({
                url: "delPersonnel",
                data: e
            });
        }
    }, {
        key: "staffEdit",
        value: function(e) {
            return this.request({
                url: "editPersonnel",
                data: e
            });
        }
    }, {
        key: "staffAdd",
        value: function(e) {
            return this.request({
                url: "addPersonnel",
                data: e
            });
        }
    }, {
        key: "businessStatus",
        value: function() {
            return this.request({
                url: "isBusiness"
            });
        }
    }, {
        key: "businessInfo",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "businessInfo",
                data: e
            });
        }
    }, {
        key: "businessAdd",
        value: function(e) {
            return this.request({
                url: "addBusiness",
                data: e
            });
        }
    }, {
        key: "businessSetting",
        value: function() {
            return this.request({
                url: "settingBusiness"
            });
        }
    }, {
        key: "invoiceMoney",
        value: function() {
            return this.request({
                url: "invoiceMoney"
            });
        }
    }, {
        key: "applyInvoice",
        value: function(e) {
            return this.request({
                url: "addInvoice",
                data: e
            });
        }
    }, {
        key: "invoiceList",
        value: function() {
            return this.request({
                url: "invoiceList"
            });
        }
    }, {
        key: "saveFromId",
        value: function(e) {
            return this.request({
                url: "setFormId",
                data: e
            });
        }
    }, {
        key: "login",
        value: function(e) {
            return this.request({
                url: "login",
                data: e
            });
        }
    }, {
        key: "getRiders",
        value: function(e) {
            return this.request({
                url: "getPosition",
                data: e
            });
        }
    }, {
        key: "getCity",
        value: function(e) {
            return this.request({
                url: e,
                cachetime: 30
            });
        }
    }, {
        key: "getGoodsList",
        value: function(e) {
            return this.request({
                url: "goodsType",
                data: e,
                cachetime: 30
            });
        }
    }, {
        key: "getBanner",
        value: function() {
            return this.request({
                url: "getBanner",
                cachetime: 30
            });
        }
    }, {
        key: "getFloor",
        value: function() {
            return this.request({
                url: ""
            });
        }
    }, {
        key: "getCoupons",
        value: function(e) {
            return this.request({
                url: "coupons",
                data: e
            });
        }
    }, {
        key: "getCodeCoupon",
        value: function(e) {
            return this.request({
                url: "getCodeCoupon",
                data: e
            });
        }
    }, {
        key: "getTime",
        value: function() {
            return this.request({
                url: "getTime",
                cachetime: 30
            });
        }
    }, {
        key: "getMoney",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "mymoney",
                data: e
            });
        }
    }, {
        key: "businessType",
        value: function() {
            return this.request({
                url: "GetOpenbusine",
                cachetime: 30
            });
        }
    }, {
        key: "calculateMoney",
        value: function(e) {
            return this.request({
                url: "Getprice",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "toOrder",
        value: function(e) {
            return this.request({
                url: "addOrder",
                data: e
            });
        }
    }, {
        key: "pay",
        value: function(e) {
            return this.request({
                url: "pay",
                data: e,
                cachetime: 0
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
        key: "orderList",
        value: function(e) {
            return this.request({
                url: "orderList",
                data: e
            });
        }
    }, {
        key: "orderDetail",
        value: function(e) {
            var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "make_speed";
            return this.request({
                url: "orderDetail",
                data: e,
                module: t
            });
        }
    }, {
        key: "amount",
        value: function(e, t) {
            return this.request({
                url: e,
                data: t
            });
        }
    }, {
        key: "closeOrder",
        value: function(e) {
            return this.request({
                url: "cancelOrder",
                data: e
            });
        }
    }, {
        key: "evaluete",
        value: function(e, t) {
            return this.request({
                url: e,
                data: t
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
    }, {
        key: "getSystem",
        value: function() {
            return this.request({
                url: "getSetting",
                cachetime: 30
            });
        }
    }, {
        key: "getRecommendRedbag",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "getRedbao",
                data: e,
                cachetime: 0
            });
        }
    }, {
        key: "getProtocol",
        value: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            return this.request({
                url: "getAgreement",
                data: e,
                cachetime: 30
            });
        }
    }, {
        key: "updateOrder",
        value: function(e) {
            return this.request({
                url: "updateOrder",
                data: e
            });
        }
    }, {
        key: "businessTip",
        value: function(e) {
            return this.request({
                url: "add_tips",
                data: e
            });
        }
    }, {
        key: "reminder",
        value: function(e) {
            return this.request({
                url: "reminder",
                data: e
            });
        }
    }, {
        key: "rechargeValid",
        value: function(e) {
            return this.request({
                url: "rechargeValid",
                data: e
            });
        }
    }, {
        key: "dealDetail",
        value: function(e) {
            return this.request({
                url: "userCashLog",
                data: e
            });
        }
    }, {
        key: "getIsNewCoupons",
        value: function() {
            return this.request({
                url: "getNewPerson"
            });
        }
    }, {
        key: "getNewCoupons",
        value: function(e) {
            return this.request({
                url: "acceptNewperson",
                data: e
            });
        }
    }, {
        key: "getPoster",
        value: function() {
            return this.request({
                url: "getPoster",
                cachetime: 30
            });
        }
    }, {
        key: "getUserId",
        value: function(e) {
            return this.request({
                url: "getUserId",
                data: e
            });
        }
    }, {
        key: "getShareInvite",
        value: function() {
            return this.request({
                url: "getShareInvite",
                cachetime: 30
            });
        }
    }, {
        key: "getShopping",
        value: function(e) {
            return this.request({
                url: "couponShop",
                data: e
            });
        }
    }, {
        key: "getGoodsDetail",
        value: function(e) {
            return this.request({
                url: "couponDetail",
                data: e
            });
        }
    }, {
        key: "buyCoupon",
        value: function(e) {
            return this.request({
                url: "buyCoupon",
                data: e
            });
        }
    }, {
        key: "sendTemplate",
        value: function(e) {
            return this.request({
                url: "sendTemplate",
                data: e
            });
        }
    }, {
        key: "sendCloseTemplate",
        value: function(e) {
            return this.request({
                url: "sendCancelTpl",
                data: e
            });
        }
    }, {
        key: "getMsgList",
        value: function(e, t) {
            return this.request({
                url: e,
                data: t,
                cachetime: 30
            });
        }
    }, {
        key: "unread",
        value: function() {
            return this.request({
                url: "isNewMessage"
            });
        }
    }, {
        key: "getSystemMessageDetail",
        value: function(e) {
            return this.request({
                url: "userMessageDetail",
                data: e
            });
        }
    }, {
        key: "getUserInfo",
        value: function() {
            return this.request({
                url: "userInfo"
            });
        }
    }, {
        key: "moneys",
        value: function(a, s, o) {
            var l = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : 0, e = 4 < arguments.length && void 0 !== arguments[4] ? arguments[4] : 0, c = 1 * a.data.tip_money;
            this.calculateMoney({
                distance: s,
                weight_num: o,
                order_type: l,
                floor: e,
                hour: a.data.hour,
                city: wx.getStorageSync("city")
            }).then(function(e) {
                var t = 1 * e.money, r = (t += c).toFixed(2), u = a.data.coupons, n = 0;
                u && u.coupons_money && t >= u.satisfy_money && (r = (t - (n = 1 * u.coupons_money)).toFixed(2));
                var i = {};
                i.night_price = 1 * e.night_price, i.change_price = 1 * e.change_price, i.tip_money = c, 
                i.actual_payment = r, i.coupon_money = n, i.weight = o, i.distance = s, i.discount_price = e.discount_price, 
                i.order_type = l, i.floor_price = e.floor_price, i.distance_price = e.distance_price, 
                wx.setStorageSync("price_detail", i), a.setData({
                    actual_payment: r,
                    money: t,
                    price_detail: i,
                    distance_price: e.distance_price
                });
            }, function(e) {});
        }
    }, {
        key: "date",
        value: function(e, t, r) {
            var u = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : 0, n = e, i = 1 * t, a = 1 * r + 0, s = a - 60, o = [], l = [];
            if (23 == i && 0 == s) {
                for (var c = 0; c <= 23; c++) l.push(c);
                for (var d = 0; d < 60; d += 10) o.push(d);
                4 == n.length && n.shift();
            }
            if (i < 23 && 0 == s) {
                for (c = 0; c < 24; c++) i < c && l.push(c);
                for (d = 0; d < 60; d += 10) o.push(d);
                4 == n.length && n.pop();
            }
            if (23 == i && 0 < s) {
                for (c = 0; c <= 23; c++) l.push(c);
                for (d = 0; d < 60; d += 10) s <= 10 ? 10 <= d && o.push(d) : 10 < d && o.push(d);
                4 == n.length && n.shift();
            }
            if (i < 23 && 0 < s) {
                for (c = 0; c < 24; c++) i < c && l.push(c);
                for (d = 0; d < 60; d += 10) s <= 10 ? 10 <= d && o.push(d) : 10 < d && o.push(d);
                4 == n.length && n.pop();
            }
            if (i < 23 && s < 0) {
                for (c = 0; c < 24; c++) i <= c && l.push(c);
                for (d = 0; d <= 60; d += 10) a <= d && o.push(d);
                if (60 == o.pop()) if ("" == o) {
                    o = [];
                    for (var h = 0; h < 60; h += 10) o.push(h);
                    l.shift(), 4 == n.length && n.pop();
                } else 4 == n.length && n.pop();
            }
            if (23 == i && s < 0) {
                for (d = 0; d <= 60; d += 10) a <= d && o.push(d);
                if (60 == o.pop()) if ("" == o) {
                    o = [], l = [];
                    for (h = 0; h < 60; h += 10) o.push(h);
                    for (var f = 0; f < 24; f++) l.push(f);
                    4 == n.length && n.shift();
                } else l = [ 23 ], 4 == n.length && n.pop();
            }
            n.shift(), n.unshift("今天"), o = o.map(function(e) {
                return 0 == e && (e = "0" + e), e;
            });
            var p = "";
            return p = 0 == u ? "立即取件" : 1 == u ? "立即帮买" : 2 == u ? "立即" : 3 == u ? "立即" : 5 == u ? "立即取货" : "立即", 
            (l = l.map(function(e) {
                return e < 10 && (e = "0" + e), e + "点";
            })).unshift(p), {
                days: n,
                hours: l,
                minutes: o
            };
        }
    } ]), t;
}();

exports.home = home;