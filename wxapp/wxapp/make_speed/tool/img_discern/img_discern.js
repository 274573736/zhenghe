var _home = require("../../../modules/home"), _setting = require("../../../modules/setting"), app = getApp(), settingModule = new _setting.setting(), homeModule = new _home.home();

Page({
    data: {
        temp_img: "",
        is_auth: 1
    },
    onLoad: function(t) {},
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.isAuth();
    },
    onHide: function() {},
    isAuth: function() {
        var e = this;
        1 != this.data.is_auth && settingModule.auth(4).then(function(t) {
            t && e.setData({
                is_auth: 1
            });
        }, function(t) {});
    },
    cancleBtn: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    photoBtn: function() {
        var e = this;
        1 == this.data.is_auth ? wx.createCameraContext().takePhoto({
            quality: "high",
            success: function(t) {
                console.log(t.tempImagePath), console.log(e), e.setData({
                    temp_img: t.tempImagePath
                });
            }
        }) : this.setLocationAuth();
    },
    imgBtn: function() {
        var e = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                console.log(t.tempFilePaths), e.setData({
                    temp_img: t.tempFilePaths[0]
                });
            }
        });
    },
    cameraError: function() {
        this.setData({
            is_auth: 0
        }), this.setLocationAuth();
    },
    setLocationAuth: function() {
        wx.showModal({
            title: "名片识别",
            content: "需要开启拍照权限才能使用名片识别功能",
            success: function(t) {
                t.confirm ? wx.openSetting({
                    success: function(t) {}
                }) : t.cancel;
            }
        });
    },
    rephotograph: function() {
        this.setData({
            temp_img: ""
        });
    },
    confirmPhoto: function() {
        var t = this.data.temp_img;
        if (!t) return app.hint("识别失败，请重试~");
        var e = app.util.url("entry/wxapp/uploadImage", {
            m: "make_speed"
        });
        wx.uploadFile({
            url: e,
            filePath: t,
            header: {
                "Content-Type": "multipart/form-data"
            },
            name: "file",
            success: function(t) {
                var e = JSON.parse(t.data);
                console.log(e.path), app.hint("识别中……");
            },
            fail: function(t) {
                console.log("上传失败" + i);
            }
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});