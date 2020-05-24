var app = getApp();

Page({
    data: {
        price_detail: {},
        gy_discount: 0
    },
    onLoad: function(e) {
        var a = app.globalData.syStem.gy_discount || 0, t = wx.getStorageSync("price_detail") || {};
        t.carry = t.carry || 0, t.change_price = t.change_price || 0, t.tip_money = t.tip_money || 0, 
        t.carry_car_type = t.carry_car_type || 0, t.night_price = t.night_price || 0, t.floor_price = t.floor_price || 0, 
        t.carload_fee = t.carload_fee || 0, t.weight_fee = t.weight_fee || 0, t.cube_price = t.cube_price || 0, 
        t.volume = t.volume || 0, this.setData({
            gy_discount: a,
            price_detail: t
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    priceDescription: function() {
        wx.navigateTo({
            url: "../protocol/protocol?title=价格说明&type=user_price"
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