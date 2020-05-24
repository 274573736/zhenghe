var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        id: 0,
        address: "",
        content: "",
        skin: 0,
        name: "",
        phone: "",
        des: "",
        have_phone: 0,
        is_phone: 0
    },
    onLoad: function(e) {
        var t = e.skin || 0, a = e.id || 0, n = e.is_phone || 0;
        this.setData({
            skin: t,
            id: a,
            is_phone: n
        });
    },
    onReady: function() {
        app.setNavigation(), this.checkPhone();
    },
    onShow: function() {
        this.examineAddress();
    },
    checkPhone: function() {
        var e = app.globalData.syStem.user_mobile;
        e || (e = wx.getStorageSync("phone")), e && this.setData({
            have_phone: e
        });
    },
    getPhoneNumber: function(e) {
        var t = this, a = e.currentTarget.dataset.phone;
        if (0 == a) {
            var n = e.detail.encryptedData, o = e.detail.iv;
            homeModule.getUserPhone({
                encryptedData: n,
                iv: o
            }).then(function(e) {
                e && e.phoneNumber && (t.setData({
                    have_phone: e.phoneNumber,
                    phone: e.phoneNumber
                }), app.globalData.syStem.user_mobile = e.phoneNumber, wx.setStorageSync("phone", e.phoneNumber));
            }, function(e) {});
        } else this.setData({
            phone: a
        });
    },
    nameInput: function(e) {
        this.setData({
            name: e.value
        });
    },
    desInput: function(e) {
        this.setData({
            des: e.value
        });
    },
    phoneInput: function(e) {
        this.setData({
            phone: e.value
        });
    },
    examineAddress: function() {
        var e = {}, t = "";
        if (0 == this.data.id ? (e = wx.getStorageSync("fahuo"), t = wx.getStorageSync("fahuo_temporary")) : (e = wx.getStorageSync("shouhuo"), 
        t = wx.getStorageSync("shouhuo_temporary")), e || t) {
            if (!e && t) e = t; else if (e && t && e.id == t.id || e && !t) ; else {
                if (!e || !t || e.id == t.id) return void (app.globalData.address_title_change = !0);
                e.title = t.title;
            }
            if (!app.globalData.address_title_change) return app.globalData.address_title_change = !0, 
            void this.setData({
                address: e
            });
            0 == this.data.id && !e.person_tel && app.globalData.syStem.user_mobile && (e.person_tel = app.globalData.syStem.user_mobile), 
            this.setData({
                address: e,
                name: e.person_name || this.data.name,
                des: e.person_address || this.data.des,
                phone: e.person_tel || this.data.phone
            });
        } else app.globalData.address_title_change = !0;
    },
    submit: function(o) {
        var s = this;
        app.setFormId(o.detail.formId), app.getApplicationIsAuth().then(function(e) {
            if (1 == e) {
                var t = o.detail.value;
                if ("" == t.tel) return app.hint("联系电话不能为空~");
                if (!/^1(3|4|5|6|7|8|9)\d{9}$/.test(t.tel)) return app.hint("请填写正确的手机号~");
                var a = null, n = s.data.id;
                if (!(a = 0 == n ? wx.getStorageSync("fahuo_temporary") : wx.getStorageSync("shouhuo_temporary"))) return app.hint("请选择地址~");
                if ("" == t.address && (t.address = "电话联系"), a.person_name = t.name, a.person_tel = t.tel, 
                a.person_address = t.address, app.delRepeat(a, 0, n), 0 == n ? wx.setStorageSync("fahuo", a) : wx.setStorageSync("shouhuo", a), 
                0 < s.data.skin) return void app.toTwoUrl(0);
                wx.navigateBack({
                    delta: 1
                });
            }
        }, function(e) {});
    },
    bindchange: function(e) {
        this.setData({
            content: e.detail.value
        });
    },
    confirm: function() {
        var e = this.data.content.trim(), t = /1(3|4|5|6|7|8|9)\d{9}/.exec(e);
        if (!t) return app.hint("识别不到电话~");
        if (t[0]) {
            var a = e.replace(/\s+/g, ""), n = a.split(",") || a.split("，");
            if (3 != n.length && (n = a.split("，")), 3 == n.length ? console.log(1) : 3 == e.split("/s+/").length ? (console.log(2), 
            n = e.split("/s+/")) : 2 == a.split(t[0]).length && (console.log(3), (n = a.split(t[0])).push(t[0])), 
            3 != n.length) return app.hint("识别失败~");
            if (!this.save(n)) return app.hint("识别失败~");
        }
    },
    save: function(e) {
        var t = /1(3|4|5|6|7|8|9)\d{9}/, a = "", n = "";
        console.log(e);
        for (var o = 0; o < 3; o++) if (t.test(e[o])) {
            if (console.log("进了"), 0 == o ? (a = e[1].length > e[2].length ? e[1] : e[2], n = e[1].length < e[2].length ? e[1] : e[2]) : 1 == o ? (a = e[0].length > e[2].length ? e[0] : e[2], 
            n = e[0].length < e[2].length ? e[0] : e[2]) : (a = e[1].length > e[0].length ? e[1] : e[0], 
            n = e[1].length < e[0].length ? e[1] : e[0]), 0 == this.data.id) {
                var s = wx.getStorageSync("fahuo");
                s.name || (s = {}), s.person_address = a, s.person_name = n, s.person_tel = e[o], 
                wx.setStorageSync("fahuo", s);
            } else {
                var r = wx.getStorageSync("shouhuo");
                r.name || (r = {}), r.person_address = a, r.person_name = n, r.person_tel = e[o], 
                wx.setStorageSync("shouhuo", r);
            }
            return this.examineAddress(), wx.navigateTo({
                url: "/make_speed/search_address/search_address?id=" + this.data.id + "&content=" + a + "&recognition=1"
            }), a;
        }
        return !1;
    },
    topMap: function() {
        app.globalData.address_title_change = !1, wx.navigateTo({
            url: "../address_map/address_map?id=" + this.data.id
        });
    },
    oftenAddress: function(e) {
        var t = 0;
        1 == this.data.id && (t = 1), wx.navigateTo({
            url: "../address_resort/address_resort?type=" + t
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