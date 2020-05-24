var _home = require("../../modules/home.js"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        list: [],
        img_url: app.globalData.imgUrl
    },
    onLoad: function(a) {
        var i = this;
        app.setNavigation();
        var r = wx.getStorageSync("rider_address"), l = [], d = {
            id: 0,
            latitude: r.location.lat,
            longitude: r.location.lng,
            iconPath: app.globalData.rider_icon || this.data.img_url + "rider.png",
            width: 40,
            height: 40
        };
        l.push(d), homeModule.getRiderOrder({
            status: 2
        }).then(function(a) {
            for (var t = 0; t < a.length; t++) {
                var e = a[t].begin_lat, o = a[t].begin_lng;
                e && o || (e = a[t].end_lat, o = a[t].end_lng);
                var n = a[t].goodsname ? a[t].goodsname + "/" : "";
                d = {
                    id: t,
                    latitude: e,
                    longitude: o,
                    iconPath: i.data.img_url + "start.png",
                    width: 25,
                    height: 40,
                    callout: {
                        content: n + "路程" + a[t].distance + "公里\n" + a[t].total_price + "元",
                        color: "#ffffff",
                        fontSize: 12,
                        textAlign: "center",
                        bgColor: "#3EBBF3",
                        padding: 8,
                        borderRadius: 5,
                        display: "ALWAYS"
                    }
                }, l.push(d);
            }
            i.setData({
                latitude: r.location.lat,
                longitude: r.location.lng,
                markers: l,
                list: a
            });
        }, function(a) {
            return i.setData({
                latitude: r.location.lat,
                longitude: r.location.lng,
                markers: l
            }), app.hint("暂无可抢订单~");
        });
    },
    markertap: function(a) {
        var t = a.markerId;
        wx.setStorageSync("map_data", this.data.list[t]), wx.navigateTo({
            url: "../rob_order/rob_order?map=1"
        });
    },
    onReady: function() {},
    onShow: function() {},
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