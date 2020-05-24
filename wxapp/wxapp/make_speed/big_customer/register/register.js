var _home = require("../../../modules/home"), _address = require("../../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        imgs: "",
        img_temp: [],
        photo_temp: [],
        jyxkz: "",
        yyzz: "",
        address: "",
        lat: 0,
        lng: 0,
        address_name: "",
        tel: "",
        name: "",
        city: "",
        ele_id: ""
    },
    onLoad: function(t) {
        1 == t.type && this.getInfo();
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    onHide: function() {},
    backStep: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    confirm: function(t) {
        var e = t.detail.value, a = this.data.address, i = this.data.lat, n = this.data.lng, s = this.data.jyxkz, o = this.data.yyzz, d = this.data.imgs, l = this.data.city;
        return e.name ? e.tel ? e.address ? i && n && a ? s ? o ? d ? void homeModule.businessAdd({
            name: e.name,
            phone: e.tel,
            address: e.address,
            ele_id: e.ele_id,
            lat: i,
            lng: n,
            img1: o,
            img2: s,
            imgs: d,
            city: l
        }).then(function(t) {
            app.hint("提交成功，请等待审核~"), setTimeout(function() {
                wx.navigateBack({
                    delta: 2
                });
            }, 500);
        }, function(t) {}) : app.hint("请上传商铺实景图~") : app.hint("请上传营业执照~") : app.hint("请上传经营许可证~") : app.hint("请选择公司定位~") : app.hint("请输入公司地址~") : app.hint("请输入联系电话~") : app.hint("请输入公司名~");
    },
    getInfo: function() {
        var a = this;
        homeModule.businessInfo().then(function(t) {
            var e = [];
            e[0] = t.license_img1s, e[1] = t.license_img2s, a.setData({
                address_name: t.address,
                address: t.address,
                imgs: t.imgs,
                img_temp: t.imgs1,
                jyxkz: t.license_img1,
                yyzz: t.license_img2,
                photo_temp: e,
                name: t.name,
                tel: t.phone,
                lat: t.lat,
                lng: t.lng,
                city: t.city || "",
                ele_id: t.ele_id || ""
            });
        }, function(t) {});
    },
    location: function() {
        var e = this;
        wx.chooseLocation({
            success: function(t) {
                e.setData({
                    address: t.address,
                    lat: t.latitude,
                    lng: t.longitude
                }), addressModule.getCity(t.latitude, t.longitude, 1, app.globalData.syStem.tencent_key).then(function(t) {
                    e.setData({
                        city: t
                    });
                }, function(t) {}), console.log(t);
            }
        });
    },
    photo: function(t) {
        var e = this, a = t.currentTarget.dataset.idx;
        wx.chooseImage({
            count: 1,
            sizeType: "compressed",
            sourceType: [ "album", "camera" ],
            success: function(t) {
                e.uploadImg(t.tempFilePaths, 0, a, 1);
            }
        });
    },
    photoFrom: function(t) {
        var i = this;
        wx.chooseImage({
            count: 9,
            sizeType: "compressed",
            sourceType: [ "album", "camera" ],
            success: function(t) {
                var e = i.data.img_temp, a = i.data.img_temp.length;
                if (e && 9 < a + t.tempFilePaths.length) return app.hint("最多只能上传9张~");
                e = a ? e.concat(t.tempFilePaths) : t.tempFilePaths, i.setData({
                    img_temp: e
                }), i.uploadImg(e, a);
            }
        });
    },
    delImg: function(t) {
        var e = t.currentTarget.dataset.idx, a = this.data.img_temp, i = this.data.imgs;
        1 == a.length ? (a = [], i = "") : (a.splice(e, 1), (i = i.split(",")).splice(e, 1), 
        i = i.join(",")), this.setData({
            img_temp: a,
            imgs: i
        });
    },
    uploadImg: function(n) {
        var s = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0, o = this, d = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0, l = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : 0, t = app.util.url("entry/wxapp/uploadImage", {
            m: "make_speed"
        });
        wx.uploadFile({
            url: t,
            filePath: n[s],
            header: {
                "Content-Type": "multipart/form-data"
            },
            name: "file",
            formData: {
                user: "test"
            },
            success: function(t) {
                console.log(s);
                var e = JSON.parse(t.data);
                if (1 == l) {
                    var a = o.data.photo_temp;
                    return a[d] = n, o.setData({
                        photo_temp: a
                    }), void (0 == d ? o.setData({
                        yyzz: e.path
                    }) : o.setData({
                        jyxkz: e.path
                    }));
                }
                var i = 0 == s ? e.path : o.data.imgs + "," + e.path;
                o.setData({
                    imgs: i
                });
            },
            fail: function(t) {
                console.log("上传失败" + s);
            },
            complete: function() {
                1 != l && (s == n.length - 1 ? console.log("上传成功") : o.uploadImg(n, ++s, 0, 0));
            }
        });
    },
    preImg: function(t) {
        var e = this.data.img_temp;
        wx.previewImage({
            current: e[t.currentTarget.dataset.idx],
            urls: e
        });
    },
    onUnload: function() {}
});