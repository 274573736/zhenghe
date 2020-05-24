Component({
    properties: {
        tip: {
            type: Array,
            value: [ "不加小费", "1元", "3元", "5元", "7元", "10元", "20元", "其他" ]
        },
        hidden: {
            type: Boolean,
            observer: function(t, i, a) {
                var e = this;
                t ? this.setData({
                    showAnimation: !1
                }) : setTimeout(function() {
                    e.setData({
                        showAnimation: !0
                    });
                }, 100);
            }
        }
    },
    data: {
        other: !0,
        idx: 0,
        val: 0,
        showAnimation: !1
    },
    methods: {
        selected: function(t) {
            var i = t.currentTarget.dataset.idx;
            i == this.data.tip.length - 1 ? this.setData({
                other: !1
            }) : this.setData({
                other: !0
            }), this.setData({
                idx: i
            });
        },
        input: function(t) {
            var i = t.detail.value;
            this.setData({
                val: i
            });
        },
        confirmBtn: function(t) {
            var i = this.data.idx, a = 0;
            a = i == this.data.tip.length - 1 ? this.data.val : parseInt(this.data.tip[i]), 
            isNaN(a) && (a = 0);
            this.triggerEvent("sTip", {
                select: 1,
                tip_money: a
            }, {});
        },
        closeBtn: function() {
            this.triggerEvent("sTip", {
                select: 2
            }, {});
        }
    }
});