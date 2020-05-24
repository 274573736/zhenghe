var _home = require("../../modules/home"), _address = require("../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), hearTimer = null, app = getApp();

Page({
    data: {
        order_status_box_close: !0,
        close_order: !0,
        order_status: 2,
        order_type: 0,
        order: {},
        map_height: 500,
        pay_tip_bg: !0,
        pay_order_bg: !0,
        pay_method: 2,
        my_money: 0,
        tip_bg: !0,
        star_num: -1,
        evaluete_value: [],
        distance_start: 0,
        duration_start: 0,
        tip_money: 0,
        img_url: app.globalData.img_url,
        business_id: 0,
        firstPostData: 0,
        rider_id: 0,
        city_id: 0,
        socket_open: !0,
        charg_type: 1,
        driver_real_price: 0,
        driver_real_distance: 0
    },
    onLoad: function(e) {
        wx.showLoading({
            title: "加载中"
        }), this.setData({
            order_status: e.status || 2,
            order_type: e.order_type || 3
        });
        var t = e.order_id || 810;
        this.postData(t), wx.removeStorageSync("coupons");
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        var t = this;
        this.data.socket_open || (app.closeWs(), app.connectWs("type=place_order&order_id=" + this.data.order.order_id + "&rider_id=" + this.data.rider_id + "&city_id=" + this.data.city_id, function(e) {
            t.onMessage(), t.setData({
                socket_open: !0
            }), hearTimer && clearInterval(hearTimer), t.socketHeart();
        }));
        var e = setInterval(function() {
            t.data.firstPostData && (clearInterval(e), t.onMessage());
        }, 100);
    },
    onMessage: function() {
        var t = this;
        app.listenWs(function(e) {
            "real_time_price" != (e = JSON.parse(e)).type ? "send_rider_id" != e.type ? "update_order" == e.type && (wx.showLoading({
                title: "加载中"
            }), t.postData(1 * e.order_id)) : app.sendWs("type=place_order&order_id=" + t.data.order.order_id + "&rider_id=" + e.rider_id + "&city_id=" + t.data.city_id) : t.setData({
                driver_real_price: e.price.total_price || 0,
                driver_real_distance: e.price.distance || 0
            });
        }), app.onCloseWs(function(e) {
            console.log(e), t.setData({
                socket_open: !1
            });
        });
    },
    socketHeart: function() {
        var t = this;
        hearTimer = setInterval(function() {
            app.sendWs(JSON.stringify({
                heart: "heart"
            }), function(e) {
                e || (app.closeWs(), app.connectWs("type=place_order&order_id=" + t.data.order.order_id + "&rider_id=" + t.data.rider_id + "&city_id=" + t.data.city_id, function() {
                    t.onMessage(), t.setData({
                        socket_open: !0
                    }), hearTimer && clearInterval(hearTimer), t.socketHeart();
                }));
            });
        }, 5e4);
    },
    refreshData: function() {
        var e = this;
        this.data.socket_open || (app.closeWs(), app.connectWs("type=place_order&order_id=" + this.data.order.order_id + "&rider_id=" + this.data.rider_id + "&city_id=" + this.data.city_id, function() {
            e.onMessage(), e.setData({
                socket_open: !0
            }), hearTimer && clearInterval(hearTimer), e.socketHeart();
        })), this.data.order.order_id && (wx.showLoading({
            title: "加载中"
        }), this.postData(this.data.order.order_id));
    },
    againOrder: function() {
        wx.reLaunch({
            url: "/make_speed/router/router"
        });
    },
    payMethod: function(e) {
        var t = e.detail.pay_method, a = this.data.order.order_id;
        this.setData({
            pay_tip_bg: !0,
            pay_order_bg: !0,
            pay_method: t
        }), this.postData(a);
    },
    reminder: function() {
        var t = this;
        homeModule.reminder({
            id: this.data.order.id
        }).then(function(e) {
            e.accept_rider && (app.sendWs("type=place_order&order_id=" + t.data.order.id + "&data=" + e.accept_rider), 
            wx.showToast({
                title: "催单成功",
                icon: "success",
                duration: 2e3
            }));
        }, function(e) {});
    },
    selectTip: function() {
        var t = this, e = 0;
        0 != this.data.order.business_id && (e = 1), homeModule.getMoney({
            type: e
        }).then(function(e) {
            t.setData({
                my_money: e.valid,
                tip_bg: !1
            });
        }, function(e) {});
    },
    tipSelected: function(e) {
        this.data.order.order_id;
        var t = e.detail.tip_money;
        isNaN(t) || t <= 0 ? this.setData({
            tip_bg: !0
        }) : this.setData({
            tip_money: t,
            tip_bg: !0,
            pay_tip_bg: !1
        });
    },
    tip_bg: function() {
        this.setData({
            tip_bg: !0
        });
    },
    evalutete: function(e) {
        this.setData({
            order_status: e.detail.status,
            star_num: e.detail.star_num,
            evaluete_value: e.detail.evaluete_value
        });
    },
    postData: function(u) {
        var h = this, e = "make_speed";
        5 == this.data.order_type && (e = "make_speed_plugin_freight"), homeModule.orderDetail({
            id: u
        }, e).then(function(e) {
            setTimeout(function() {
                wx.hideLoading();
            }, 500);
            var t = 0, a = 0;
            h.data.firstPostData || (e && e.riders && e.riders.rider_id && (t = 1 * e.riders.rider_id), 
            e && e.city_id && (a = 1 * e.city_id), app.connectWs("type=place_order&order_id=" + u + "&rider_id=" + t + "&city_id=" + a, function() {
                h.setData({
                    socket_open: !0
                }), h.socketHeart();
            }));
            var i = e.order_type;
            e.status;
            h.setData({
                order: e,
                order_status: e.status,
                order_type: e.order_type,
                business_id: e.business_id,
                firstPostData: 1,
                rider_id: t,
                city_id: a,
                evaluete_data: {
                    distance: e.distance,
                    pay_price: e.pay_price,
                    order_id: e.order_id,
                    gral: e.gral,
                    grow: e.grow
                }
            });
            var r = 0;
            3 != i && 5 != i || (r = 1);
            var o = {};
            o.location = {
                lat: 1 * e.begin_lat,
                lng: 1 * e.begin_lng
            };
            var d = {};
            if (d.location = {
                lat: 1 * e.end_lat,
                lng: 1 * e.end_lng
            }, 6 <= e.status) h.setData({
                star_num: e.riders.score,
                evaluete_value: e.riders.tag
            }); else {
                if ((1 * e.end_lat <= 0 || 1 * e.end_lng <= 0) && e.begin_lat && e.begin_lng) {
                    var s = [ {
                        id: 1,
                        latitude: e.begin_lat,
                        longitude: e.begin_lng,
                        iconPath: app.globalData.img_url + "start.png",
                        width: 25,
                        height: 40,
                        callout: {}
                    } ];
                    return e.riders && e.riders.lat && s.push({
                        id: 2,
                        latitude: e.riders.lat,
                        longitude: e.riders.lng,
                        iconPath: app.globalData.img_url + "rider.png",
                        width: 25,
                        height: 20
                    }), void h.setData({
                        latitude: e.begin_lat,
                        longitude: e.begin_lng,
                        markers: s
                    });
                }
                var n = wx.getStorageSync("system");
                if (3 == e.status || 4 == e.status) {
                    var l = {};
                    l.lat = e.riders.lat, l.lng = e.riders.lng;
                    var c = {
                        location: l
                    };
                    if (wx.setStorageSync("rider", c), 4 == e.status) return void addressModule.getDistance(0, n.gaode_key, c, d, r).then(function(e) {
                        h.setData({
                            distance: e.distance,
                            duration: e.duration
                        }), h.map(e.points, o, d);
                    }, function(e) {
                        console.log(e);
                    });
                    if (1 == i && !e.begin_lat || 2 == i) addressModule.getDistance(0, n.gaode_key, c, o, r).then(function(e) {
                        h.setData({
                            distance: e.distance,
                            duration: e.duration
                        }), h.map(e.points, o, d);
                    }, function(e) {}); else {
                        var _ = addressModule.getDistance(0, n.gaode_key, c, o, r), p = addressModule.getDistance(1, n.gaode_key, o, d, r);
                        Promise.all([ _, p ]).then(function(e) {
                            h.setData({
                                distance: e[0].distance,
                                duration: e[0].duration,
                                distance_start: e[1].distance,
                                duration_start: e[1].duration
                            });
                            var t = e[0].points;
                            t = t.concat(e[1].points), h.map(t, o, d);
                        }, function(e) {});
                    }
                }
                0 != e.status && 2 != e.status || addressModule.getDistance(1, n.gaode_key, o, d, r).then(function(e) {
                    h.setData({
                        distance: e.distance,
                        duration: e.duration
                    }), h.map(e.points, o, d);
                }, function(e) {
                    console.log(e);
                });
            }
        }, function(e) {
            setTimeout(function() {
                wx.hideLoading();
            }, 500);
        });
    },
    map: function(e, t, a) {
        var i = this, r = wx.getStorageSync("rider");
        r = r.location;
        this.data.duration, this.data.order_type;
        var o = this.data.order_status, d = [ {
            id: 2,
            latitude: a.location.lat,
            longitude: a.location.lng,
            iconPath: app.globalData.img_url + "end.png",
            width: 25,
            height: 40,
            callout: {}
        } ];
        o < 4 && t && t.location && t.location.lat && d.push({
            id: 1,
            latitude: t.location.lat,
            longitude: t.location.lng,
            iconPath: app.globalData.img_url + "start.png",
            width: 25,
            height: 40,
            callout: {}
        }), 2 < this.data.order_status && (app.globalData.syStem && app.globalData.syStem.rider_map_icon ? homeModule.developFile(app.globalData.syStem.rider_map_icon).then(function(e) {
            d.push({
                id: 3,
                latitude: r.lat,
                longitude: r.lng,
                iconPath: e,
                width: 25,
                height: 25
            }), i.setData({
                markers: d
            });
        }, function(e) {}) : d.push({
            id: 3,
            latitude: r.lat,
            longitude: r.lng,
            iconPath: app.globalData.img_url + "rider.png",
            width: 25,
            height: 20
        })), this.setData({
            latitude: a.location.lat,
            longitude: a.location.lng,
            markers: d,
            polyline: [ {
                points: e,
                color: "#097bf1",
                width: 5,
                arrowLine: !0,
                arrowIconPath: app.globalData.img_url + "jiantou.png"
            } ]
        });
    },
    selectPay: function() {
        var t = this, e = 0;
        0 != this.data.order.business_id && (e = 1), homeModule.getMoney({
            type: e
        }).then(function(e) {
            t.setData({
                my_money: e.valid,
                pay_order_bg: !1
            });
        }, function(e) {});
    },
    pay_bg: function() {
        this.setData({
            pay_tip_bg: !0,
            pay_order_bg: !0
        });
    },
    sPay: function(e) {
        var t = this, a = e.detail.select;
        1 == a ? this.setData({
            pay_tip_bg: !0,
            pay_order_bg: !0,
            pay_method: e.detail.pay_method
        }) : 2 == a ? this.setData({
            ay_order_bg: !0
        }) : homeModule.getMoney().then(function(e) {
            t.setData({
                ay_order_bg: !1,
                my_money: e.valid
            });
        }, function(e) {});
    },
    closeOrder: function() {
        this.setData({
            close_order: !1
        });
    },
    closeOrderClose: function() {
        this.setData({
            close_order: !0
        });
    },
    confirmClose: function(e) {
        var t = this, a = this.data.order.order_id;
        5 != this.data.order_type ? homeModule.closeOrder({
            id: a
        }).then(function(e) {
            t.closeOrderModuleMsg(a);
        }, function(e) {}) : homeModule.closeFreightOrder({
            id: a
        }).then(function(e) {
            t.closeOrderModuleMsg(a);
        }, function(e) {});
    },
    closeOrderModuleMsg: function(e, t) {
        homeModule.sendCloseTemplate({
            order_id: t
        }).then(function(e) {}, function(e) {}), app.hint("取消订单成功~", "success"), this.setData({
            close_order: !0,
            order_status: 1
        });
    },
    orderStatusBox: function() {
        this.setData({
            order_status_box_close: !1
        });
    },
    orderStatusBoxClose: function() {
        this.setData({
            order_status_box_close: !0
        });
    },
    toPriceDetail: function() {
        var e = this.data.order, t = {};
        if (t.order_type = parseFloat(e.order_type), t.distance = parseFloat(e.distance), 
        t.tip_money = parseFloat(e.small_price), t.coupon_money = parseFloat(e.coupon_money), 
        t.night_price = parseFloat(e.night_price), t.actual_payment = parseFloat(e.pay_price), 
        t.weight = parseFloat(e.weight), t.change_price = parseFloat(e.change_price), t.discount_price = parseFloat(e.discount_price), 
        t.distance_price = parseFloat(e.distance_price), t.floor_price = parseFloat(e.floor_price) || 0, 
        5 == e.order_type) return t.title = e.car_name, t.starting_km = e.start_km, t.starting_price = e.start_price, 
        wx.setStorageSync("price_detail", t), void wx.navigateTo({
            url: "../price_des/price_des"
        });
        wx.setStorageSync("price_detail", t), wx.navigateTo({
            url: "../price_des/price_des"
        });
    },
    onHide: function() {},
    onUnload: function() {
        app.closeWs(), hearTimer && clearInterval(hearTimer);
    },
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