Component({
    properties: {},
    data: {},
    methods: {
        toOrder: function() {
            this.triggerEvent("againOrder", {}, {});
        }
    }
});