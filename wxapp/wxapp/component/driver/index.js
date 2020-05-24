var app = getApp();

Component({
    properties: {
        riders: {
            type: Object
        }
    },
    data: {
        img_url: app.globalData.img_url
    },
    methods: {
        tel: function(e) {
            var t = e.currentTarget.dataset.tel;
            t && wx.makePhoneCall({
                phoneNumber: t
            });
        }
    }
});