var _home = require("../../modules/home.js"), homeModule = new _home.home(), innerAudioContext = wx.createInnerAudioContext(), app = getApp();

Component({
    properties: {
        new_order: {
            type: Object
        },
        that: {
            type: Object
        },
        new_order_status: {
            type: Boolean
        },
        new_order_num: {
            type: Number,
            value: 0,
            observer: function(e, t, o) {
                var r = this;
                2 == e && this.setData({
                    is_tips_transform: !0,
                    order_num: e
                }), 2 < e && (this.setData({
                    is_tips_transform_back: !0,
                    is_tips_transform: !1
                }), setTimeout(function() {
                    r.setData({
                        is_tips_transform_back: !1,
                        order_num: e
                    });
                }, 2e3));
            }
        },
        count_time: {
            type: Number
        },
        img_url: {
            type: String
        }
    },
    data: {
        is_tips_transform: !1,
        is_tips_transform_back: !1,
        order_num: 2,
        play: 0
    },
    methods: {
        bindCall: function() {
            this.triggerEvent("bindCall", {}, {});
        },
        playMusic: function() {
            var e = this;
            0 == this.data.play ? (app.bgm_close(), innerAudioContext.src = this.data.new_order.audio, 
            innerAudioContext.play(), innerAudioContext.onPlay(function() {
                console.log("开始播放"), e.setData({
                    play: 1
                });
            }), innerAudioContext.onEnded(function() {
                console.log("监听停止"), e.setData({
                    play: 0
                });
            }), innerAudioContext.onError(function(e) {
                console.log(e.errMsg), console.log(e.errCode);
            })) : (innerAudioContext.pause(), this.setData({
                play: 0
            }));
        },
        acceptBtn: function(e) {
            app.saveFormid(e.detail.formId);
            var t = e.currentTarget.id;
            this.setData({
                new_order_status: !0
            }), app.bgm_close(), homeModule.robOrder({
                order_id: t
            }).then(function(e) {
                app.sendWs("type=accept_order&order_id=" + t), app.getRiderLocation(), app.robOrder();
            }, function(e) {});
        },
        cancelAccept: function(e) {
            app.saveFormid(e.detail.formId), app.globalData.pushOrder = !1, this.setData({
                new_order_status: !0
            }), app.bgm_close();
        },
        acceptOrder: function() {
            wx.navigateTo({
                url: "../rob_order/rob_order"
            });
        }
    }
});