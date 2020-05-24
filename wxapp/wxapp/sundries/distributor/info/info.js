var _home = require("../../../modules/home"), _setting = require("../../../modules/setting"), homeModule = new _home.home(), settingModule = new _setting.setting(), app = getApp();

Page({
    data: {
        statusBar: 0,
        nav_height: 0,
        sharePoster: !1,
        canvas_bg: "",
        list: {},
        isPoster: 0,
        head_url: "",
        code_url: "",
        bj_url: "",
        nickname: "",
        is_login: !0,
        auth: !1
    },
    onLoad: function(t) {
        var n = this;
        wx.getSystemInfo({
            success: function(t) {
                var e = t.statusBarHeight, a = wx.getMenuButtonBoundingClientRect(), i = a.bottom + a.top - t.statusBarHeight;
                n.setData({
                    statusBar: e,
                    nav_height: i
                });
            }
        }), settingModule.auth(0).then(function(t) {
            t && (n.setData({
                auth: !0
            }), n.avatarInit());
        }, function(t) {});
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        homeModule.distributionInfo().then(function(t) {
            e.setData({
                info: t
            });
        }, function(t) {});
    },
    copyBtn: function() {
        wx.setClipboardData({
            data: this.data.info.invite_code,
            success: function(t) {}
        });
    },
    goLogin: function() {
        this.setData({
            is_login: !1
        });
    },
    authBtn: function(t) {
        if (t.detail.uid) return this.setData({
            uid: t.detail.uid,
            auth: !0,
            is_login: !0
        }), void this.avatarInit();
        this.setData({
            is_login: !0
        });
    },
    orderWhithdraw: function() {
        wx.navigateTo({
            url: "/sundries/distributor/whithdraw/whithdraw?my_money=" + this.data.info.commission
        });
    },
    orderLine: function() {
        wx.navigateTo({
            url: "/sundries/distributor/line/line"
        });
    },
    orderList: function() {
        wx.navigateTo({
            url: "/sundries/distributor/order/order"
        });
    },
    priceDetail: function() {
        wx.navigateTo({
            url: "/sundries/distributor/price_detail/price_detail"
        });
    },
    inviteBtn: function() {
        var t = this;
        wx.showLoading({
            title: "海报生成中"
        });
        var e = 0, a = setInterval(function() {
            e++, t.data.head_url && t.data.code_url && t.data.bj_url && (t.setData({
                sharePoster: !0
            }), clearInterval(a), t.poster()), 600 < e && (e = 0, clearInterval(a), t.setData({
                sharePoster: !1
            }), app.hint("海报生成失败，请重试~")), t.setData({
                num: e
            });
        }, 100);
    },
    hidePoster: function() {
        this.setData({
            sharePoster: !1
        });
    },
    avatarInit: function() {
        var n = this, t = wx.getSystemInfoSync(), e = t.screenWidth, a = t.screenHeight;
        this.factor = e / 750;
        var o = this.toRpx(e) - 200;
        this.width = o;
        var s = this.toRpx(a) - 400, r = this.toPx(o, !0), u = 3 * r / 2, i = wx.getStorageSync("userInfo"), l = i.wxInfo.avatarUrl, c = i.wxInfo.nickName, h = homeModule.getCode(), d = homeModule.getPoster();
        Promise.all([ h, d ]).then(function(t) {
            var e = homeModule.developFile(l), a = homeModule.developFile(t[0]), i = homeModule.developFile(t[1].img_url);
            Promise.all([ e, a, i ]).then(function(t) {
                n.setData({
                    head_url: t[0],
                    code_url: t[1],
                    bj_url: t[2],
                    nickname: c,
                    height: s,
                    width: o,
                    widthPx: r,
                    heightPx: u,
                    isPoster: 1
                });
            }, function(t) {});
        }, function(t) {});
    },
    poster: function() {
        var n = this, o = setInterval(function() {
            if (1 == n.data.isPoster) {
                clearInterval(o);
                var t = n.data.widthPx, e = n.data.heightPx, a = wx.createCanvasContext("poster");
                a.drawImage(n.data.bj_url, 0, 0, t, e), a.setTextAlign("center"), a.setFillStyle("#ffffff"), 
                a.font = "normal bold 15px normal", a.fillText(n.data.nickname, t / 2, n.toPx(840)), 
                a.save(), a.beginPath();
                var i = n.toPx(185);
                a.arc(n.toPx(385), n.toPx(555), i, 0, 2 * Math.PI), a.clip(), a.drawImage(n.data.code_url, n.toPx(200), n.toPx(370), 2 * i, 2 * i), 
                a.draw(), wx.hideLoading(), setTimeout(function() {
                    wx.canvasToTempFilePath({
                        canvasId: "poster",
                        success: function(t) {
                            n.setData({
                                poster_url: t.tempFilePath
                            });
                        },
                        fail: function(t) {
                            console.log(t);
                        }
                    });
                }, 200);
            }
        }, 10);
    },
    writeFont: function(t, e, a, i, n, o) {
        t.setFillStyle(a), t.font = i, t.fillText(e, n, o), t.save(), t.beginPath();
    },
    toPx: function(t) {
        return 1 < arguments.length && void 0 !== arguments[1] && arguments[1] ? t * this.factor : (t * (this.width / 750) * this.factor).toFixed(1);
    },
    toRpx: function(t) {
        return t / this.factor;
    },
    saveImg: function() {
        var t = this.data.poster_url;
        t && this.save(t);
    },
    save: function(t) {
        wx.saveImageToPhotosAlbum({
            filePath: t,
            success: function(t) {},
            fail: function(t) {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || wx.showModal({
                            title: "温馨提示",
                            content: "保存海报需要您授权同意保存到相册",
                            success: function(t) {
                                t.confirm ? wx.openSetting({
                                    success: function(t) {}
                                }) : t.cancel;
                            }
                        });
                    }
                });
            }
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