var _home = require("../../../modules/home"), homeModule = new _home.home();

Component({
    properties: {
        fahuo: {
            type: Object
        },
        shouhuo: {
            type: Object
        },
        type: {
            type: Number
        }
    },
    data: {
        time_bg: !0,
        is_address: 0,
        xTime: {},
        isImmediately: 0
    },
    methods: {
        getAddress: function(e) {
            if (1 == this.data.type) {
                var t = e.currentTarget.dataset.id, i = 0;
                wx.setStorageSync("address_type", t), 0 == t && (i = 1), wx.navigateTo({
                    url: "/sundries/make_freight/address_driver/address_driver?id=" + t + "&is_phone=" + i + "&is_all=1"
                });
            }
        },
        sTime: function(e) {
            var i = this, t = e.detail.select;
            if (1 == t) {
                this.setData({
                    day: e.detail.day,
                    hour: e.detail.hour,
                    minute: e.detail.minute,
                    isImmediately: e.detail.isImmediately,
                    time_bg: !0
                });
                var a = e.detail.hour;
                "立即取货" != e.detail.hour && (a = e.detail.day + " " + e.detail.hour + ":" + e.detail.minute), 
                this.triggerEvent("updateTime", {
                    time: a
                }, {});
            } else 2 == t ? this.setData({
                time_bg: !0
            }) : homeModule.getTime().then(function(e) {
                var t = homeModule.date(e.days, e.hours, e.minutes, 5);
                i.setData({
                    xTime: t,
                    time_bg: !1
                });
            }, function(e) {});
        }
    }
});