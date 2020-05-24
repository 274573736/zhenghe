Component({
    properties: {
        sex: {
            type: Array
        },
        hidden: {
            type: Boolean,
            observer: function(t, e, i) {
                var s = this;
                t ? this.setData({
                    showAnimation: !1
                }) : setTimeout(function() {
                    s.setData({
                        showAnimation: !0
                    });
                }, 100);
            }
        }
    },
    data: {
        time_bg: !0,
        showAnimation: !1
    },
    methods: {
        confirmBtn: function(t) {
            var e = this.data.sex;
            this.triggerEvent("sSex", {
                select: 1,
                sex: e
            }, {});
        },
        pickerTime: function(t) {
            this.setData({
                sex: t.detail.value
            });
        },
        closeBtn: function() {
            this.triggerEvent("sSex", {
                select: 2
            }, {});
        }
    }
});