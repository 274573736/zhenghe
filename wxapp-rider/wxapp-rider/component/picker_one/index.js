Component({
    properties: {
        list: {
            type: Array
        },
        hidden: {
            type: Boolean
        }
    },
    data: {
        idx: 0
    },
    methods: {
        timeBj: function() {
            this.triggerEvent("cancel", {}, {});
        },
        picker: function(t) {
            var i = t.detail.value[0];
            this.setData({
                idx: i
            });
        },
        confirm: function() {
            var t = this.data.idx;
            this.triggerEvent("cancel", {
                idx: t
            }, {});
        }
    }
});