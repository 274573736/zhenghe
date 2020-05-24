var _home = require("../../modules/home"), _wechatMap = require("../../modules/wechatMap"), homeModule = new _home.home(), wechatMapModule = new _wechatMap.wechatMap(), app = getApp();

Component({
    properties: {
        type: {
            type: Number
        },
        fahuo: {
            type: Object
        },
        shouhuo: {
            type: Object
        }
    },
    data: {
        goods_idx: 0,
        all_goods_idx: 0,
        buy_remark: "",
        all_remark: ""
    },
    lifetimes: {
        attached: function() {
            this.getGoods(), this.getGoodsAll();
        }
    },
    pageLifetimes: {
        show: function() {}
    },
    methods: {
        homemakingBtn: function() {
            wx.navigateTo({
                url: "/sundries/homemaking/server_type/server_type"
            });
        },
        buyInput: function() {
            wx.navigateTo({
                url: "/make_speed/skin/help_buy_index/help_buy_index"
            });
        },
        allInput: function() {
            wx.navigateTo({
                url: "/make_speed/skin/all_powerful/all_powerful"
            });
        },
        allRemark: function(e) {
            this.setData({
                all_remark: e.detail.value
            });
        },
        buyRemark: function(e) {
            this.setData({
                buy_remark: e.detail.value
            });
        },
        toAddressCar: function(e) {
            var a = e.currentTarget.dataset.id;
            this.data.fahuo && wx.setStorageSync("fahuo", this.data.fahuo), wx.setStorageSync("address_type", a), 
            0 != a ? 1 != a ? wx.navigateTo({
                url: "/make_speed/address_driver/address_driver?id=" + a + "&skin=1"
            }) : wechatMapModule.openLocationMap(3, a, !0) : wx.navigateTo({
                url: "/make_speed/address_driver/address_driver?id=" + a + "&skin=1&is_all=1&is_phone=1"
            });
        },
        sGoodsAll: function(e) {
            this.setData({
                all_goods_idx: e.currentTarget.dataset.idx
            }), app.globalData.all_goods_idx = e.currentTarget.dataset.idx, app.globalData.all_remark = this.data.all_remark, 
            wx.navigateTo({
                url: "/make_speed/skin/all_powerful/all_powerful"
            });
        },
        getGoodsAll: function() {
            var a = this;
            homeModule.getGoodsList({
                order_type: 2
            }).then(function(e) {
                a.setData({
                    all_goods_list: e
                }), wx.setStorageSync("all_goods_list", e);
            }, function(e) {});
        },
        getGoods: function() {
            var a = this;
            homeModule.getGoodsList({
                order_type: 1
            }).then(function(e) {
                a.setData({
                    goods_list: e
                }), wx.setStorageSync("buy_goods_list", e);
            }, function(e) {});
        },
        sGoods: function(e) {
            this.setData({
                goods_idx: e.currentTarget.dataset.idx
            }), app.globalData.buy_goods_idx = e.currentTarget.dataset.idx, app.globalData.buy_remark = this.data.buy_remark, 
            wx.navigateTo({
                url: "/make_speed/skin/help_buy_index/help_buy_index"
            });
        },
        toAddress: function(e) {
            this.data.fahuo && wx.setStorageSync("fahuo", this.data.fahuo);
            var a = e.currentTarget.dataset.id;
            0 != a ? wx.navigateTo({
                url: "/make_speed/address/address?id=" + a + "&skin=1&is_all=1"
            }) : wx.navigateTo({
                url: "/make_speed/address/address?id=" + a + "&skin=1&is_all=1&is_phone=1"
            });
        },
        oftenAddress: function(e) {
            var a = e.currentTarget.dataset.id;
            wx.navigateTo({
                url: "/make_speed/address_resort/address_resort?type=" + a + "&skin=1&skin_type=" + this.data.type
            });
        }
    }
});