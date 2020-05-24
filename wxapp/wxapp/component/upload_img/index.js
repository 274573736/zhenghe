var app = getApp();

Component({
    properties: {
        img_temp: {
            type: Array
        },
        imgs: {
            type: String
        }
    },
    data: {},
    methods: {
        photoFrom: function(t) {
            var i = this;
            wx.chooseImage({
                count: 9,
                sizeType: "compressed",
                sourceType: [ "album", "camera" ],
                success: function(t) {
                    wx.showLoading({
                        title: "上传中"
                    });
                    var e = i.data.img_temp, a = i.data.img_temp.length;
                    if (e && 9 < a + t.tempFilePaths.length) return app.hint("最多只能上传9张~");
                    e = a ? e.concat(t.tempFilePaths) : t.tempFilePaths, i.uploadImg(e, a);
                }
            });
        },
        delImg: function(t) {
            wx.showLoading({
                title: "加载中"
            });
            var e = t.currentTarget.dataset.idx, a = this.data.img_temp, i = this.data.imgs;
            1 == a.length ? (a = [], i = "") : (a.splice(e, 1), (i = i.split(",")).splice(e, 1), 
            i = i.join(",")), this.triggerEvent("imgUpload", {
                img_temp: a,
                imgs: i
            }, {}), wx.hideLoading();
        },
        uploadImg: function(i) {
            var o = this, p = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0, t = app.util.url("entry/wxapp/uploadImage", {
                m: "make_speed"
            });
            wx.uploadFile({
                url: t,
                filePath: i[p],
                header: {
                    "Content-Type": "multipart/form-data"
                },
                name: "file",
                success: function(t) {
                    console.log(p);
                    var e = JSON.parse(t.data), a = 0 == p ? e.path : o.data.imgs + "," + e.path;
                    o.triggerEvent("imgUpload", {
                        img_temp: i.slice(0, p + 1),
                        imgs: a
                    }, {}), i.length - 1 == p && wx.hideLoading();
                },
                fail: function(t) {
                    console.log("上传失败" + p), wx.hideLoading();
                },
                complete: function() {
                    p == i.length - 1 ? console.log("上传成功") : o.uploadImg(i, ++p);
                }
            });
        },
        preImg: function(t) {
            var e = this.data.img_temp;
            wx.previewImage({
                current: e[t.currentTarget.dataset.idx],
                urls: e
            });
        }
    }
});