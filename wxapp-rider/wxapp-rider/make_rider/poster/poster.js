var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        height: 0,
        width: 0,
        poster: ""
    },
    onLoad: function(e) {
        var r = this;
        app.setNavigation();
        var t = wx.getSystemInfoSync(), o = t.screenWidth, a = t.screenHeight;
        this.factor = o / 750;
        var n = this.toRpx(o) - 100, i = this.toRpx(a) - 400, s = this.toPx(n), c = 3 * s / 2;
        this.setData({
            height: i,
            width: n,
            widthPx: s,
            heightPx: c
        }), homeModule.getRiderCode().then(function(e) {
            wx.showLoading({
                title: "加载中"
            });
            var t = wx.getStorageSync("userInfo"), o = t.wxInfo.avatarUrl, n = t.wxInfo.nickName, a = homeModule.developFile(o), i = homeModule.developFile(e);
            Promise.all([ a, i ]).then(function(e) {
                var t = wx.createCanvasContext("poster");
                t.drawImage(wx.getStorageSync("rider_bg_img"), 0, 0, s, c), t.setTextAlign("center"), 
                t.setFillStyle("#ffffff"), t.font = "normal bold 15px normal", t.fillText(n, s / 2, c - 210 / 325 * s), 
                t.save(), t.beginPath();
                var o = 50 / 325 * s / 2;
                t.arc(s - 163 / 325 * s, c - 281 / 325 * s, o, 0, 2 * Math.PI), t.strokeStyle = "#ffe200", 
                t.clip(), t.drawImage(e[0], s - 188 / 325 * s, c - 306 / 325 * s, 2 * o, 2 * o), 
                t.restore();
                var a = 70 / 325 * s / 2;
                t.arc(s - 67 / 325 * s, c - 49 / 325 * s, a, 0, 2 * Math.PI), t.strokeStyle = "#ffe200", 
                t.clip(), t.drawImage(e[1], s - 102 / 325 * s, c - 84 / 325 * s, 2 * a, 2 * a), 
                t.draw(), wx.hideLoading(), setTimeout(function() {
                    wx.canvasToTempFilePath({
                        canvasId: "poster",
                        success: function(e) {
                            r.setData({
                                poster_url: e.tempFilePath
                            });
                        },
                        fail: function(e) {
                            console.log(e);
                        }
                    });
                }, 200);
            });
        }, function(e) {});
    },
    toPx: function(e) {
        return e * this.factor;
    },
    toRpx: function(e) {
        return e / this.factor;
    },
    onReady: function() {},
    saveImg: function() {
        var e = this.data.poster_url;
        e && wx.saveImageToPhotosAlbum({
            filePath: e,
            success: function(e) {
                console.log(e);
            },
            fail: function(e) {
                wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.writePhotosAlbum"] || wx.showModal({
                            title: "温馨提示",
                            content: "保存海报需要您授权同意保存到相册",
                            success: function(e) {
                                e.confirm ? wx.openSetting({
                                    success: function(e) {}
                                }) : e.cancel;
                            }
                        });
                    }
                });
            }
        });
    },
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