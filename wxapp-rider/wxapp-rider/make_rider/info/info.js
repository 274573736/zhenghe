var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        new_order_status: !0,
        new_order: {},
        count_time: 30,
        new_order_num: 0,
        img_url: app.globalData.imgUrl,
        avatar: "",
        madou: 0,
        mobile: 0,
        orderCount: 0,
        score: 0,
        valid_money: 0,
        real_name: "姓名",
        notify_count: 0,
        auth: !1,
        is_login: !0,
        hy_switch: !1,
        dj_switch: !1,
        jz_switch: !1
    },
    onLoad: function(e) {
        var n = this;
        app.setNavigation(), wx.getSetting({
            success: function(e) {
                e.authSetting["scope.userInfo"] && n.setData({
                    auth: !0
                });
            },
            fail: function(e) {}
        }), this.businessType();
    },
    onReady: function() {},
    onShow: function() {
        var n = this;
        app.listenWss(this), homeModule.riderInfo().then(function(e) {
            n.setData({
                avatar: e.avatar,
                madou: e.madou,
                mobile: e.mobile,
                orderCount: e.orderCount,
                score: e.score,
                valid_money: e.valid_money,
                real_name: e.real_name,
                notify_count: e.notify_count
            }), wx.setStorageSync("money", e.valid_money);
        });
    },
    onHide: function() {},
    businessType: function() {
        var a = this;
        homeModule.businessType().then(function(e) {
            for (var n = !1, t = !1, i = !1, o = 0; o < e.length; o++) "hy" == e[o].cname && (n = e[o].status), 
            "dj" == e[o].cname && (t = e[o].status), "jz" == e[o].cname && (i = e[o].status);
            a.setData({
                hy_switch: n,
                dj_switch: t,
                jz_switch: i
            });
        }, function(e) {});
    },
    goLogin: function() {
        this.setData({
            is_login: !1
        });
    },
    authBtn: function(e) {
        e.detail.auth ? this.setData({
            auth: !0,
            is_login: !0
        }) : this.setData({
            is_login: !0
        });
    },
    notifyBtn: function(e) {
        var t = this, n = app.globalData.syStem;
        wx.requestSubscribeMessage({
            tmplIds: [ n.acceptorder_template_id ],
            success: function(e) {
                console.log("成功");
                var n = ++t.data.notify_count;
                t.setData({
                    notify_count: n
                }), console.log(e), app.saveFormid();
            },
            fail: function(e) {
                console.log("成功"), console.log(e);
            }
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(e) {
        return {
            title: app.globalData.syStem.rider_program_title,
            path: "/make_rider/auth/auth?recommend_id=" + app.globalData.rider_id,
            imageUrl: app.globalData.syStem.rider_share_img ? app.globalData.syStem.rider_share_img : ""
        };
    },
    servicePart: function() {
        wx.navigateTo({
            url: "../service_description/service_description?title=服务分说明&type=rider_bean"
        });
    },
    bean: function() {
        wx.navigateTo({
            url: "../bean_description/bean_description?title=积分说明&type=rider_bean"
        });
    },
    myMsg: function() {
        wx.navigateTo({
            url: "../my_msg/my_msg"
        });
    },
    myOrder: function() {
        wx.navigateTo({
            url: "../order/order"
        });
    },
    setting: function() {
        wx.navigateTo({
            url: "../setting/setting"
        });
    },
    myMoney: function() {
        wx.navigateTo({
            url: "../my_money/my_money"
        });
    },
    service: function() {
        wx.navigateTo({
            url: "../service/service"
        });
    },
    share: function() {
        wx.navigateTo({
            url: "../share/share"
        });
    },
    tapCity: function() {
        homeModule.postDriver({
            info: 1
        }).then(function(e) {
            0 == e.status ? (wx.setStorageSync("driver_info", e), wx.showModal({
                title: "温馨提示",
                content: "您提交的司机认证信息正在审核中，是否需要重新提交~",
                success: function(e) {
                    e.confirm && wx.navigateTo({
                        url: "../driver_index/driver_index"
                    });
                }
            })) : 2 == e.status ? app.hint("您已经认证过司机了~") : wx.navigateTo({
                url: "../driver_index/driver_index"
            });
        }, function(e) {
            wx.navigateTo({
                url: "../driver_index/driver_index"
            });
        });
    },
    tapFreight: function() {
        homeModule.freightDriverInfo().then(function(e) {
            0 == e.status ? wx.showModal({
                title: "温馨提示",
                content: "您提交的司机认证信息正在审核中，是否需要重新提交~",
                success: function(e) {
                    e.confirm && wx.navigateTo({
                        url: "../driver_freight/driver_freight"
                    });
                }
            }) : 1 == e.status ? wx.showModal({
                title: "温馨提示",
                content: "您已经是货车司机，是否需要修改车型~",
                success: function(e) {
                    e.confirm && wx.navigateTo({
                        url: "../driver_freight/driver_freight"
                    });
                }
            }) : wx.navigateTo({
                url: "../driver_freight/driver_freight"
            });
        }, function(e) {
            wx.navigateTo({
                url: "../driver_freight/driver_freight"
            });
        });
    },
    tapHomemaking: function() {
        homeModule.homemakingInfo().then(function(e) {
            0 == e.status ? wx.showModal({
                title: "温馨提示",
                content: "您提交的技能认证信息正在审核中，是否需要重新提交~",
                success: function(e) {
                    e.confirm && wx.navigateTo({
                        url: "../driver_homemaking/driver_homemaking"
                    });
                }
            }) : 1 == e.status ? wx.showModal({
                title: "温馨提示",
                content: "您已经是技能师傅，是否需要修改技能类型~",
                success: function(e) {
                    e.confirm && wx.navigateTo({
                        url: "../driver_homemaking/driver_homemaking"
                    });
                }
            }) : wx.navigateTo({
                url: "../driver_homemaking/driver_homemaking"
            });
        }, function(e) {
            wx.navigateTo({
                url: "../driver_homemaking/driver_homemaking"
            });
        });
    },
    myTrain: function() {
        wx.navigateTo({
            url: "../my_train/my_train"
        });
    },
    shopping: function() {
        wx.navigateTo({
            url: "../shopping/shopping"
        });
    },
    handbook: function() {
        wx.navigateTo({
            url: "../handbook/handbook"
        });
    },
    awardPunishment: function() {
        wx.navigateTo({
            url: "../reward_punishment/reward_punishment"
        });
    },
    complain: function() {
        wx.navigateTo({
            url: "../complain/complain"
        });
    }
});