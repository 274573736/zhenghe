Component({
    properties: {},
    data: {},
    methods: {
        confirm: function() {
            this.triggerEvent("tip", {
                tip: 2
            }, {});
        }
    }
});