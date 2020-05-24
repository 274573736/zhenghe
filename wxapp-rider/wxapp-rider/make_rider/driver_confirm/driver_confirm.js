var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        date: "请选择日期",
        time_bg: !0,
        car_num: "",
        car_type: "",
        img_url: [],
        lose_photo: "",
        just_photo: "",
        time: 0,
        is_register: 0
    },
    onLoad: function(t) {
        var a = this;
        if (this.setData({
            is_register: t.is_register || 0
        }), app.setNavigation(), t.is_register) {
            var e = wx.getStorageSync("driver_info");
            e && this.historyData(e);
        } else homeModule.postDriver({
            info: 1
        }).then(function(t) {
            0 == res.status && a.historyData(t);
        }, function(t) {});
    },
    onReady: function() {},
    onShow: function() {},
    historyData: function(t) {
        var a = [];
        a[0] = t.card_img1, a[1] = t.card_img2, this.setData({
            just_photo: t.card_img_down1,
            lose_photo: t.card_img_down2,
            img_url: a,
            car_num: t.card_num,
            car_type: t.card_type,
            date: t.card_time
        });
    },
    confirm: function() {
        var e = this, t = this.data.img_url;
        if (!t[0] || !t[1]) return app.hint("请上传驾驶证~");
        var a = this.data.car_num;
        if (!a) return app.hint("请填写档案编号~");
        var i = this.data.car_type;
        if (!i) return app.hint("请填写准驾车型~");
        var r = this.data.date;
        if (!this.data.time) return app.hint("选择日期~");
        homeModule.postDriver({
            img_url: t.join(","),
            car_num: a,
            car_type: i,
            date: r
        }).then(function(t) {
            app.hint("提交成功~");
            var a = app.globalData.syStem;
            wx.requestSubscribeMessage({
                tmplIds: [ a.audit_rider_tpl ],
                success: function(t) {
                    setTimeout(function() {
                        1 != e.data.is_register ? wx.navigateBack({
                            delta: 2
                        }) : wx.navigateTo({
                            url: "../train/train"
                        });
                    }, 400);
                },
                fail: function(t) {}
            });
        }, function(t) {});
    },
    carPhoto: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        wx.chooseImage({
            count: 1,
            sizeType: "compressed",
            sourceType: [ "album", "camera" ],
            success: function(t) {
                0 == e ? a.setData({
                    just_photo: t.tempFilePaths
                }) : a.setData({
                    lose_photo: t.tempFilePaths
                }), a.uploadImg(e, t.tempFilePaths);
            }
        });
    },
    uploadImg: function(i, t) {
        var r = this, a = app.util.url("entry/wxapp/uploadImage", {
            m: "make_rider"
        });
        wx.uploadFile({
            url: a,
            filePath: t[0],
            header: {
                "Content-Type": "multipart/form-data"
            },
            name: "file",
            formData: {
                user: "test"
            },
            success: function(t) {
                var a = JSON.parse(t.data), e = r.data.img_url;
                e[i] = a.path, r.setData({
                    img_url: e
                });
            },
            fail: function(t) {},
            complete: function() {}
        });
    },
    carNum: function(t) {
        this.setData({
            car_num: t.detail.value
        });
    },
    carType: function(t) {
        this.setData({
            car_type: t.detail.value
        });
    },
    getDate: function() {
        this.setData({
            time_bg: !1
        });
    },
    confirmDate: function(t) {
        1 == t.detail.select ? this.setData({
            date: t.detail.time,
            time_bg: !0,
            time: 1
        }) : this.setData({
            time_bg: !0
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