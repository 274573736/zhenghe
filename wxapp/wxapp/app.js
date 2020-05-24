var SocketTask = null;

App({
    globalData: {
        getImgUrl: "",
        cut_path: "",
        syStem: "",
        user_id: 0,
        business_id: 0,
        img_url: "",
        buy_goods_idx: 0,
        buy_remark: "",
        all_goods_idx: 0,
        all_remark: "",
        all_audio_url: "",
        userAuth: 0,
        address_title_change: !0,
        is_socket_open: !1
    },
    onLaunch: function(e) {
        console.log("app.js ---onLaunch---" + JSON.stringify(e));
        this.getUpdate();
        var t = this.siteInfo.siteroot.match(/\/\/\w+\S+(?=\/app)/)[0];
        this.globalData.cut_path = t, this.globalData.img_url = "https:" + t + "/addons/make_speed/core/public/uploads/program_icon/client/";
        e.path;
        this.getSystem();
    },
    appu: require("modules/apps.js"),
    util: require("we7/resource/js/util.js"),
    siteInfo: require("siteinfo.js"),
    data: require("utils/util.js"),
    onHide: function() {
        console.log("app.js ---onHide---");
        this.isBigCutomer();
    },
    isBigCutomer: function() {
        var e = getCurrentPages(), t = e[e.length - 1].route.split("/");
        "big_customer" != t[1] || "info" != t[2] && "a_key_order" != t[2] ? wx.setStorageSync("is_big_customer", 0) : wx.setStorageSync("is_big_customer", 1);
    },
    getSystem: function() {
        console.log("app.js ---getSystem---");
        var o = this, e = setInterval(function() {
            var t = new o.appu.apps();
            t && (clearInterval(e), o.util.getUserInfo(function(e) {
                t.getSystem(o).then(function(e) {
                    o.globalData.syStem = e, wx.setStorageSync("system", e);
                }, function(e) {});
            }));
        }, 10);
    },
    hint: function(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "none";
        wx.showToast({
            title: e,
            icon: t,
            duration: 2e3
        });
    },
    getShare: function() {
        console.log("app.js ---getShare---");
        new this.appu.apps().getShareCoupon(this).then(function(e) {}, function(e) {});
    },
    setFormId: function(e) {
        console.log("app.js ---setFormId---");
        e && "the formId is a mock one" != e && new this.appu.apps().setFormId(this, {
            formId: e
        }, function(e) {}, function(e) {});
    },
    setNavigation: function() {
        console.log("app.js ---setNavigation---");
        var t = this;
        if (this.globalData.syStem) wx.setNavigationBarColor({
            frontColor: this.globalData.syStem.program_font,
            backgroundColor: this.globalData.syStem.program_background
        }); else var o = setInterval(function() {
            if (t.globalData.syStem) {
                clearInterval(o);
                var e = t.globalData.syStem;
                wx.setNavigationBarColor({
                    frontColor: e.program_font,
                    backgroundColor: e.program_background
                });
            }
        }, 10);
    },
    connectWs: function(t) {
        var o = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "";
        SocketTask = wx.connectSocket({
            url: this.globalData.syStem.socket_domain
        }), t && SocketTask.onOpen(function(e) {
            SocketTask.send({
                data: t,
                success: function() {
                    "function" == typeof o && o(e);
                }
            });
        });
    },
    closeWs: function() {
        SocketTask && SocketTask.close();
    },
    sendWs: function(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "";
        SocketTask.send({
            data: e,
            success: function(e) {
                "function" == typeof t && t(!0);
            },
            fail: function(e) {
                t(!1);
            }
        });
    },
    onCloseWs: function(t) {
        SocketTask.onClose(function(e) {
            "function" == typeof t && t(e);
        });
    },
    listenWs: function(t) {
        SocketTask.onMessage(function(e) {
            "function" == typeof t && t(e.data);
        });
    },
    getCurrentPageUrl: function() {
        var e = getCurrentPages();
        return e[e.length - 1].route.split("/")[2];
    },
    collectTip: function(e) {
        wx.getStorageSync("is_tip_collect") || e.setData({
            is_tip_collect: !0
        });
    },
    getApplicationIsAuth: function() {
        return new Promise(function(e, t) {
            return e(1);
        });
    },
    goingOrder: function(e) {
        console.log("app.js ---goingOrder---");
        e.orderList({
            status: 1,
            page: 1
        }).then(function(t) {
            t && "" != t && 0 < t.length && wx.showModal({
                title: "温馨提示",
                content: "您有一个正在进行中的订单,是否前往查看~",
                confirmText: "进入详情",
                success: function(e) {
                    e.confirm && wx.navigateTo({
                        url: "/make_speed/order_pay/order_pay?order_id=" + t[0].id + "&status=" + t[0].status + "&is_business=0&order_type=" + t[0].type
                    });
                }
            });
        }, function(e) {});
    },
    toUrl: function(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : -1, o = "";
        0 == e.theme_index ? (-1 < t && (e.business_home = t), o = 0 == e.business_home ? "/make_speed/index/index" : 1 == e.business_home ? "/make_speed/help_buy/help_buy" : 2 == e.business_home ? "/make_speed/all_powerful/all_powerful" : 3 == e.business_home ? "/make_speed/replace_driver/replace_driver" : 4 == e.business_home ? "/make_speed/freight/freight" : 5 == e.business_home ? "/make_speed/homemaking/homemaking" : "/make_speed/index/index") : o = 1 == e.theme_index ? "/make_speed/skin/index/index?type=" + t : (e.theme_index, 
        "/make_speed/skin/index_two/index_two?type=" + t), wx.redirectTo({
            url: o
        });
    },
    toTwoUrl: function(e) {
        console.log("app.js ---toTwoUrl---");
        var t = wx.getStorageSync("fahuo"), o = wx.getStorageSync("shouhuo");
        return 0 == e ? t.person_tel && o.person_tel ? (this.delRepeat(t, 0, 0), void wx.redirectTo({
            url: "/make_speed/skin/speed/speed"
        })) : void wx.navigateBack({
            delta: 1
        }) : t.person_tel && o.title ? (this.delRepeat(t, 0, 0), void wx.redirectTo({
            url: "/make_speed/skin/replace_driver/replace_driver"
        })) : void wx.navigateBack({
            delta: 1
        });
    },
    delRepeat: function(e) {
        console.log("app.js ---delRepeat---");
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0, o = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0, n = "";
        n = 1 == t ? "big_history_address" : 1 != t && 0 == o ? "fa_history_address" : "shou_history_address";
        var a = wx.getStorageSync(n) || [], s = !1, i = a.length, r = -1;
        if (0 < i) for (var l = 0; l < i; l++) a[l].id == e.id && a[l].person_address == e.person_address && a[l].person_name == e.person_name && a[l].person_tel == e.person_tel && (r = l, 
        s = !0);
        s && 0 < r && a.splice(r, 1), !s && 10 <= i && a.pop(), (!s || s && 0 < r) && (a.unshift(e), 
        wx.setStorageSync(n, a));
    },
    getAppSetting: function() {
        console.log("app.js ---getAppSetting---");
        var t = this, o = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0, n = setInterval(function() {
            if (t.globalData.syStem) {
                clearInterval(n);
                var e = getCurrentPages()[getCurrentPages().length - 1];
                if (-2 == o) return void e.setData({
                    showcheck: t.globalData.syStem.program_verify_switch,
                    title: t.globalData.syStem.user_program_title
                });
                e.setData({
                    showcheck: t.globalData.syStem.program_verify_switch
                }), wx.setNavigationBarColor({
                    frontColor: t.globalData.syStem.program_font,
                    backgroundColor: t.globalData.syStem.program_background,
                    animation: {
                        duration: 400,
                        timingFunc: "easeIn"
                    }
                }), t.globalData.syStem.business_home == o || -1 == o ? wx.setNavigationBarTitle({
                    title: t.globalData.syStem.user_program_title
                }) : wx.setNavigationBarTitle({
                    title: t.globalData.syStem.business_type[o].title
                });
            }
        }, 10);
    },
    getUpdate: function() {
        console.log("app.js ---getUpdate---");
        var t = wx.getUpdateManager();
        t.onCheckForUpdate(function(e) {
            console.log(e.hasUpdate);
        }), t.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本上线，需要重启应用哟~",
                showCancel: !1,
                success: function(e) {
                    e.confirm && t.applyUpdate();
                }
            });
        }), t.onUpdateFailed(function() {});
    }
});