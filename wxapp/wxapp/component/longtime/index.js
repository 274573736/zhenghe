var _home = require("../../modules/home.js"), homeModule = new _home.home();

Component({
    properties: {
        weight: {
            type: Array,
            value: [ "10分钟", "30分钟", "1个小时", "1天" ]
        },
        hidden: {
            type: Boolean
        }
    },
    data: {
        time_bg: !0,
        value: [ 0 ]
    },
    methods: {
        confirmBtn: function(e) {
            this.triggerEvent("sLongtime", {
                select: 1
            }, {});
        },
        closeBtn: function() {
            this.triggerEvent("sLongtime", {
                select: 2
            }, {});
        }
    }
});