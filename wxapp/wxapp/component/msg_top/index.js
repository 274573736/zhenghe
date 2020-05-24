var _home = require("../../modules/home"), homeModule = new _home.home();

Component({
    properties: {},
    data: {
        list: []
    },
    lifetimes: {
        attached: function() {
            var t = this;
            homeModule.getMsgList("userMessage", {
                page: 1,
                type: 1
            }).then(function(e) {
                t.setData({
                    list: e
                });
            }, function(e) {});
        },
        detached: function() {}
    },
    methods: {
        toDetail: function(e) {
            wx.navigateTo({
                url: "../protocol/protocol?id=" + e.currentTarget.dataset.id + "&title=系统消息&system_index=1"
            });
        }
    }
});