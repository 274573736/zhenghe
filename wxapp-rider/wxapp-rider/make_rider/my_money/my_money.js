var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        list: [],
        is_cash: 1
    },
    onLoad: function(e) {
        app.setNavigation();
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.listenWss(this), homeModule.myMoney().then(function(e) {
            a.setData({
                list: e,
                is_cash: app.globalData.syStem.is_can_accept
            }), wx.setStorageSync("money", e.valid_money), wx.setStorageSync("cash", e.bond_money);
        }, function(e) {});
    },
    payDetail: function() {
        wx.navigateTo({
            url: "../income_detail/income_detail"
        });
    },
    recharge: function() {
        wx.navigateTo({
            url: "../recharge/recharge?is_cash=" + this.data.is_cash + "&cash_money=" + this.data.list.bond_money
        });
    },
    withdrawDepoit: function() {
        wx.navigateTo({
            url: "../withdraw_deposit/withdraw_deposit"
        });
    },
    accountDescription: function() {
        wx.navigateTo({
            url: "../bean_description/bean_description?title=账户说明&type=rider_account"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    }
});