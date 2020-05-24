Component({
    properties: {
        star_num: {
            type: Number
        },
        evaluete_value: {
            type: Array
        },
        evaluete_data: {
            type: Object
        },
        riders: {
            type: Object
        },
        img_url: {
            type: String
        },
        order_type: {
            type: Number
        }
    },
    data: {},
    methods: {
        orderStatusBox: function() {
            this.triggerEvent("orderStatusBox", {}, {});
        },
        againOrder: function() {
            console.log(99555), this.triggerEvent("againOrder", {}, {});
        }
    }
});