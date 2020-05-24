var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        whithdraw_type: 0,
        whithdraw_list: [],
        money: "",
        my_money: 0
    },
    onLoad: function(t) {
        this.setData({
            my_money: t.my_money
        });
        var a = wx.getStorageSync("distributor");
        this.setData({
            whithdraw_list: a.d_commission_type,
            whithdraw_type: a.d_commission_type[0].type
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    allWhithdraw: function() {
        this.setData({
            money: this.data.my_money
        });
    },
    whithdrawMoney: function(t) {
        var a = t.detail.value, e = this.data.whithdraw_type, n = parseFloat(this.data.my_money), i = parseFloat(a.money);
        if (n < i || i <= 0) return app.hint("提现金额有误~");
        var o = "", r = "", h = "";
        if (3 == e) {
            if (!a.name) return app.hint("姓名不能为空~");
            if (!a.bank) return app.hint("开户行不能为空~");
            if (!a.bank_account) return app.hint("银行卡号不能为空~");
            r = a.name, h = a.bank, o = a.bank_account;
        }
        if (2 == e) {
            if (!a.name) return app.hint("姓名不能为空~");
            if (!a.ali_account) return app.hint("支付宝账号不能为空~");
            r = a.name, o = a.ali_account;
        }
        homeModule.distributionWithdraw({
            amount: a.money,
            type: e,
            name: r,
            bank: h,
            account: o,
            city_id: 0
        }).then(function(t) {
            wx.showModal({
                title: "温馨提示",
                content: "您的提现申请已经提交审核，我们会 尽快为您审核，请耐心等待。",
                success: function(t) {
                    t.confirm && wx.navigateBack({
                        delta: 1
                    });
                }
            });
        }, function(t) {});
    },
    payTap: function(t) {
        this.setData({
            whithdraw_type: t.currentTarget.dataset.type
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return app.getShare(), {
            title: app.globalData.syStem.user_program_title,
            path: "/make_speed/router/router?recommend_id=" + app.globalData.user_id,
            imageUrl: app.globalData.syStem.user_share_img ? app.globalData.syStem.user_share_img : ""
        };
    }
});