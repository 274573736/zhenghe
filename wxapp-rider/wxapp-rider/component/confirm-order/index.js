var _home = require("../../modules/home"), _setting = require("../../modules/setting"), homeModule = new _home.home(), settingModule = new _setting.setting(), app = getApp();

Component({
    properties: {
        img_url: {
            type: String
        },
        underwayOrder: {
            type: Array
        }
    },
    data: {
        goods_code: "",
        play: 0,
        item_type: [ "帮送", "帮买", "万能服务", "代驾", "其他", "货运", "技能" ],
        start_type: [ "取件地址：", "购买地址：", "服务地址：", "代驾地址：" ],
        end_type: [ "收件地址：", "购买者地址：", "服务地址：", "代驾目的地：" ],
        start_person: [ "发件人：", "购买人：", "服务人：", "下单人：" ],
        end_person: [ "收件人：", "购买人：", "服务人：", "下单人：" ],
        getcode_switch: 0,
        endcode_switch: 0,
        goods_imgs: [],
        end_imgs: [],
        fold_arr: {}
    },
    lifetimes: {
        attached: function() {
            var t = this, e = setInterval(function() {
                app.globalData.syStem && (clearInterval(e), t.setData({
                    getcode_switch: app.globalData.syStem.getcode_switch,
                    endcode_switch: app.globalData.syStem.endcode_switch
                }));
            }, 10);
        }
    },
    methods: {
        getGoodsCode: function(e) {
            wx.showModal({
                title: "温馨提示",
                content: "先确认用户没有收到完成码时，才能重新补发",
                cancelText: "收到了",
                confirmText: "没有",
                success: function(t) {
                    t.confirm ? homeModule.getAnewCode({
                        id: e.currentTarget.dataset.id || 0
                    }).then(function(t) {
                        app.hint("补发成功~");
                    }, function(t) {}) : t.cancel;
                }
            });
        },
        foldBtn: function(t) {
            var e = t.currentTarget.dataset.id, a = this.data.fold_arr;
            a[e] ? a[e] = !1 : a[e] = !0, this.setData({
                fold_arr: a
            });
        },
        orderDetail: function(t) {
            var e = t.currentTarget.dataset.idx;
            wx.setStorageSync("order_detail", this.data.underwayOrder[e]), wx.navigateTo({
                url: "../order-detail/order-detail"
            });
        },
        phone: function(t) {
            var e = t.currentTarget.dataset.phone;
            e && wx.makePhoneCall({
                phoneNumber: e
            });
        },
        preImg: function(t) {
            var e = t.currentTarget.dataset.url;
            wx.previewImage({
                current: e,
                urls: [ e ]
            });
        },
        navigation: function(t) {
            var e = 1 * t.currentTarget.dataset.lat, a = 1 * t.currentTarget.dataset.lng, o = t.currentTarget.dataset.name, n = t.currentTarget.dataset.address;
            wx.openLocation({
                latitude: e,
                longitude: a,
                name: o,
                address: n
            });
        },
        goodsCode: function(t) {
            var e = t.detail.value;
            this.setData({
                goods_code: e
            });
        },
        confirmGoods: function(t) {
            var e = this, a = t.currentTarget.dataset.id, o = t.currentTarget.dataset.idx, n = t.currentTarget.dataset.type, i = t.currentTarget.dataset.index, r = "", d = this.data.goods_code, s = "";
            if (0 == o) r = this.data.goods_imgs[a] || ""; else if (1 == o) {
                var c = this.data.end_imgs;
                s = c[a] || "";
            }
            3 != this.data.underwayOrder[i].payment || 1 != o ? this.confirmData(a, d, r, s, n, o) : wx.showModal({
                title: "提示",
                content: "此订单是现金支付订单，请跟客户收款后再确认完成。",
                confirmText: "已支付",
                cancelText: "未支付",
                success: function(t) {
                    t.confirm ? e.confirmData(a, d, r, s, n, o) : t.cancel && console.log("用户点击取消");
                }
            });
        },
        confirmData: function() {
            var a = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", o = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "", n = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : "", i = this, r = 4 < arguments.length && void 0 !== arguments[4] ? arguments[4] : 0, d = 5 < arguments.length && void 0 !== arguments[5] ? arguments[5] : 0;
            app.globalData.socket_location_switch && app.globalData.socket_location || 3 != r ? (wx.showLoading({
                title: 0 < d ? "完成中" : "确认中"
            }), settingModule.getLocation().then(function(t) {
                homeModule.postGoodsCode({
                    id: a,
                    goods_code: e,
                    goods_img: o,
                    end_img: n,
                    lat: t.latitude,
                    lng: t.longitude,
                    type: d
                }).then(function(t) {
                    wx.hideLoading(), i.setData({
                        goods_code: ""
                    });
                    app.sendWs("type=accept_order&order_id=" + a), i.triggerEvent("robOrderSuccess", {
                        top_id: 2
                    }, {});
                    var e = "";
                    e = 0 == d ? 0 == r ? "确认取件" : 1 == r ? "确认购买" : 2 == r ? "确认服务" : 3 == r ? "确认驾驶" : 5 == r ? "确认取货" : "确认服务" : 0 == r ? "完成收件" : 1 == r ? "完成购买" : 2 == r ? "完成服务" : 3 == r ? "完成驾驶" : 5 == r ? "确认送达" : "确认完成", 
                    app.getRiderLocation(), app.hint(e);
                }, function(t) {});
            }, function(t) {})) : this.bgLocationTip();
        },
        bgLocationTip: function() {
            wx.showModal({
                title: "提示",
                content: "代驾订单需要在接单设置里开启，实时共享位置",
                confirmText: "去打开",
                success: function(t) {
                    t.confirm && wx.navigateTo({
                        url: "../order_setting/order_setting"
                    });
                }
            });
        },
        uploadImgs: function(t) {
            var e = t.detail.order_id, a = t.detail.imgs;
            if (3 == t.detail.type) {
                var o = this.data.goods_imgs;
                o[e] = a, this.setData({
                    goods_imgs: o
                });
            } else {
                var n = this.data.end_imgs;
                n[e] = a, this.setData({
                    end_imgs: n
                });
            }
        },
        cancelOrder: function(t) {
            var e = this, a = t.currentTarget.dataset.id, o = t.currentTarget.dataset.idx;
            wx.showModal({
                title: "取消接单",
                content: "取消接单次数过多，将会禁止接单~",
                success: function(t) {
                    t.confirm ? homeModule.cancelOrder({
                        id: a
                    }).then(function(t) {
                        app.sendWs("type=place_order&order_id=" + a + "&data=" + t.data), e.triggerEvent("cancelOrder", {
                            idx: o
                        }, {});
                    }, function(t) {}) : t.cancel;
                }
            });
        }
    }
});