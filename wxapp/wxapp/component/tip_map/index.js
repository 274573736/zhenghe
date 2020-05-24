var app = getApp();

Component({
    properties: {
        hidden: {
            type: Boolean
        },
        standard: {
            type: []
        }
    },
    data: {
        tip: [ "不加小费", "2", "4", "6", "8", "10", "15", "20" ],
        idx: 0,
        other: !0
    },
    methods: {
        selected: function(t) {
            var e = t.currentTarget.dataset.idx;
            this.setData({
                idx: e
            });
        },
        confirm: function() {
            var t = this.data.idx, e = this.data.tip, a = 0;
            e && 0 < t && (a = parseFloat(e[t])), this.triggerEvent("tipSelected", {
                tip_money: a
            }, {});
        }
    }
});