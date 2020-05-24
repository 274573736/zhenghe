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
            this.triggerEvent("authBtn", {
                auth: !1
            }, {});
        },
        userMessage: function(n) {
            var t = this;
            settingModule.auth(0).then(function(e) {
                if (e) return t.triggerEvent("authBtn", {
                    auth: !0
                }, {}), app.globalData.userAuth = 1, void app.util.getUserInfo(function(e) {
                    if (e) {
                        var t = wx.getStorageSync("userInfo");
                        t && (t.wxInfo = n.detail.userInfo || "", wx.setStorageSync("userInfo", t), homeModule.updateRiderInfo({
                            nickName: n.detail.userInfo.nickName,
                            avatarUrl: n.detail.userInfo.avatarUrl,
                            sex: n.detail.userInfo.gender
                        }).then(function(e) {}, function(e) {}));
                    }
                });
                t.triggerEvent("authBtn", {
                    auth: !1
                }, {}), app.hint("授权失败~");
            }, function(e) {});
        }
    }
});