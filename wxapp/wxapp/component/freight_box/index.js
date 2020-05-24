var _home = require("../../modules/home"), _address = require("../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

Component({
    properties: {
        order_type: {
            type: Number,
            observer: function(e, t) {
                4 == e && this.checkAddress();
            }
        }
    },
    data: {
        list: [],
        swiper_idx: 0,
        price: 0,
        fahuo: "",
        shouhuo: "",
        is_address: 0,
        distance: 0,
        car_id: 0,
        mileage: 0,
        red_bag: !0,
        is_price: 0,
        nav_back: "#097bf1",
        nav_color: "#ffffff",
        title: "码科货运",
        contentHeight: "",
        is_tip_collect: !1,
        time: "立即取货",
        volume_car: 0,
        weight: 100,
        volume: 0,
        load_bearing: 0,
        freight_weight: 0,
        freight_cube: 0
    },
    lifetimes: {
        attached: function() {
            this.setData({
                load_bearing: app.globalData.syStem.load_bearing,
                freight_weight: app.globalData.syStem.freight_weight,
                freight_cube: app.globalData.syStem.freight_cube
            }), this.topSwiper(), this.carType(), this.checkAddress();
        }
    },
    pageLifetimes: {
        show: function() {
            wx.getStorageSync("is_remove_shou") && wx.removeStorageSync("shouhuo"), this.checkAddress();
        }
    },
    methods: {
        scrollSole: function() {
            var e = this.selectComponent("#tfresh");
            e.data.toprefresh || (console.log("scrollview top"), e.refreshstart(), this.topSwiper(), 
            this.carType(), app.getSettion(), setTimeout(function() {
                e.refreshend(), wx.hideLoading();
            }, 1e3));
        },
        jump_detail: function(e) {
            var t = e.currentTarget.dataset.idx, a = this.data.list[t].id;
            wx.navigateTo({
                url: "/sundries/make_freight/car_detail/car_detail?id=" + a
            });
        },
        callTel: function() {
            var e = wx.getStorageSync("system");
            e.kefu_phone && wx.makePhoneCall({
                phoneNumber: e.kefu_phone
            });
        },
        updateTime: function(e) {
            this.setData({
                time: e.detail.time
            });
        },
        confirm: function() {
            var e = this.data.list[this.data.swiper_idx], t = this.data.distance;
            if (1 != this.data.is_address) return app.hint("请先选择地址~");
            var a = this.data.shouhuo;
            if (a && !a.person_tel) return app.hint("收货人号码未填~");
            wx.setStorageSync("goods", e), wx.navigateTo({
                url: "/sundries/make_freight/order/order?distance=" + t + "&price=" + this.data.price + "&mileage=" + this.data.mileage + "&time=" + this.data.time + "&volume_car=" + this.data.volume_car + "&weight=" + this.data.weight + "&volume=" + this.data.volume
            });
        },
        checkAddress: function() {
            var e = this;
            wx.getStorageSync("is_remove_shou") && (wx.removeStorageSync("is_remove_shou"), 
            wx.removeStorageSync("shouhuo"));
            var t = wx.getStorageSync("fahuo"), a = wx.getStorageSync("shouhuo");
            if (this.setData({
                fahuo: t,
                shouhuo: a
            }), t && t.person_tel && a && a.title) {
                if (this.setData({
                    price: 1,
                    is_price: 0
                }), app.globalData.syStem) return void this.predict(t, a, app.globalData.syStem.gaode_key);
                var i = setInterval(function() {
                    app.globalData.syStem && (clearInterval(i), e.predict(t, a, app.globalData.syStem.gaode_key));
                }, 10);
            } else this.setData({
                is_address: 0
            });
        },
        predict: function(e, a, i) {
            var r = this, s = this.data.swiper_idx, o = setInterval(function() {
                if (r.data.list && 0 < r.data.list.length) {
                    clearInterval(o);
                    var t = r.data.list[s].id;
                    addressModule.getDistance(0, i, e, a, 1).then(function(e) {
                        r.getPrice(e.distance, t);
                    }, function(e) {
                        console.log(e);
                    });
                }
            }, 10);
        },
        getPrice: function(s, e) {
            var o = this;
            homeModule.predictPrice({
                distance: s,
                car_id: e,
                weight: this.data.weight,
                car_type: this.data.volume_car,
                switch: 0,
                cube: this.data.volume
            }).then(function(e) {
                var t = 1 * e.price, a = 1 * e.mileage;
                o.setData({
                    price: t,
                    mileage: a,
                    is_address: 1,
                    distance: s,
                    is_price: 1
                });
                var i = o.data.list[o.data.swiper_idx], r = {
                    order_type: 5
                };
                r.title = i.title, r.starting_km = i.starting_km, r.starting_price = i.starting_price, 
                r.distance = s, r.distance_price = 1 * e.init_price + 1 * e.mileage, r.actual_payment = t, 
                r.weight = o.data.weight, r.weight_fee = e.weight, r.cube = e.cube_price, r.volume = o.data.volume, 
                r.carry = e.load, wx.setStorageSync("price_detail", r);
            }, function(e) {});
        },
        swiperCar: function(e) {
            var t = e.currentTarget.dataset.id, a = e.currentTarget.dataset.index;
            1 == a && (a = 0), this.setData({
                swiper_idx: t,
                status: a
            }), this.checkAddress();
        },
        cardSwiper: function(e) {
            this.setData({
                cardCur: e.detail.current
            });
        },
        bindArrows: function(e) {
            var t = this.data.swiper_idx;
            1 == e.currentTarget.dataset.id ? t++ : t--, this.setData({
                swiper_idx: t
            }), this.checkAddress();
        },
        swiperTap: function(e) {
            var t = e.detail.current, a = t;
            1 == a && (a = 0), this.setData({
                swiper_idx: t,
                status: a
            }), this.checkAddress();
        },
        carType: function() {
            var t = this;
            homeModule.carType().then(function(e) {
                t.setData({
                    list: e
                });
            }, function(e) {});
        },
        topSwiper: function() {
            var t = this;
            homeModule.topSwiper().then(function(e) {
                t.setData({
                    top_swiper: e
                });
            }, function(e) {});
        },
        volumeBtn: function(e) {
            this.setData({
                volume_car: e.currentTarget.dataset.idx
            }), this.checkAddress();
        },
        inputWeight: function(e) {
            this.setData({
                weight: parseInt(e.detail.value)
            }), this.checkAddress();
        },
        inputVolume: function(e) {
            this.setData({
                volume: parseFloat(e.detail.value || 0)
            }), this.checkAddress();
        },
        weightBtn: function(e) {
            var t = parseInt(this.data.weight);
            0 == e.currentTarget.dataset.idx ? t -= 100 : t += 100, 0 < t && (this.setData({
                weight: t
            }), this.checkAddress());
        },
        jump: function(e) {
            var t = e.currentTarget.dataset.url, a = e.currentTarget.dataset.type, i = e.currentTarget.dataset.app_url, r = e.currentTarget.dataset.appid;
            if (2 != parseInt(a)) switch (t) {
              case "no":
                break;

              default:
                wx.navigateTo({
                    url: t
                });
            } else wx.navigateToMiniProgram({
                appId: r,
                path: i
            });
        }
    }
});