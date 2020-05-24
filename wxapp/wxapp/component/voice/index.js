var _setting = require("../../modules/setting"), settingModule = new _setting.setting(), recorderManager = wx.getRecorderManager(), innerAudioContext = wx.createInnerAudioContext(), app = getApp();

Component({
    properties: {
        lu_btn: {
            type: Number
        }
    },
    data: {
        start_Y: 0,
        voice_bg: !0,
        voice_url: "",
        play: !0,
        play_show: !1,
        audio_url: "",
        showAnimation: !1
    },
    lifetimes: {
        attached: function() {}
    },
    methods: {
        closeBtn: function() {
            this.sVoice(2, "");
        },
        end: function(t) {
            var e = this, n = 1;
            if (0 < this.data.start_Y && 100 < this.data.start_Y - t.changedTouches[0].clientY) return recorderManager.stop(), 
            n = 2, this.setData({
                start_Y: 0
            }), this.sVoice(n, ""), app.hint("取消录音~", "success");
            this.setData({
                start_Y: 0
            }), recorderManager.stop(), recorderManager.onStop(function(t) {
                e.sVoice(n, t.tempFilePath, t.duration);
            });
        },
        longTatch: function(e) {
            var n = this;
            recorderManager.start({
                duration: 6e4,
                sampleRate: 44100,
                numberOfChannels: 1,
                encodeBitRate: 192e3,
                format: "mp3",
                frameSize: 50
            }), settingModule.auth(3).then(function(t) {
                t ? recorderManager.onStart(function() {
                    console.log("recorder start"), n.setData({
                        start_Y: e.changedTouches[0].clientY
                    });
                }) : n.setLocationAuth();
            }, function(t) {});
        },
        setLocationAuth: function() {
            wx.showModal({
                title: "录音授权请求",
                content: "需要开启录音权限才能录音",
                success: function(t) {
                    t.confirm ? wx.openSetting({
                        success: function(t) {}
                    }) : t.cancel;
                }
            });
        },
        playMusic: function() {
            var t = this;
            this.data.voice_url && (innerAudioContext.src = this.data.voice_url, innerAudioContext.play(), 
            innerAudioContext.onPlay(function() {
                console.log("开始播放"), t.setData({
                    play: !1
                });
            }), innerAudioContext.onEnded(function() {
                console.log("监听停止"), t.setData({
                    play: !0
                });
            }), innerAudioContext.onError(function(t) {
                console.log(t.errMsg), console.log(t.errCode);
            }));
        },
        pauseMusic: function() {
            innerAudioContext.pause(), this.setData({
                play: !0
            });
        },
        clearMusic: function() {
            this.setData({
                play: !0,
                play_show: !1,
                auto_url: "",
                voice_url: ""
            }), this.triggerEvent("voiceUrl", {
                audio_url: ""
            }, {});
        },
        sVoice: function(t) {
            var e = this, n = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "", o = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0;
            1 == t ? (wx.showLoading({
                title: "上传中"
            }), this.uploadImg(n, o)) : 2 == t ? this.setData({
                voice_bg: !0,
                showAnimation: !1
            }) : this.setData({
                voice_bg: !1
            }, function() {
                setTimeout(function() {
                    e.setData({
                        showAnimation: !0
                    });
                }, 100);
            });
        },
        uploadImg: function(o) {
            var a = this, i = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0, t = app.util.url("entry/wxapp/uploadAudio", {
                m: "make_speed"
            });
            wx.uploadFile({
                url: t,
                filePath: o,
                header: {
                    "Content-Type": "multipart/form-data"
                },
                name: "file",
                success: function(t) {
                    var e = JSON.parse(t.data), n = parseInt(i / 1e3);
                    a.setData({
                        voice_url: o,
                        play: !0,
                        voice_bg: !0,
                        play_show: !0,
                        audio_url: e.path,
                        duration: n
                    }), a.triggerEvent("voiceUrl", {
                        audio_url: e.path
                    }, {});
                },
                fail: function(t) {
                    app.hint("上传失败");
                },
                complete: function() {
                    wx.hideLoading();
                }
            });
        }
    }
});