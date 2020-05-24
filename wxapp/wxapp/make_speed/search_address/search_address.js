var _address = require("../../modules/address.js"), addressModel = new _address.address(), app = getApp();

Page({
    data: {
        address_list: [],
        id: 0,
        search_value: "",
        city: "",
        img_url: app.globalData.img_url,
        driver_id: 0,
        recognition: 0
    },
    onLoad: function(a) {
        var t = this, e = wx.getStorageSync("city"), i = wx.getStorageSync("local_city"), s = wx.getStorageSync("history_list");
        if (e && e == i) {
            var r = wx.getStorageSync("district");
            "县" == r.substr(r.length - 1, r.length) && (e = r);
        }
        var d = a.content || "";
        this.setData({
            id: a.id || 0,
            driver_id: a.driver_id ? a.driver_id : 0,
            city: e,
            address_list: s,
            search_value: d,
            recognition: a.recognition || 0
        }), d && addressModel.getAddress(d, e, app.globalData.syStem.tencent_key).then(function(a) {
            t.setData({
                address_list: a
            });
        }, function(a) {}), wx.setNavigationBarTitle({
            title: "地址搜索"
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    clear: function() {
        this.setData({
            search_value: ""
        });
    },
    searchAddress: function(a) {
        var t = this, e = a.detail.value, i = this.data.city;
        e && addressModel.getAddress(e, i, app.globalData.syStem.tencent_key).then(function(a) {
            t.setData({
                address_list: a
            });
        }, function(a) {});
    },
    confirm: function(a) {
        var t = a.currentTarget.dataset.sid, e = this.data.id, i = this.data.address_list;
        if (addressModel.confirm(i[t], e), 1 != this.data.recognition) return 0 < this.data.driver_id ? (app.globalData.search_address = 1, 
        void wx.navigateBack({
            delta: 1
        })) : void wx.navigateBack({
            delta: 2
        });
        wx.navigateBack({
            delta: 1
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