var _home = require("../../modules/home"), app = getApp(), homeModule = new _home.home();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        sex: -1,
        name: "",
        address_detail: "",
        photos: [],
        upload_photos: [],
        img_url: app.globalData.imgUrl,
        business_idx: 0,
        business_type: "",
        business: [ "跑腿骑手", "代驾", "货运司机" ]
    },
    onLoad: function(e) {
        app.setNavigation(), this.businessType(), this.msg();
    },
    businessType: function() {
        var i = this;
        homeModule.businessType().then(function(e) {
            for (var t = "", a = 0; a < e.length; a++) if (e[a].status) {
                t = e[a].cname;
                break;
            }
            i.setData({
                business: e,
                business_type: t
            });
        }, function(e) {});
    },
    selectBusiness: function(e) {
        this.setData({
            business_type: e.currentTarget.dataset.type,
            business_idx: e.currentTarget.dataset.idx
        });
    },
    msg: function() {
        var i = this;
        homeModule.riderAuth({
            riderinfo: 1
        }).then(function(e) {
            var t = [], a = [];
            t[0] = e.cards1_img, a[0] = e.card1_img, t[1] = e.cards2_img, a[1] = e.card2_img, 
            t[2] = e.cards3_img, a[2] = e.card3_img, t[3] = e.cards4_img, a[3] = e.card4_img, 
            i.setData({
                sex: e.sex,
                idcard: e.card_code,
                name: e.real_name,
                address_detail: e.address,
                photos: t,
                upload_photos: a
            });
        }, function(e) {});
    },
    selectSex: function(e) {
        var t = e.currentTarget.dataset.id;
        this.setData({
            sex: t
        });
    },
    photoFrom: function(e) {
        var i = this, r = e.currentTarget.dataset.id;
        wx.chooseImage({
            count: 1,
            sizeType: "compressed",
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var t = i.data.photos, a = e.tempFilePaths[0];
                t[r] = a, i.uploadImg(a, r), i.setData({
                    photos: t
                });
            }
        });
    },
    form: function(e) {
        var a = this, t = e.detail.value.name, i = e.detail.value.idcard, r = e.detail.value.address_detail, s = this.data.sex, n = this.data.photos;
        if (!t) return app.hint("姓名不能为空");
        if (-1 == s) return app.hint("性别未选择");
        if (!i) return app.hint("身份证号码不能为空");
        if (!/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(i)) return app.hint("身份证号码输入有误");
        if (!r) return app.hint("地址不能为空");
        if (!n[0]) return app.hint("身份证正面未上传");
        if (!n[1]) return app.hint("身份证反面未上传");
        if (!n[2]) return app.hint("手持身份证照片未上传");
        if (!n[3]) return app.hint("个人自拍照未上传");
        var o = this.data.upload_photos;
        o = o.join(","), homeModule.riderAuth({
            name: t,
            sex: s,
            idcard: i,
            address_detail: r,
            upload_photos: o
        }).then(function(e) {
            var t = "../train/train";
            t = "dj" == a.data.business_type ? "/make_rider/driver_confirm/driver_confirm?is_register=1" : "hy" == a.data.business_type ? "/make_rider/driver_freight/driver_freight?is_register=1" : "jz" == a.data.business_type ? "/make_rider/driver_homemaking/driver_homemaking?is_register=1" : "../train/train", 
            wx.navigateTo({
                url: t
            });
        }, function(e) {});
    },
    uploadImg: function(e, i) {
        var r = this, t = app.util.url("entry/wxapp/uploadImage", {
            m: "make_rider"
        });
        wx.uploadFile({
            url: t,
            filePath: e,
            header: {
                "Content-Type": "multipart/form-data"
            },
            name: "file",
            formData: {
                user: "test"
            },
            success: function(e) {
                var t = JSON.parse(e.data), a = r.data.upload_photos;
                a[i] = t.path, r.setData({
                    upload_photos: a
                });
            },
            fail: function(e) {},
            complete: function() {}
        });
    },
    onReady: function() {},
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