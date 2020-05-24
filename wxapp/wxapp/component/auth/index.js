var _setting = require("../../modules/setting"), _home = require("../../modules/home"), homeModule = new _home.home(), settingModule = new _setting.setting(), app = getApp();

Component({
    properties: {
        is_login: {
            type: Boolean
        }
    },
    data: {
        logo: ""
    },
    lifetimes: {
        attached: function() {
            this.setData({
                logo: app.globalData.syStem.user_auth_bg
            });
        }
    },
    methods: {
        noLogin: function() {
            this.triggerEvent("authBtn", {}, {});
        },
        userMessage: function(n) {
            var o = this;
            settingModule.auth(0).then(function(e) {
                if (e) return app.hint("登录成功~"), void app.util.getUserInfo(function(e) {
                    if (e) {
                        var t = wx.getStorageSync("userInfo");
                        t && (t.wxInfo = n.detail.userInfo || "", wx.setStorageSync("userInfo", t)), o.saveUser(n.detail.userInfo);
                    }
                });
                o.triggerEvent("authBtn", {}, {});
            }, function(e) {});
        },
        getUserId: function() {
            var t = this;
            homeModule.getUserId().then(function(e) {
                t.triggerEvent("authBtn", {
                    uid: e.user_id
                }, {}), app.globalData.user_id = e.user_id;
            }, function(e) {});
        },
        saveUser: function(e) {
            var t = this, n = wx.getStorageSync("recommend_id") || 0, o = wx.getStorageSync("rider_id") || 0;
            homeModule.login({
                nickName: e.nickName,
                avatarUrl: e.avatarUrl,
                sex: e.gender,
                recommend_id: n,
                rider_id: o
            }).then(function(e) {
                wx.removeStorageSync("recommend_id"), wx.removeStorageSync("rider_id"), t.getUserId(), 
                (0 != n && 1 == e.status || 0 != o && 1 == e.status) && wx.navigateTo({
                    url: "/make_speed/new_person/new_person"
                });
            });
        }
    }
});