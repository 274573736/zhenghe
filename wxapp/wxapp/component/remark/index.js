Component({
    properties: {
        hidden: {
            type: Boolean,
            observer: function(t, e, a) {
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
        remark: {
            type: String
        }
    },
    data: {
        value: "",
        showAnimation: !1
    },
    methods: {
        textArea: function(t) {
            this.setData({
                value: t.detail.value
            });
        },
        confirmBtn: function(t) {
            var e = this.data.value;
            this.triggerEvent("sRemark", {
                select: 1,
                remark: e
            }, {});
        },
        closeBtn: function() {
            this.triggerEvent("sRemark", {
                select: 2
            }, {});
        }
    }
});