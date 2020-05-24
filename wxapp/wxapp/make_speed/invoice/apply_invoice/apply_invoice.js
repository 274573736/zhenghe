var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        money: 0
    },
    onLoad: function(e) {
        var o = this;
        homeModule.invoiceMoney().then(function(e) {
            o.setData({
                money: e.money
            });
        }, function(e) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    applyInvoice: function() {
        var e = this.data.money;
        if (!e || 0 == e) return app.hint("发票金额不能为0元~");
        wx.navigateTo({
            url: "/make_speed/invoice/invoice_msg/invoice_msg?money=" + e
        });
    },
    invoiceList: function() {
        wx.navigateTo({
            url: "/make_speed/invoice/invoice_list/invoice_list"
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