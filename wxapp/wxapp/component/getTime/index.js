var _home = require("../../modules/home.js"), homeModule = new _home.home();

Component({
    properties: {
        days: {
            type: Array
        },
        hours: {
            type: Array
        },
        minutes: {
            type: Array
        },
        hidden: {
            type: Boolean,
            observer: function(t, e, s) {
                var i = this;
                t ? this.setData({
                    showAnimation: !1
                }) : setTimeout(function() {
                    i.setData({
                        showAnimation: !0
                    });
                }, 100);
            }
        },
        order_type: {
            type: Number
        }
    },
    data: {
        time_bg: !0,
        value: [ 0, 0, 0 ],
        showAnimation: !1
    },
    methods: {
        getTime: function() {
            var s = this;
            homeModule.getTime().then(function(t) {
                var e = homeModule.date(t.days, t.hours, t.minutes, s.data.order_type);
                s.setData({
                    days: e.days,
                    hours: e.hours,
                    minutes: e.minutes
                });
            });
        },
        pickerTime: function(t) {
            var e = t.detail.value, s = e[0], i = e[1];
            0 == s && i <= 1 && this.getTime(), 0 == s ? 1 < i && this.minute() : (this.minute(), 
            this.hour()), this.setData({
                value: e,
                a: s,
                b: i
            });
        },
        hour: function() {
            for (var t = [], e = 0; e < 24; e++) {
                var s = e;
                e < 10 && (s = "0" + e), t.push(s + "点");
            }
            this.setData({
                hours: t
            });
        },
        minute: function() {
            for (var t = [], e = 0; e < 60; e += 10) {
                var s = e;
                e < 10 && (s = "0" + e), t.push(s);
            }
            this.setData({
                minutes: t
            });
        },
        confirmBtn: function(t) {
            var e = this.data.value, s = 1, i = this.data.days[e[0]], a = "", o = this.data.hours[e[1]];
            "立即取件" != o && "立即帮买" != o && "立即" != o && "立即取货" != o ? ((o = parseInt(this.data.hours[e[1]])) < 10 && (o = "0" + o), 
            (a = parseInt(this.data.minutes[e[2]])) < 10 && (a = "0" + a)) : s = 0;
            this.triggerEvent("sTime", {
                day: i,
                hour: o,
                minute: a,
                isImmediately: s,
                select: 1
            }, {});
        },
        closeBtn: function() {
            this.triggerEvent("sTime", {
                select: 2
            }, {});
        }
    }
});