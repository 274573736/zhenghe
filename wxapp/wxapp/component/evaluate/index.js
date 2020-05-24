var _home = require("../../modules/home"), app = getApp(), homeModule = new _home.home();

Component({
    properties: {
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
    data: {
        star_num: -1,
        evaluete: [ "服务好", "速度快", "服装整齐", "服务差", "速度慢", "着装不齐" ],
        evaluete_key: [ 0, 0, 0, 0, 0, 0 ]
    },
    methods: {
        bindStar: function(e) {
            var t = e.currentTarget.dataset.id;
            this.setData({
                star_num: t
            });
        },
        bindEvaluete: function(e) {
            var t = e.currentTarget.dataset.id, a = this.data.evaluete_key;
            0 == a[t] ? a[t] = 1 : a[t] = 0, this.setData({
                evaluete_key: a
            });
        },
        evaluateBtn: function() {
            var u = this, e = this.data.star_num, t = this.data.evaluete, a = this.data.evaluete_key;
            if (e <= -1) return app.hint("亲，您还没有点星星哟");
            for (var r = [], n = 0; n < a.length; n++) 1 == a[n] && r.push(t[n]);
            if (console.log(r), r.length < 1) return app.hint("亲，您还没有评价哟");
            var i = this.properties.evaluete_data.order_id;
            r = r.join("|"), i && homeModule.evaluete("setComment", {
                order_id: i,
                star_num: e,
                evaluete_value: r
            }).then(function(e) {
                var t = e.status, a = e.star_num, r = e.evaluete_value;
                u.triggerEvent("evalutete", {
                    status: t,
                    star_num: a,
                    evaluete_value: r
                }, {}), app.hint("谢谢您的支持", "success");
            }, function(e) {});
        },
        orderStatusBox: function() {
            this.triggerEvent("orderStatusBox", {}, {});
        },
        againOrder: function() {
            this.triggerEvent("againOrder", {}, {});
        }
    }
});