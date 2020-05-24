var _animation, _address = require("../../modules/address"), _home = require("../../modules/home"), homeModule = new _home.home(), addressModule = new _address.address(), app = getApp();

Component({
    properties: {
        img_url: {
            type: String
        }
    },
    data: {
        address: "",
        animation: ""
    },
    lifetimes: {
        attached: function() {
            _animation = wx.createAnimation({
                duration: 400,
                timingFunction: "linear",
                delay: 0,
                transformOrigin: "50% 50% 0"
            }), this._animation = _animation;
        }
    },
    pageLifetimes: {
        show: function() {
            this.updateLocation();
        }
    },
    methods: {
        updateLocation: function() {
            var e = this;
            this._animation.rotate(220).step(), this._animation.rotate(0).step(), this.setData({
                animation: _animation.export()
            }), addressModule.getLocation().then(function(t) {
                e.setData({
                    latitude: t.latitude,
                    longitude: t.longitude
                }), app.globalData.address_auth = !0, e.getAddressDetail(t.latitude, t.longitude);
            }, function(t) {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userLocation"] || e.setLocationAuth();
                    }
                });
            });
        },
        setLocationAuth: function() {
            wx.showModal({
                title: "地址授权请求",
                content: "我们需要获取您当前所在的位置",
                success: function(t) {
                    t.confirm ? wx.openSetting({
                        success: function(t) {}
                    }) : t.cancel;
                }
            });
        },
        getAddressDetail: function(t, e) {
            var a = this, n = setInterval(function() {
                app.globalData.syStem.rider_tencent_key && (clearInterval(n), addressModule.getCity(t, e, 0, app.globalData.syStem.rider_tencent_key).then(function(t) {
                    wx.setStorageSync("rider_address", t), a.setData({
                        address: t.address
                    }), homeModule.postRiderPosition({
                        address: t.address,
                        lat: t.location.lat,
                        lng: t.location.lng
                    }).then(function(t) {}, function(t) {});
                }));
            }, 10);
        }
    }
});