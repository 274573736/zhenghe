var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        list: [ "个人", "企业" ],
        idx: 0,
        money: 0,
        account_show: !1,
        content: "*物流辅助服务*派送服务费"
    },
    onLoad: function(t) {
        this.setData({
            money: t.money ? t.money : 0
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    select: function(t) {
        var e = t.currentTarget.dataset.idx, a = 0 != e;
        this.setData({
            idx: e,
            account_show: a
        });
    },
    confirm: function(t) {
        var e = this.data.idx, a = this.data.money, n = t.detail.value.title, o = t.detail.value.account, i = t.detail.value.phone, p = t.detail.value.email, u = t.detail.value.content, l = t.detail.value.amount;
        return n ? !o && 0 < e ? app.hint("税号不能为空~") : u ? l && 0 != l ? a < l ? app.hint("发票金额不能大于总金额~") : i ? /^1(3|4|5|6|7|8|9)\d{9}$/.test(i) ? p ? /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/.test(p) ? void homeModule.applyInvoice({
            type_name: n,
            type: e,
            tax_number: o,
            content: u,
            amount: l,
            mobile: i,
            email: p
        }).then(function(t) {
            app.hint("提交成功~"), setTimeout(function() {
                wx.navigateBack({
                    delta: 2
                });
            }, 400);
        }, function(t) {}) : app.hint("邮箱格式错误~") : app.hint("邮箱不能为空~") : app.hint("手机号格式错误~") : app.hint("手机号不能为空~") : app.hint("发票金额不能为空~") : app.hint("发票内容不能为空~") : app.hint("发票抬头不能为空~");
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