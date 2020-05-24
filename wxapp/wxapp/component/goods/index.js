var app = getApp();

Component({
    properties: {
        list: {
            type: Array
        }
    },
    data: {},
    methods: {
        goodDetail: function(t) {
            var a = t.currentTarget.dataset.id;
            wx.navigateTo({
                url: "../goods_detail/goods_detail?id=" + a
            });
        }
    }
});