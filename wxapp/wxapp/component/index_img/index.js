var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Component({
    properties: {
        index_img: {
            type: Boolean,
            value: !0
        },
        new_person: {
            type: Object
        },
        img_url: {
            type: String
        }
    },
    data: {},
    methods: {
        getRed: function(e) {
            var o = this, n = e.currentTarget.dataset.id;
            homeModule.getNewCoupons({
                coupon_id: n
            }).then(function(e) {
                wx.navigateTo({
                    url: "/make_speed/coupons/coupons"
                }), app.hint("成功领取" + o.data.new_person.money + "元优惠券~"), o.triggerEvent("closeIndexImg", "", "");
            }, function(e) {
                o.triggerEvent("closeIndexImg", "", "");
            });
        },
        closeIndex: function() {
            this.triggerEvent("closeIndexImg", "", "");
        }
    }
});