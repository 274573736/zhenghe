var _home = require("../../modules/home.js"), _address = require("../../modules/address"), addressModule = new _address.address(), homeModule = new _home.home(), app = getApp();

Component({
    properties: {
        data: {
            type: Object,
            value: {}
        },
        myCity: {
            type: String,
            value: "上海"
        },
        search: {
            type: String,
            value: "",
            observer: function(t, e) {
                this.value = t, this.searchMt();
            }
        }
    },
    data: {
        list: [],
        rightArr: [],
        jumpNum: "",
        city: ""
    },
    pageLifetimes: {
        show: function() {
            this.data.city || addressModule.getCurrentCity(this);
        }
    },
    ready: function() {
        var e = this;
        homeModule.getCity("city").then(function(t) {
            e.resetRight(t);
        }, function(t) {});
    },
    methods: {
        getCity: function() {
            addressModule.getCurrentCity(this);
        },
        resetRight: function(t) {
            var e = [];
            for (var i in t) e.push(t[i].title.substr(0, 1));
            this.setData({
                list: t,
                rightArr: e
            });
        },
        jumpMt: function(t) {
            var e = t.currentTarget.dataset.id;
            this.setData({
                jumpNum: e
            });
        },
        detailMt: function(t) {
            var e = t.currentTarget.dataset.detail;
            wx.setStorageSync("city", e), wx.navigateBack({
                delta: 1
            });
        },
        input: function(t) {
            this.value = t.detail.value;
        },
        searchMt: function() {
            this._search();
        },
        _search: function() {
            for (var t = this.data.data, e = [], i = 0; i < t.length; i++) {
                for (var a = [], r = 0; r < t[i].item.length; r++) if (-1 < t[i].item[r].name.indexOf(this.value)) {
                    var s = {};
                    for (var n in t[i].item[r]) s[n] = t[i].item[r][n];
                    a.push(s);
                }
                0 !== a.length && e.push({
                    title: t[i].title,
                    type: t[i].type ? t[i].type : "",
                    item: a
                });
            }
            this.resetRight(e);
        },
        locationMt: function(t) {
            addressModule.getCurrentCity(this), wx.navigateBack({
                delta: 1
            });
        }
    }
});