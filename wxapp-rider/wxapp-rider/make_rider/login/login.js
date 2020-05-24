var _home = require("../../modules/home.js"), app = getApp(), homeModule = new _home.home();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        top_id: 0,
        phone: 0,
        code: "",
        idcard: "",
        username: "",
        img_url: app.globalData.imgUrl,
        logo_url: "",
        showcheck: -1
    },
    showDetail: function() {
        wx.navigateTo({
            url: "../show_detail/show_detail"
        });
    },
    onLoad: function(e) {
        var t = this;
        homeModule.getLogo().then(function(e) {
            t.setData({
                logo_url: e.logo_url
            });
        }, function(e) {
            t.setData({
                logo_url: t.data.img_url + "rider_login.jpg"
            });
        }), homeModule.getSystem().then(function(e) {
            app.globalData.login_num = ++app.globalData.login_num, 1 == e.r_program_verify_switch && wx.setNavigationBarTitle({
                title: "首页"
            }), t.setData({
                showcheck: e.r_program_verify_switch
            });
        }, function(e) {});
    },
    topTap: function(e) {
        this.setData({
            top_id: e.currentTarget.id
        });
    },
    phoneInput: function(e) {
        var t = e.detail.value;
        this.setData({
            phone: t
        });
    },
    coopration: function() {
        wx.navigateTo({
            url: "../bean_description/bean_description?title=合作协议&type=rider_cooperate"
        });
    },
    codeInput: function(e) {
        var t = e.detail.value;
        this.setData({
            code: t
        });
    },
    code: function() {
        var e = this.data.phone;
        1 == this.data.top_id ? (console.log("我是注册"), homeModule.register({
            is_send: 1,
            mobile: e
        }).then(function(e) {
            return app.hint("发送成功~");
        }, function(e) {})) : homeModule.login({
            is_send: 1,
            mobile: e
        }).then(function(e) {
            return app.hint("发送成功~");
        }, function(e) {});
    },
    form: function(e) {
        app.saveFormid(e.detail.formId);
        var t = e.detail.value.protocol, o = e.detail.value.phone, n = e.detail.value.code, a = this.data.top_id;
        if (!/^1(3|4|5|6|7|8|9)\d{9}$/.test(o)) return app.hint("手机号输入有误");
        if (!n) return app.hint("验证码不能为空");
        if (0 == a) {
            if (!t[0]) return app.hint("必须同意合作协议");
            homeModule.login({
                mobile: o,
                smscode: n
            }).then(function(e) {
                wx.setStorageSync("phone", o), wx.reLaunch({
                    url: "../index/index"
                }), app.hint("登录成功~");
            }, function(e) {});
        } else if (1 == a) {
            var i = e.detail.value.username;
            if (!i) return app.hint("用户名不能为空");
            if (!t[0]) return app.hint("必须同意合作协议");
            var r = e.detail.value.invide_code, l = wx.getStorageSync("recommend_id");
            homeModule.register({
                mobile: o,
                username: i,
                smscode: n,
                invite_code: r,
                recommend_id: l
            }).then(function(e) {
                wx.setStorageSync("phone", o), wx.navigateTo({
                    url: "../register/register"
                }), app.hint("注册成功~", "success");
            }, function(e) {});
        }
    },
    onReady: function() {
        app.setNavigation();
    },
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