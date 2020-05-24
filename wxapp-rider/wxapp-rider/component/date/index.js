var _home = require("../../modules/home.js"), homeModule = new _home.home();

Component({
    properties: {
        hidden: {
            type: Boolean
        }
    },
    data: {
        years: [ 2019 ],
        months: [ 1, 2 ],
        hours: [ 1, 5 ],
        time_bg: !0,
        value: [ 0, 0, 0 ]
    },
    methods: {
        getTime: function() {
            var i = this;
            homeModule.getTime("getTime").then(function(e) {
                var t = homeModule.date(e.days, e.hours, e.minutes);
                i.setData({
                    days: t.days,
                    hours: t.hours,
                    minutes: t.minutes
                });
            }, function(e) {});
        },
        pickerTime: function(e) {
            var t = e.detail.value, i = t[0], o = t[1];
            0 == i && o <= 1 && this.getTime(), 0 == i ? 1 < o && this.minute() : (this.minute(), 
            this.hour()), this.setData({
                value: t,
                a: i,
                b: o
            });
        },
        hour: function() {
            for (var e = [], t = 0; t < 24; t++) e.push(t + "点");
            this.setData({
                hours: e
            });
        },
        minute: function() {
            for (var e = [], t = 0; t < 60; t += 10) e.push(t);
            this.setData({
                minutes: e
            });
        },
        confirmBtn: function(e) {
            var t = this.data.value;
            this.triggerEvent("confirmTime", {
                timeValue: t
            }, {});
        },
        closeBtn: function() {
            this.triggerEvent("time_bg", {}, {});
        }
    }
});