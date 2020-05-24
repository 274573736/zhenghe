var _socket = require("./utils/socket"), _socket2 = _interopRequireDefault(_socket);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var bgAudioContext = wx.getBackgroundAudioManager(), position_timer = 0;

App({
    globalData: {
        getImgUrl: "",
        rider_id: 0,
        pushOrder: !1,
        isConnect: !0,
        order_switch: 0,
        wait_count: 0,
        syStem: "",
        address_auth: !1,
        userAuth: 0,
        login_num: 0,
        socket_location_switch: !0,
        socket_location: !1,
        wechat_upgrade: !1,
        rider_position: {
            lat: 0,
            lng: 0
        },
        rider_icon: "",
        wss: "",
        imgUrl: ""
    },
    appu: require("modules/apps.js"),
    util: require("we7/resource/js/util.js"),
    siteInfo: require("siteinfo.js"),
    onLaunch: function(t) {
        var o = this.siteInfo.siteroot.match(/\/\/\w+\S+(?=\/app)/)[0];
        this.globalData.imgUrl = "https:" + o + "/addons/make_rider/core/public/uploads/program_icon/rider/", 
        this.globalData.wss = "wss:" + o;
        var e = t.path, n = t.query.recommend_id;
        n && wx.setStorageSync("recommend_id", n), this.getSettingUpdate(), this.getRiderStatus(e);
    },
    onShow: function() {
        var t = this;
        wx.setKeepScreenOn({
            keepScreenOn: !0
        }), this.socket && 1 == this.socket.open && (console.log("进来监听"), this.connectWs("type=bind_rider&rider_id=" + this.globalData.rider_id), 
        this.onCloseWs()), bgAudioContext.onEnded(function() {
            t.globalData.pushOrder && bgAudioContext.play(), console.log("自然结束状态=" + t.globalData.pushOrder);
        }), bgAudioContext.onError(function(t) {
            console.log("播放出错了"), console.log(t);
        });
    },
    onHide: function() {
        this.socket && 1 == this.socket.open && this.onCloseWs(), position_timer && clearInterval(position_timer);
    },
    getBackgroundLocation: function() {
        var o = this;
        wx.startLocationUpdateBackground({
            success: function(t) {
                console.log("开启位置变化"), o.globalData.socket_location || (o.globalData.socket_location = !0), 
                o.socketLocationChange();
            },
            fail: function(t) {
                console.log("开启实时位置失败"), console.log(t);
            }
        });
    },
    socketLocationChange: function() {
        var n = this;
        wx.onLocationChange(function(t) {
            if (n.socket && n.socket.open && t.latitude && t.longitude) {
                var o = n.globalData.rider_position;
                if (o.lat != t.latitude || o.lng != t.longitude) {
                    var e = {
                        lat: t.latitude,
                        lng: t.longitude
                    };
                    n.globalData.rider_position = e, n.sendWs("type=rider_position&rider_id=" + n.globalData.rider_id + "&position=" + JSON.stringify(e));
                }
            }
        });
    },
    bgm_close: function() {
        bgAudioContext.pause();
    },
    connectWs: function(n) {
        var i = this;
        return new Promise(function(o, e) {
            i.socket || (i.socket = new _socket2.default({
                heartCheck: !0,
                isReconnection: !0,
                data: n
            }));
            var t = setInterval(function() {
                i.globalData.syStem.port && (clearInterval(t), i.socket.initWebSocket({
                    url: i.globalData.wss + ":" + i.globalData.syStem.port,
                    success: function(t) {
                        console.log("连接成功"), o(!0);
                    },
                    fail: function(t) {
                        e(!0), console.log(t);
                    }
                }));
            }, 100);
        });
    },
    closeWs: function() {
        this.socket.closeWebSocket();
    },
    getWebSocket: function() {
        return this.socket;
    },
    onCloseWs: function() {
        this.socket.onSocketClosed({
            url: this.globalData.wss,
            success: function(t) {
                console.log("断开");
            },
            fail: function(t) {
                console.log(t);
            }
        }), this.socket.onNetworkChange({
            url: this.globalData.wss,
            success: function(t) {
                console.log("网络断开"), console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    sendWs: function(t) {
        var o = this, e = 0, n = setInterval(function() {
            40 < ++e && clearInterval(n), 1 == o.socket.open && (clearInterval(n), o.socket.sendMsg({
                data: t,
                success: function(t) {
                    console.log("发送成功");
                },
                fail: function(t) {
                    console.log("发送失败");
                }
            }));
        }, 1e3, t);
    },
    socketLocationAuth: function() {
        var o = this;
        wx.showModal({
            title: "开启位置共享",
            content: "位置信息授权时需要选择，使用小程序期间和离开小程序后选项",
            confirmText: "去开启",
            success: function(t) {
                t.confirm ? wx.openSetting({
                    success: function(t) {}
                }) : t.cancel && (o.globalData.socket_location_switch = !1, o.globalData.socket_location = !1);
            }
        });
    },
    listenWss: function(n) {
        var i = this;
        console.log("开始监听"), this.socket && (this.globalData.socket_location_switch && !this.globalData.socket_location && wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userLocationBackground"] ? i.getBackgroundLocation() : i.socketLocationAuth();
            }
        }), this.socket.onMessage(function(t) {
            var o = new i.appu.apps(), e = JSON.parse(t.data);
            e && "upload_coord" == e.type ? o.carSocket(i).then(function(t) {}, function(t) {}) : o.getNewOrder(i, {
                order: t.data
            }).then(function(t) {
                if (!t) return !1;
                i.playMusic(n, !0), n.setData({
                    new_order: t,
                    new_order_num: 1 * n.data.new_order_num + 1
                });
            }, function(t) {});
        }));
    },
    getRiderStatus: function(t) {
        var e = this;
        setTimeout(function() {
            var o = new e.appu.apps();
            e.util.getUserInfo(function(t) {
                o.getSystem(e).then(function(t) {
                    e.globalData.syStem = t, wx.setStorageSync("system", t), t.rider_map_icon && o.developFile(t.rider_map_icon).then(function(t) {
                        e.globalData.rider_icon = t;
                    }, function(t) {});
                }), o.getRiderStatus(e);
            });
        }, 10);
    },
    hint: function(t) {
        var o = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "none";
        wx.showToast({
            title: t,
            icon: o,
            duration: 2e3
        });
    },
    orderDetail: function() {
        wx.navigateTo({
            url: "../order-detail/order-detail"
        });
    },
    getCurrentPagePath: function() {
        var t = getCurrentPages();
        if (t && 0 < t.length) return t[t.length - 1].route.split("/")[2];
    },
    playMusic: function(t, o) {
        this.globalData.pushOrder = !0, o && !bgAudioContext.src ? this.playMusicSrc() : o && bgAudioContext.src && bgAudioContext.play(), 
        this.acceptOrder(t);
    },
    playMusicSrc: function() {
        bgAudioContext.title = "接单通知", bgAudioContext.singer = this.globalData.syStem.rider_program_title, 
        bgAudioContext.src = this.globalData.syStem.tip_bgm_url || "tip_bgm.mp3";
    },
    saveFormid: function() {
        var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0;
        new this.appu.apps().saveFormid(this, {
            formId: t
        }, function(t) {}, function(t) {});
    },
    postRiderPosition: function() {
        var t = this;
        position_timer = setInterval(function() {
            t.globalData.order_switch && t.globalData.wait_count && t.globalData.address_auth && t.getRiderLocation();
        }, 1e4);
    },
    getRiderLocation: function() {
        var o = this, e = new this.appu.apps();
        e.getLatLng().then(function(t) {
            e.postRiderPosition(o, {
                address: "",
                lat: t.latitude,
                lng: t.longitude
            }).then(function(t) {}, function(t) {});
        }, function(t) {});
    },
    setNavigation: function() {
        var t = this;
        if (this.globalData.syStem) wx.setNavigationBarColor({
            frontColor: this.globalData.syStem.rider_program_font,
            backgroundColor: this.globalData.syStem.rider_program_background
        }); else var o = setInterval(function() {
            t.globalData.syStem && (clearInterval(o), wx.setNavigationBarColor({
                frontColor: t.globalData.syStem.rider_program_font,
                backgroundColor: t.globalData.syStem.rider_program_background
            }));
        }, 10);
    },
    getApplicationIsAuth: function() {
        return new Promise(function(t, o) {
            return t(1);
        });
    },
    robOrder: function() {
        var t = getCurrentPages();
        "rob_order" == t[t.length - 1].route.split("/")[2] ? wx.redirectTo({
            url: "../rob_order/rob_order?top_id=1"
        }) : wx.navigateTo({
            url: "../rob_order/rob_order?top_id=1"
        });
    },
    acceptOrder: function(t) {
        var o = this, e = t.data.count_time, n = setInterval(function() {
            if (25 < e && wx.vibrateLong(), e < 1 || !o.globalData.pushOrder) return o.globalData.pushOrder = !1, 
            clearInterval(n), t.setData({
                count_time: 30,
                new_order_num: 0,
                new_order: {},
                new_order_status: !0
            }), bgAudioContext.pause(), !1;
            e--, t.setData({
                count_time: e
            });
        }, 1e3);
        t.setData({
            new_order_status: !1
        });
    },
    getSettingUpdate: function() {
        var o = wx.getUpdateManager();
        o.onCheckForUpdate(function(t) {}), o.onUpdateReady(function() {
            wx.showModal({
                title: "更新提示",
                content: "新版本上线，需要重启应用哟~",
                showCancel: !1,
                success: function(t) {
                    t.confirm && o.applyUpdate();
                }
            });
        }), o.onUpdateFailed(function() {});
    }
});