var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        address: {},
        address_type: 0,
        name: "",
        phone: "",
        des: "",
        skin: 0,
        have_phone: 0,
        is_all: 0,
        is_phone: 0
    },
    onLoad: function(e) {
        var a = e.skin || 0, t = e.id || 0, s = e.is_all || 0, n = e.is_phone || 0;
        this.setData({
            skin: a,
            address_type: t,
            is_all: s,
            is_phone: n
        });
    },
    onReady: function() {
        app.setNavigation(), this.checkPhone();
    },
    onShow: function() {
        this.examineAddress();
    },
    oftenAddress: function(e) {
        var a = 0;
        1 == this.data.address_type && (a = 1), wx.navigateTo({
            url: "../address_resort/address_resort?type=" + a
        });
    },
    checkPhone: function() {
        var e = app.globalData.syStem.user_mobile;
        e || (e = wx.getStorageSync("phone")), e && this.setData({
            have_phone: e
        });
    },
    getPhoneNumber: function(e) {
        var a = this, t = e.currentTarget.dataset.phone;
        if (0 == t) {
            var s = e.detail.encryptedData, n = e.detail.iv;
            homeModule.getUserPhone({
                encryptedData: s,
                iv: n
            }).then(function(e) {
                e && e.phoneNumber && ((a.data.address || {}).person_tel = e.phoneNumber, a.setData({
                    phone: e.phoneNumber,
                    have_phone: e.phoneNumber
                }), app.globalData.syStem.user_mobile = e.phoneNumber, wx.setStorageSync("phone", e.phoneNumber));
            }, function(e) {});
        } else this.setData({
            phone: t
        });
    },
    confirm: function(n) {
        var o = this;
        app.setFormId(n.detail.formId), app.getApplicationIsAuth().then(function(e) {
            if (1 == e) {
                var a = n.detail.value, t = o.data.is_all, s = o.data.address;
                if (!s) return app.hint("地址不能为空~");
                if (1 == t && !a.phone) return app.hint("联系电话不能为空~");
                if (1 == t && !/^1(3|4|5|6|7|8|9)\d{9}$/.test(a.phone)) return app.hint("请填写正确的手机号~");
                if (s.person_name = a.name, s.person_tel = a.phone || o.data.phone, s.person_address = a.des, 
                a.des || (s.person_address = "电话联系"), 0 == o.data.address_type ? wx.setStorageSync("fahuo", s) : wx.setStorageSync("shouhuo", s), 
                a.phone && app.delRepeat(s, 0, o.data.address_type), 0 < o.data.skin) return void app.toTwoUrl(1);
                wx.navigateBack({
                    delta: 1
                });
            }
        }, function(e) {});
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
    examineAddress: function(e) {
        var a = {}, t = "", s = wx.getStorageSync("address_type");
        if (0 == s ? (a = wx.getStorageSync("fahuo"), t = wx.getStorageSync("fahuo_temporary")) : (a = wx.getStorageSync("shouhuo"), 
        t = wx.getStorageSync("shouhuo_temporary")), a || t) {
            if (!a && t) a = t; else if (a && t && a.id == t.id || a && !t) ; else {
                if (!a || !t || a.id == t.id) return void (app.globalData.address_title_change = !0);
                t.person_tel = a.person_tel, t.person_name = a.person_name, t.person_address = a.person_address, 
                a = t;
            }
            if (!app.globalData.address_title_change || e && e.detail && 1 == e.detail.is_change) return app.globalData.address_title_change = !0, 
            void this.setData({
                address: a
            });
            0 == s && 1 == this.data.is_all && !a.person_tel && app.globalData.syStem.user_mobile && (a.person_tel = app.globalData.syStem.user_mobile), 
            this.setData({
                address: a,
                name: a.person_name || this.data.name,
                des: a.person_address || this.data.des,
                phone: a.person_tel || this.data.phone
            });
        } else app.globalData.address_title_change = !0;
    },
    searchAddress: function() {
        var e = this.data.address_type;
        wx.navigateTo({
            url: "../search_address/search_address?id=" + e + "&driver_id=1"
        });
    },
    onHide: function() {},
    onUnload: function() {}
});