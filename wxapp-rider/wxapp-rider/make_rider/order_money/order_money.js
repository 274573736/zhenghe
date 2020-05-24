var _home = require("../../modules/home.js"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        item: {
            status: 6,
            total_price: 10,
            distance: 5,
            weight: 10,
            begin_address: "南宁西乡塘安吉万达广场1号门",
            begin_username: "小晓明",
            begin_phone: 135574232464,
            end_address: "南宁西乡塘区创客城2号楼202",
            end_username: "长的快",
            end_phone: 13557432464,
            order_code: 13557432464,
            add_time: "2015 08 10"
        },
        img_url: app.globalData.imgUrl,
        goods_imgs: []
    },
    onLoad: function(e) {
        app.setNavigation();
    },
    onReady: function() {},
    onShow: function() {},
    uploadImgs: function(e) {
        this.setData({
            goods_imgs: e.detail.imgs
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