var _home = require("../../modules/home"), _setting = require("../../modules/setting"), homeModule = new _home.home(), settingModule = new _setting.setting(), app = getApp();

Page({
    data: {
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
        var e = this;
        settingModule.auth(0).then(function(t) {
            t && (e.setData({
                auth: !0
            }), e.avatarInit());
        }, function(t) {}), homeModule.getShareInvite().then(function(t) {
            e.setData({
                list: t
            });
        }, function(t) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
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
        var o = this, t = wx.getSystemInfoSync(), e = t.screenWidth, a = t.screenHeight;
        this.factor = e / 750;
        var i = this.toRpx(e) - 200;
        this.width = i;
        var s = this.toRpx(a) - 400, r = this.toPx(i, !0), l = 3 * r / 2, n = wx.getStorageSync("userInfo"), u = n.wxInfo.avatarUrl, h = n.wxInfo.nickName, c = homeModule.getCode(), d = homeModule.getPoster();
        Promise.all([ c, d ]).then(function(t) {
            var e = homeModule.developFile(u), a = homeModule.developFile(t[0]), n = homeModule.developFile(t[1].img_url);
            Promise.all([ e, a, n ]).then(function(t) {
                o.setData({
                    head_url: t[0],
                    code_url: t[1],
                    bj_url: t[2],
                    nickname: h,
                    height: s,
                    width: i,
                    widthPx: r,
                    heightPx: l,
                    isPoster: 1
                });
            }, function(t) {});
        }, function(t) {});
    },
    poster: function() {
        var o = this, i = setInterval(function() {
            if (1 == o.data.isPoster) {
                clearInterval(i);
                var t = o.data.widthPx, e = o.data.heightPx, a = wx.createCanvasContext("poster");
                a.drawImage(o.data.bj_url, 0, 0, t, e), a.setTextAlign("center"), a.setFillStyle("#ffffff"), 
                a.font = "normal bold 15px normal", a.fillText(o.data.nickname, t / 2, o.toPx(840)), 
                a.save(), a.beginPath();
                var n = o.toPx(185);
                a.arc(o.toPx(385), o.toPx(555), n, 0, 2 * Math.PI), a.clip(), a.drawImage(o.data.code_url, o.toPx(200), o.toPx(370), 2 * n, 2 * n), 
                a.draw(), wx.hideLoading(), setTimeout(function() {
                    wx.canvasToTempFilePath({
                        canvasId: "poster",
                        success: function(t) {
                            o.setData({
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
    writeFont: function(t, e, a, n, o, i) {
        t.setFillStyle(a), t.font = n, t.fillText(e, o, i), t.save(), t.beginPath();
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