Component({
    properties: {
        order_status_box_close: {
            type: Boolean
        },
        order_status: {
            type: Number
        },
        riders: {
            type: Object
        },
        add_time: {
            type: String
        },
        img_url: {
            type: String
        },
        charg_type: {
            type: Number
        }
    },
    data: {},
    methods: {
        orderStatusBoxClose: function() {
            this.setData({
                order_status_box_close: !0
            });
        }
    }
});