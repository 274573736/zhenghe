var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        top_item: [ "消费记录", "充值记录", "退款记录" ],
        my_money: 0,
        top_id: 0,
        time_picker: !0,
        list: [],
        page: 1,
        time: "",
        isData: !0,
        invoice_switch: 0,
        is_business: 0,
        year: "",
        month: ""
    },
    onLoad: function(t) {
        var a = t.is_business || 0, e = new Date(), i = [];
        i[0] = e.getFullYear(), i[1] = e.getFullYear() - 1;
        var s = e.getMonth() + 1;
        this.setData({
            year: i[0],
            invoice_switch: app.globalData.syStem.invoice_switch,
            month: s,
            is_business: a
        }), this.postData(0, 1);
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.mymoney();
    },
    mymoney: function() {
        var a = this;
        homeModule.getMoney().then(function(t) {
            a.setData({
                my_money: t.valid
            });
        }, function(t) {});
    },
    invoiceBtn: function() {
        wx.navigateTo({
            url: "/make_speed/invoice/apply_invoice/apply_invoice"
        });
    },
    postData: function(t, a) {
        var e = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "";
        if (!this.data.isData && 1 < a) return app.hint("暂无更多数据~");
        1 != this.data.is_business ? this.user(t, a, e) : this.business(t, a, e);
    },
    user: function(t, a) {
        var e = this, i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "", s = [];
        homeModule.dealDetail({
            type: t,
            page: a,
            time: i
        }).then(function(t) {
            s = t, 1 < a && (s = e.data.list.concat(t)), e.setData({
                list: s,
                page: a,
                isData: !0
            });
        }, function(t) {
            1 < a ? e.setData({
                isData: !1
            }) : e.setData({
                list: []
            });
        });
    },
    business: function() {
        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, a = this, e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0, i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : "", s = [];
        homeModule.businessCash({
            type: t,
            page: e,
            time: i,
            bid: app.globalData.business_id
        }).then(function(t) {
            s = t, 1 < e && (s = a.data.list.concat(t)), a.setData({
                list: s,
                page: e,
                isData: !0
            });
        }, function(t) {
            1 < e ? a.setData({
                isData: !1
            }) : a.setData({
                list: []
            });
        });
    },
    itemTap: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            top_id: a,
            isData: !0,
            page: 1,
            time: ""
        }), this.postData(a, 1);
    },
    recharge: function() {
        wx.navigateTo({
            url: "../recharge/recharge?money=" + this.data.my_money
        });
    },
    sTime: function(t) {
        var a = t.detail.select;
        if (1 == a) {
            this.setData({
                time_picker: !0
            });
            var e = t.detail.year, i = t.detail.month, s = e + "-" + i;
            this.setData({
                year: e,
                month: i,
                time: s
            }), this.postData(this.data.top_id, 1, s);
        } else 2 == a ? this.setData({
            time_picker: !0
        }) : this.setData({
            time_picker: !1
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this.data.top_id, a = 1 * this.data.page + 1, e = this.data.time;
        this.postData(t, a, e);
    },
    onShareAppMessage: function() {
        return app.getShare(), {
            title: app.globalData.syStem.user_program_title,
            path: "/make_speed/router/router?recommend_id=" + app.globalData.user_id,
            imageUrl: app.globalData.syStem.user_share_img ? app.globalData.syStem.user_share_img : ""
        };
    }
});