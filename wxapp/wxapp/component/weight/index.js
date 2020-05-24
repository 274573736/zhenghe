var _home = require("../../modules/home.js"), homeModule = new _home.home();

Component({
    properties: {
        weight: {
            type: Array,
            value: [ 1, 2, 3 ]
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
            this.triggerEvent("sWeight", {
                select: 1
            }, {});
        },
        closeBtn: function() {
            this.triggerEvent("sWeight", {
                select: 2
            }, {});
        }
    }
});