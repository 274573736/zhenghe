Component({
    properties: {
        hidden: {
            type: Boolean
        },
        price_detail: {
            type: Object
        },
        img_url: {
            type: String
        }
    },
    data: {},
    methods: {
        close: function() {
            this.triggerEvent("price_detail_bg", {}, {});
        },
        priceDescription: function() {
            wx.navigateTo({
                url: "../protocol/protocol?title=价格说明&type=user_price"
            });
        }
    }
});