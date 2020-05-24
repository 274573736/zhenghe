var app = getApp();

Component({
    properties: {
        img_url: {
            type: String
        },
        underwayOrder: {
            type: Array
        }
    },
    data: {},
    methods: {
        orderDetail: function(r) {
            var e = r.currentTarget.dataset.idx;
            wx.setStorageSync("order_detail", this.properties.underwayOrder[e]), app.orderDetail();
        }
    }
});