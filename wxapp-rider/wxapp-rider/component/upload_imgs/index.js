var app = getApp();

Component({
    properties: {
        order_id: {
            type: Number
        },
        type: {
            type: Number
        },
        img_temp_arr: {
            type: Array,
            observer: function(t, e) {
                if (0 < t.length && 0 == this.data.type && !this.data.img_temp[0]) {
                    var a = this.data.img_temp || [];
                    a[0] = t, this.setData({
                        img_temp: a
                    });
                }
            }
        },
        imgs_string: {
            type: String,
            observer: function(t, e) {
                if (t && 0 == this.data.type && !this.data.imgs[0]) {
                    var a = this.data.imgs || [];
                    a[0] = t, this.setData({
                        imgs: a
                    });
                }
            }
        }
    },
    data: {
        img_temp: [],
        imgs: []
    },
    methods: {
        photoFrom: function(t) {
            var i = this, r = this.data.order_id;
            wx.chooseImage({
                count: 4,
                sizeType: "compressed",
                sourceType: [ "album", "camera" ],
                success: function(t) {
                    var e = i.data.img_temp[r], a = e ? e.length : 0;
                    if (e && 4 < a + t.tempFilePaths.length) return app.hint("最多只能上传4张~");
                    i.uploadImg(t.tempFilePaths, 0, r);
                }
            });
        },
        uploadImg: function(s) {
            var p = this, m = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0, g = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0, t = app.util.url("entry/wxapp/uploadImage", {
                m: "make_rider"
            });
            wx.uploadFile({
                url: t,
                filePath: s[m],
                header: {
                    "Content-Type": "multipart/form-data"
                },
                name: "file",
                success: function(t) {
                    var e = JSON.parse(t.data), a = p.data.imgs;
                    a[g] || (a[g] = []), a[g] = 0 == a[g].length ? e.path : a[g] + "," + e.path;
                    var i = p.data.img_temp;
                    if (i[g] || (i[g] = []), i[g].push(s[m]), p.setData({
                        imgs: a,
                        img_temp: i
                    }), m == s.length - 1) {
                        var r = p.data.type;
                        p.triggerEvent("uploadImgs", {
                            imgs: a[g],
                            order_id: g,
                            type: r
                        }, {});
                    }
                },
                fail: function(t) {
                    console.log("上传失败" + m);
                },
                complete: function() {
                    m == s.length - 1 ? console.log("上传成功") : p.uploadImg(s, ++m, g);
                }
            });
        },
        delImg: function(t) {
            var e = this.data.order_id, a = t.currentTarget.dataset.idx, i = this.data.img_temp, r = this.data.imgs;
            1 == i[e].length ? (i[e] = [], r[e] = "") : (i[e].splice(a, 1), r[e] = r[e].split(","), 
            r[e].splice(a, 1), r[e] = r[e].join(",")), this.setData({
                img_temp: i,
                imgs: r
            });
            var s = this.data.type;
            this.triggerEvent("uploadImgs", {
                imgs: r[e],
                order_id: e,
                type: s
            }, {});
        },
        preImg: function(t) {
            var e = this.data.order_id, a = this.data.img_temp[e];
            wx.previewImage({
                current: a[t.currentTarget.dataset.idx],
                urls: a
            });
        }
    }
});