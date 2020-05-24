var app = getApp();

Component({
    properties: {
        polyline: {
            type: Array
        },
        latitude: {
            type: Float32Array
        },
        longitude: {
            type: String
        },
        markers: {
            type: Array
        },
        map_height: {
            type: Number
        },
        pick_code: {
            type: Number
        },
        img_url: {
            type: String
        },
        order: {
            type: Object
        },
        first_post_data: {
            type: Number
        },
        socket_open: {
            type: Boolean,
            observer: function(t, e, a) {
                t && this.markerMove();
            }
        }
    },
    data: {},
    lifetimes: {
        attached: function() {
            this.map = wx.createMapContext("map", this);
        },
        detached: function() {}
    },
    pageLifetimes: {
        show: function() {
            this.markerMove();
        }
    },
    methods: {
        location: function() {
            this.triggerEvent("refreshData", {}, {});
        },
        markerMove: function(t) {
            var e = this, a = setInterval(function() {
                e.data.first_post_data && (clearInterval(a), app.listenWs(function(t) {
                    "rider_position" == (t = JSON.parse(t)).type && e.map.translateMarker({
                        markerId: 3,
                        destination: {
                            longitude: t.lng,
                            latitude: t.lat
                        },
                        autoRotate: !1,
                        rotate: 0,
                        duration: 1e3
                    });
                }));
            }, 100);
        }
    }
});