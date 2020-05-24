var _home = require("../../modules/home.js"), homeModule = new _home.home(), innerAudioContext = wx.createInnerAudioContext(), app = getApp();

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
        play: 0,
        item_type: [ "帮送", "帮买", "万能服务", "代驾", "其他", "货运", "技能" ],
        fold_arr: {},
        auth: !1,
        is_login: !0
    },
    lifetimes: {
        attached: function() {
            var t = this;
            wx.getSetting({
                success: function(e) {
                    e.authSetting["scope.userInfo"] && t.setData({
                        auth: !0
                    });
                },
                fail: function(e) {}
            });
        }
    },
    pageLifetimes: {
        show: function() {}
    },
    methods: {
        goLogin: function() {
            this.setData({
                is_login: !1
            });
        },
        authBtn: function(e) {
            e.detail.auth ? this.setData({
                auth: !0,
                is_login: !0
            }) : this.setData({
                is_login: !0
            });
        },
        orderDetail: function(e) {
            var t = e.currentTarget.dataset.idx;
            wx.setStorageSync("order_detail", this.data.underwayOrder[t]), wx.navigateTo({
                url: "../order-detail/order-detail"
            });
        },
        robOrder: function(e) {
            var t = this;
            if (1 == app.globalData.syStem.is_can_accept) {
                var n = e.currentTarget.dataset.id;
                homeModule.robOrder({
                    order_id: n
                }).then(function(e) {
                    app.sendWs("type=accept_order&order_id=" + n), app.hint("抢单成功"), app.getRiderLocation(), 
                    t.triggerEvent("robOrderSuccess", {
                        top_id: 1
                    }, {});
                }, function(e) {});
            } else wx.showModal({
                title: "保证金",
                content: "你还未缴纳保证金，暂时无法接单",
                confirmText: "去缴纳",
                success: function(e) {
                    e.confirm ? wx.navigateTo({
                        url: "../my_money/my_money"
                    }) : e.cancel;
                }
            });
        },
        playMusic: function(e) {
            var t = this;
            0 == this.data.play ? (innerAudioContext.src = e.currentTarget.dataset.audio, innerAudioContext.play(), 
            innerAudioContext.onPlay(function() {
                console.log("开始播放"), t.setData({
                    play: 1
                });
            }), innerAudioContext.onEnded(function() {
                console.log("监听停止"), t.setData({
                    play: 0
                });
            }), innerAudioContext.onError(function(e) {
                console.log(e.errMsg), console.log(e.errCode);
            })) : (console.log("暂停"), innerAudioContext.pause(), this.setData({
                play: 0
            }));
        },
        preGoodsImg: function(e) {
            var t = e.currentTarget.dataset.idx, n = e.currentTarget.dataset.index, o = this.data.underwayOrder[n].imgs;
            wx.previewImage({
                current: o[t],
                urls: o
            });
        }
    }
});