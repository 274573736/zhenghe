var cityData = require("../../../utils/city.js");

Page({
    data: {
        lists: [],
        touchmove: !1,
        touchmoveIndex: -1,
        titleHeight: 0,
        indexBarHeight: 0,
        indexBarItemHeight: 0,
        scrollViewId: "",
        winHeight: 0,
        inputShowed: !1,
        inputVal: "",
        hotCity: [ "北京", "上海", "广州", "深圳", "杭州", "长沙", "武汉", "厦门", "西安", "昆明", "成都", "重庆" ],
        searchResult: [],
        localCity: ""
    },
    onLoad: function(t) {
        var i = this;
        wx.getStorage({
            key: "localCity",
            success: function(t) {
                i.setData({
                    localCity: t.data
                });
            }
        }), setTimeout(function() {
            wx.getSystemInfo({
                success: function(t) {
                    var e = t.windowHeight, a = e - t.windowWidth / 750 * 204;
                    i.setData({
                        winHeight: e,
                        indexBarHeight: a,
                        indexBarItemHeight: a / 25,
                        titleHeight: t.windowWidth / 750 * 132,
                        lists: cityData.list
                    });
                }
            });
        }, 50);
    },
    showInput: function() {
        this.setData({
            inputShowed: !0
        });
    },
    clearInput: function() {
        this.setData({
            inputVal: "",
            inputShowed: !1,
            searchResult: []
        }), wx.hideKeyboard();
    },
    inputTyping: function(t) {
        var e = this;
        this.setData({
            inputVal: t.detail.value
        }, function() {
            e.searchCity();
        });
    },
    searchCity: function() {
        var a = this, i = [];
        cityData.list.forEach(function(t, e) {
            t.data.forEach(function(t, e) {
                -1 !== t.keyword.indexOf(a.data.inputVal.toLocaleUpperCase()) && i.push(t.cityName);
            });
        }), this.setData({
            searchResult: i
        });
    },
    selectCity: function(t) {
        var e = t.currentTarget.dataset.name, a = getCurrentPages();
        a[a.length - 2];
        wx.setStorage({
            key: "cityName",
            data: e
        }), wx.navigateBack({
            delta: 1
        });
    },
    touchStart: function(t) {
        this.setData({
            touchmove: !0
        });
        var e = t.touches[0].pageY, a = Math.floor((e - this.data.titleHeight) / this.data.indexBarItemHeight), i = this.data.lists[0 === a ? 1 : a];
        i && this.setData({
            scrollViewId: i.letter,
            touchmoveIndex: a
        });
    },
    touchMove: function(t) {
        var e = t.touches[0].pageY, a = Math.floor((e - this.data.titleHeight) / this.data.indexBarItemHeight), i = this.data.lists[0 === a ? 1 : a];
        i && (this.setData({
            scrollViewId: i.letter,
            touchmoveIndex: a
        }), console.log(a));
    },
    touchEnd: function() {
        this.setData({
            touchmove: !1,
            touchmoveIndex: -1
        });
    },
    touchCancel: function() {
        this.setData({
            touchmove: !1,
            touchmoveIndex: -1
        });
    }
});