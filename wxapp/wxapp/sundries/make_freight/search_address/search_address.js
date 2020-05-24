var _address = require("../../../modules/address.js"), addressModel = new _address.address(), app = getApp();

Page({
    data: {
        address_list: [],
        search: !1,
        no_search: !0,
        id: 0,
        no_data: !0,
        search_value: "",
        city: "",
        address_type: 0,
        img_url: app.globalData.img_url
    },
    onLoad: function(t) {
        this.setData({
            address_type: wx.getStorageSync("address_type")
        });
        var e = wx.getStorageSync("history_list");
        this.setData({
            address_list: e
        });
    },
    onShow: function() {
        this.getCityName();
    },
    getCityName: function() {
        var e = this, a = wx.getStorageSync("cityName");
        a ? this.setData({
            city: a
        }) : addressModel.getCurrentCityMessage().then(function(t) {
            a = t[0].ad_info.city || t[1].ad_info.city, e.setData({
                city: a
            }), wx.setStorageSync("cityName", a), wx.setStorageSync("localCity", a);
        }, function(t) {});
    },
    selectCity: function() {
        wx.navigateTo({
            url: "../selectCity/selectCity"
        });
    },
    clear: function() {
        this.setData({
            search_value: ""
        });
    },
    searchAddress: function(t) {
        var e = this, a = t.detail.value, s = wx.getStorageSync("cityName");
        a && addressModel.getAddress(a, s, app.globalData.syStem.tencent_key).then(function(t) {
            e.setData({
                address_list: t,
                search: !1,
                no_search: !0,
                no_data: !0
            });
        }, function(t) {});
    },
    confirm: function(t) {
        var e = t.currentTarget.dataset.sid, a = this.data.address_type, s = this.data.address_list;
        addressModel.confirm(s[e], a), wx.navigateBack({
            delta: 1
        });
    },
    onReady: function() {
        app.setNavigation();
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