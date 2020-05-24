Component({
    properties: {
        is_tip_collect: {
            type: Boolean
        },
        is_map: {
            type: Boolean
        },
        top: {
            type: Number
        }
    },
    data: {},
    methods: {
        closeTip: function() {
            this.setData({
                is_tip_collect: !1
            }), wx.setStorageSync("is_tip_collect", !0);
        }
    }
});