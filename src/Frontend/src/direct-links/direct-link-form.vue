<template>
    <div>
        <on-off-switch v-model="directLink.enabled"
            class="pull-right"
            @input="updateDirectLink()"></on-off-switch>
        <div class="form-group">
            <label>Allowed actions</label>
            <div>
                <on-off-switch v-model="directLink.allowedActions"
                    v-for="action in directLink.channel.functionEnum.possibleActions"
                    :label="action.caption"
                    :true-value="action.value"
                    @input="updateDirectLink()"></on-off-switch>
            </div>
        </div>
    </div>
</template>

<script>
    import OnOffSwitch from "./on-off-switch.vue";
    import debounce from "debounce";

    export default {
        props: ['directLink'],
        components: {OnOffSwitch},
        methods: {
            updateDirectLink: debounce(function() {
                this.$http.put(`channel/${this.directLink.channel.id}/direct/${this.directLink.id}`, this.directLink);
            }, 1000),
        }
//        methods: {
//            updateAllowedActions: function () {
//                this.directLink.allowedActions = [];
//                for (let action in this.allowedActions) {
//                    if (this.allowedActions[action]) {
//                        this.directLinks.allowedActions.push(action);
//                    }
//                }
//            }
//        }
    };
</script>
