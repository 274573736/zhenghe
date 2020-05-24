Component({
    properties: {
        hidden: {
            type: Boolean
        }
    },
    data: {
        year: [],
        month: [],
        day: [],
        value: [ 0, 0, 0 ]
    },
    lifetimes: {
        attached: function() {
            this.initTime();
        },
        detached: function() {}
    },
    methods: {
        confirmBtn: function() {
            var t = this.data.value, e = this.data.year[t[0]] + "-" + this.data.month[t[1]] + "-" + this.data.day[t[2]];
            this.triggerEvent("confirmDate", {
                time: e,
                select: 1
            }, {});
        },
        closeBtn: function() {
            this.triggerEvent("confirmDate", {
                select: 2
            }, {});
        },
        pickerTime: function(t) {
            this.setData({
                value: t.detail.value
            });
        },
        initTime: function() {
            for (var t = this, e = new Date(), a = e.getFullYear(), i = e.getMonth(), n = e.getDate(), o = [], s = 0; s < 20; s++) o.push(a - s);
            for (var r = [], h = 1; h <= 31; h++) r.push(h);
            for (var u = [], c = 1; c <= 12; c++) u.push(c);
            this.setData({
                year: o,
                day: r,
                month: u
            }), setTimeout(function() {
                t.setData({
                    value: [ 0, i, n - 1 ]
                });
            });
        }
    }
});