var app = getApp();

Component({
    properties: {
        order: {
            type: Object
        },
        img_url: {
            type: String
        },
        business_id: {
            type: Number
        }
    },
    data: {
        price_detail_bg: !0,
        price_detail: {},
        gy_discount: 0,
        business_type: []
    },
    lifetimes: {
        attached: function() {
            var e = this, t = setInterval(function() {
                app.globalData.syStem && (clearInterval(t), e.setData({
                    gy_discount: 100 * app.globalData.syStem.gy_discount,
                    business_type: app.globalData.syStem.business_type
                }));
            }, 10);
        },
        detached: function() {}
    },
    methods: {
        toPriceDetail: function() {
            var e = this.data.order, t = {};
            if (t.order_type = parseFloat(e.order_type), t.distance = parseFloat(e.distance), 
            t.tip_money = parseFloat(e.small_price), t.coupon_money = parseFloat(e.coupon_money), 
            t.night_price = parseFloat(e.night_price), t.actual_payment = parseFloat(e.pay_price), 
            t.weight = parseFloat(e.weight), t.change_price = parseFloat(e.change_price), t.discount_price = parseFloat(e.discount_price), 
            t.distance_price = parseFloat(e.distance_price), t.floor_price = parseFloat(e.floor_price) || 0, 
            t.weight_fee = parseFloat(e.weight_price) || 0, t.carload_fee = parseFloat(e.total_car) || 0, 
            t.cube_price = parseFloat(e.cube_price) || 0, t.volume = e.cube, 5 == e.order_type) return t.title = e.car_name, 
            t.starting_km = e.start_km, t.starting_price = e.start_price, wx.setStorageSync("price_detail", t), 
            void wx.navigateTo({
                url: "../price_des/price_des"
            });
            wx.setStorageSync("price_detail", t), wx.navigateTo({
                url: "../price_des/price_des"
            });
        },
        price_detail_bg: function() {
            this.setData({
                price_detail_bg: !0
            });
        },
        callTel: function() {
            var e = wx.getStorageSync("system");
            e.kefu_phone && wx.makePhoneCall({
                phoneNumber: e.kefu_phone
            });
        },
        indexBtn: function() {
            wx.reLaunch({
                url: "/make_speed/router/router"
            });
        },
        preImg: function(e) {
            var t = e.currentTarget.dataset.type, a = e.currentTarget.dataset.idx, r = this.data.order, i = [];
            i = 0 == t ? r.pick_img : 1 == t ? r.end_img : r.img, wx.previewImage({
                current: i[a],
                urls: i
            });
        }
    }
});