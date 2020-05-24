var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        car_arr: [],
        img_url: [],
        car_num: "",
        is_register: 0,
        car_list: [],
        just_photo: "",
        lose_photo: "",
        is_update: 0
    },
    onLoad: function(t) {
        var o = this;
        app.setNavigation(), this.setData({
            is_register: t.is_register || 0
        }), homeModule.getCar().then(function(t) {
            o.setData({
                car_list: t
            }), homeModule.freightDriverInfo().then(function(t) {
                if (t && t.car_img) {
                    var a = [];
                    a[0] = t.drivers_license.split("public")[1] || 0, a[1] = t.car_img.split("public")[1] || "";
                    var e = t.car_id, i = [];
                    if (e && -1 != e.indexOf(",")) for (var r = e.split(","), n = 0; n < r.length; n++) i[r[n]] = !0; else i[e] = !0;
                    o.setData({
                        img_url: a,
                        just_photo: t.drivers_license,
                        lose_photo: t.car_img,
                        car_num: t.plate_number,
                        is_update: 1,
                        car_arr: i
                    });
                }
            }, function(t) {});
        }, function(t) {});
    },
    onReady: function() {},
    onShow: function() {},
    selectCar: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.car_arr;
        e[a] = !e[a], this.setData({
            car_arr: e
        });
    },
    carNum: function(t) {
        this.setData({
            car_num: t.detail.value
        });
    },
    confirm: function() {
        var e = this, t = this.data.img_url;
        if (!t[0]) return app.hint("请上传行驶证~");
        if (!t[1]) return app.hint("请上传车辆正面照~");
        var a = this.data.car_arr, i = [];
        if (a <= 0) return app.hint("请选择车辆类型~");
        if (a.forEach(function(t, a) {
            t && i.push(a);
        }), i.length <= 0) return app.hint("请选择车辆类型~");
        i = i.join();
        var r = this.data.car_num;
        if (!r) return app.hint("请填写车牌号码~");
        homeModule.freightDriver({
            drivers_license: t[0],
            car_img: t[1],
            plate_number: r,
            car_id: i,
            is_update: this.data.is_update
        }).then(function(t) {
            var a = app.globalData.syStem;
            app.hint("提交成功~"), wx.requestSubscribeMessage({
                tmplIds: [ a.audit_rider_tpl ],
                success: function(t) {
                    e.setData({
                        is_update: 1
                    }), setTimeout(function() {
                        1 != e.data.is_register ? wx.navigateBack({
                            delta: 1
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
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});