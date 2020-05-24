var app = getApp(), innerAudioContext = wx.createInnerAudioContext();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        order: {},
        item_type: [ "帮送", "帮买", "万能服务", "代驾", "其他", "货运", "技能" ]
    },
    onLoad: function(t) {
        app.setNavigation();
        var e = wx.getStorageSync("order_detail");
        this.setData({
            order: e
        });
    },
    onReady: function() {},
    onShow: function() {
        app.listenWss(this);
    },
    preGoodsImg: function(t) {
        var e = t.currentTarget.dataset.idx, a = t.currentTarget.dataset.imgs;
        wx.previewImage({
            current: a[e],
            urls: a
        });
    },
    playMusic: function(t) {
        var e = this;
        0 == this.data.play ? (innerAudioContext.src = t.currentTarget.dataset.audio, innerAudioContext.play(), 
        innerAudioContext.onPlay(function() {
            console.log("开始播放"), e.setData({
                play: 1
            });
        }), innerAudioContext.onEnded(function() {
            console.log("监听停止"), e.setData({
                play: 0
            });
        }), innerAudioContext.onError(function(t) {
            console.log(t.errMsg), console.log(t.errCode);
        })) : (console.log("暂停"), innerAudioContext.pause(), this.setData({
            play: 0
        }));
    },
    navigation: function(t) {
        var e = 1 * t.currentTarget.dataset.lat, a = 1 * t.currentTarget.dataset.lng, n = t.currentTarget.dataset.name, o = t.currentTarget.dataset.address;
        wx.openLocation({
            latitude: e,
            longitude: a,
            name: n,
            address: o
        });
    },
    callPhone: function(t) {
        var e = t.currentTarget.dataset.phone;
        e && wx.makePhoneCall({
            phoneNumber: e
        });
    },
    copyText: function() {
        wx.setClipboardData({
            data: this.data.order.order_code,
            success: function() {}
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