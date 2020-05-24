var _setting = require("../../modules/setting"), settingModule = new _setting.setting(), app = getApp();

Component({
    properties: {
        type: {
            type: Number,
            value: 0
        },
        actual_payment: {
            type: Number
        },
        loading: {
            type: Boolean
        },
        order_type: {
            type: Number,
            value: 0
        },
        pay_method: {
            type: Number,
            value: 1
        }
    },
    data: {
        is_login: !0
    },
    methods: {
        topPrice: function() {
            wx.navigateTo({
                url: "/make_speed/price_des/price_des"
            });
        },
        authBtn: function() {
            this.setData({
                is_login: !0
            });
        },
        toOrder: function(t) {
            var i = this;
            settingModule.auth(0).then(function(e) {
                if (e) return app.setFormId(t.detail.formId), void i.triggerEvent("confirm", {}, {});
                i.setData({
                    is_login: !1
                });
            }, function(e) {});
        },
        toPay: function(e) {
            var t = this;
            if ("function" != typeof wx.requestSubscribeMessage) settingModule.auth(0).then(function(e) {
                e ? t.triggerEvent("confirm", {}, {}) : t.setData({
                    is_login: !1
                });
            }, function(e) {}); else {
                var i = app.globalData.syStem;
                wx.requestSubscribeMessage({
                    tmplIds: [ i.template_id, i.accepted_template_id, i.complete_template_id ],
                    complete: function(e) {
                        console.log(e), settingModule.auth(0).then(function(e) {
                            e ? t.triggerEvent("confirm", {}, {}) : t.setData({
                                is_login: !1
                            });
                        }, function(e) {});
                    }
                });
            }
        }
    }
});