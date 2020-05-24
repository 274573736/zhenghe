Component({
    properties: {
        floor: {
            type: Array
        },
        hidden: {
            type: Boolean,
            observer: function(t, o, e) {
                var i = this;
                t ? this.setData({
                    showAnimation: !1
                }) : setTimeout(function() {
                    i.setData({
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
            var o = this.data.floor;
            o[0] < 0 && (o[0] = 0), this.triggerEvent("sFloor", {
                select: 1,
                floor: o
            }, {});
        },
        pickerTime: function(t) {
            this.setData({
                floor: t.detail.value
            });
        },
        closeBtn: function() {
            this.triggerEvent("sFloor", {
                select: 2
            }, {});
        }
    }
});