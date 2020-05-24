var _home = require("../../../modules/home"), homeModule = new _home.home(), app = getApp();

Page({
    data: {
        type: 0,
        name: "",
        tel: "",
        address: "",
        uid: "",
        sex: [ 0 ],
        sex_bg: !0
    },
    onLoad: function(t) {
        var a = this, e = t.id ? t.id : 0;
        this.setData({
            id: e
        }), 0 < e && homeModule.staffEdit({
            info: 1,
            id: e
        }).then(function(t) {
            a.setData({
                name: t.username,
                tel: t.mobile,
                sex: "男" == t.sex ? [ 0 ] : [ 1 ],
                address: t.home_address,
                uid: t.user_id
            });
        }, function(t) {});
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    onHide: function() {},
    sSex: function(t) {
        var a = t.detail.select, e = t.detail.sex;
        1 == a && this.setData({
            sex: e
        }), this.setData({
            sex_bg: !0
        });
    },
    Sex: function() {
        this.setData({
            sex_bg: !1
        });
    },
    delStaff: function() {
        homeModule.staffDel({
            id: this.data.id
        }).then(function(t) {
            app.hint("删除成功~"), setTimeout(function() {
                wx.navigateBack({
                    delta: 1
                });
            }, 400);
        }, function(t) {});
    },
    addStaff: function() {
        return this.data.name ? this.data.tel ? this.data.uid ? void homeModule.staffAdd({
            name: this.data.name,
            phone: this.data.tel,
            sex: 0 == this.data.sex[0] ? "男" : "女",
            address: this.data.address,
            uid: this.data.uid,
            id: app.globalData.business_id
        }).then(function(t) {
            app.hint("添加成功~"), setTimeout(function() {
                wx.navigateBack({
                    delta: 1
                });
            }, 400);
        }, function(t) {}) : app.hint("uid不能为空~") : app.hint("电话号码不能为空~") : app.hint("姓名不能为空~");
    },
    saveStaff: function() {
        return this.data.name ? this.data.tel ? this.data.uid ? void homeModule.staffEdit({
            name: this.data.name,
            phone: this.data.tel,
            uid: this.data.uid,
            sex: 0 == this.data.sex[0] ? "男" : "女",
            address: this.data.address,
            id: this.data.id
        }).then(function(t) {
            app.hint("修改成功~"), setTimeout(function() {
                wx.navigateBack({
                    delta: 1
                });
            }, 400);
        }, function(t) {}) : app.hint("uid不能为空~") : app.hint("电话号码不能为空~") : app.hint("姓名不能为空~");
    },
    Name: function(t) {
        this.setData({
            name: t.detail.value
        });
    },
    Tel: function(t) {
        this.setData({
            tel: t.detail.value
        });
    },
    Uid: function(t) {
        this.setData({
            uid: t.detail.value
        });
    },
    Address: function(t) {
        this.setData({
            address: t.detail.value
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});