var _home = require("../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        car_list: [],
        goods_imgs: "",
        goods_imgs_arr: [],
        car_arr: [],
        status: 0,
        is_register: 0,
        unfold: !1
    },
    onLoad: function(t) {
        var o = this;
        app.setNavigation(), this.setData({
            is_register: t.is_register || 0
        }), homeModule.getHomemakingList().then(function(t) {
            o.setData({
                car_list: t
            }), homeModule.homemakingInfo().then(function(t) {
                var a = t.category_id, n = [];
                if (a && -1 != a.indexOf(",")) for (var e = a.split(","), i = 0; i < e.length; i++) n[e[i]] = !0; else n[a] = !0;
                o.setData({
                    car_arr: n,
                    goods_imgs: t.docments,
                    goods_imgs_arr: t.img,
                    status: t.status
                });
            }, function(t) {});
        }, function(t) {});
    },
    onReady: function() {},
    onShow: function() {},
    unfoldBtn: function() {
        this.setData({
            unfold: !this.data.unfold
        });
    },
    applyBtn: function() {
        var n = this, t = this.data.car_arr, e = [];
        if (t.forEach(function(t, a) {
            t && e.push(a);
        }), e.length <= 0) return app.hint("请选择至少一种服务~");
        e = e.join(), homeModule.applyHomemaking({
            cate_ids: e,
            docments: this.data.goods_imgs
        }).then(function(t) {
            n.setData({
                is_update: 1
            }), app.hint("提交成功~");
            var a = app.globalData.syStem;
            wx.requestSubscribeMessage({
                tmplIds: [ a.audit_rider_tpl ],
                success: function(t) {
                    setTimeout(function() {
                        1 != n.data.is_register ? wx.navigateBack({
                            delta: 1
                        }) : wx.navigateTo({
                            url: "../train/train"
                        });
                    }, 400);
                },
                fail: function(t) {}
            });
        }, function(t) {});
    },
    selectCar: function(t) {
        var a = t.currentTarget.dataset.id, n = this.data.car_arr;
        n[a] = !n[a], this.setData({
            car_arr: n
        });
    },
    uploadImgs: function(t) {
        this.setData({
            goods_imgs: t.detail.imgs
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});