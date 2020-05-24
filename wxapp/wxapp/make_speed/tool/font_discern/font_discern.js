var app = getApp();

Page({
    data: {
        placeholder: "请将复制的地址信息粘贴于此，自动识别地址，电话，人名。例：江南万达x座xxx号，13000000000，龙先生",
        id: 0
    },
    onLoad: function(e) {
        this.setData({
            id: e.id || 0
        });
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {},
    confirm: function(e) {
        var n = e.detail.value.content;
        if (!n) return app.hint("识别内容不能为空~");
        n = n.trim();
        var t = /1(3|4|5|6|7|8|9)\d{9}/.exec(n);
        if (!t) return app.hint("识别不到电话~");
        if (t[0]) {
            var o = n.replace(/\s+/g, ""), a = o.split(",") || o.split("，");
            if (3 != a.length && (a = o.split("，")), 3 == a.length ? console.log(1) : 3 == n.split("/s+/").length ? (console.log(2), 
            a = n.split("/s+/")) : 2 == o.split(t[0]).length && (console.log(3), (a = o.split(t[0])).push(t[0])), 
            3 != a.length) return app.hint("识别失败~");
            if (!this.save(a)) return app.hint("识别失败~");
        }
    },
    save: function(e) {
        var n = /1(3|4|5|6|7|8|9)\d{9}/, t = "", o = "";
        console.log(e);
        for (var a = 0; a < 3; a++) if (n.test(e[a])) {
            if (console.log("进了"), 0 == a ? (t = e[1].length > e[2].length ? e[1] : e[2], o = e[1].length < e[2].length ? e[1] : e[2]) : 1 == a ? (t = e[0].length > e[2].length ? e[0] : e[2], 
            o = e[0].length < e[2].length ? e[0] : e[2]) : (t = e[1].length > e[0].length ? e[1] : e[0], 
            o = e[1].length < e[0].length ? e[1] : e[0]), 0 == this.data.id) {
                var s = wx.getStorageSync("fahuo");
                s.name || (s = {}), s.person_address = t, s.person_name = o, s.person_tel = e[a], 
                wx.setStorageSync("fahuo", s);
            } else {
                var i = wx.getStorageSync("shouhuo");
                i.name || (i = {}), i.person_address = t, i.person_name = o, i.person_tel = e[a], 
                wx.setStorageSync("shouhuo", i);
            }
            return wx.navigateTo({
                url: "/make_speed/search_address/search_address?id=" + this.data.id + "&content=" + t
            }), t;
        }
        return !1;
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});