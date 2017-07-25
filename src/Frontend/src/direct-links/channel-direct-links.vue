<template>
    <div class="list-group">
        <div class="list-group-item text-center"
            v-if="loadingDirectLinks">
            <button-loading-dots></button-loading-dots>
        </div>
        <div class="list-group-item clearfix"
            v-else
            v-for="directLink in directLinks">
            <on-off-switch v-model="directLink.enabled" class="pull-right"></on-off-switch>
        </div>
        <div class="list-group-item no-padding"
            v-show="!loadingDirectLinks">
            <button type="button"
                class="btn btn-default btn-block no-border"
                @click="addNewLink()">
                <button-loading-dots v-if="addingNewLink"></button-loading-dots>
                <span v-else>
                    <i class="pe-7s-plus"></i>
                    {{ $t('Add') }}
                </span>
            </button>
        </div>
    </div>
</template>

<script>
    import ButtonLoadingDots from "../common/button-loading-dots.vue";
    import OnOffSwitch from "./on-off-switch.vue";

    export default {
        components: {ButtonLoadingDots, OnOffSwitch},
        props: ['channel'],
        data() {
            return {
                directLinks: [],
                loadingDirectLinks: true,
                addingNewLink: false,
            };
        },
        mounted() {
            this.loadChannelDirectLinks();
        },
        methods: {
            loadChannelDirectLinks() {
                this.loadingDirectLinks = true;
                this.$http.get(`channel/${this.channel.id}/direct`).then(({body: directLinks}) => {
                    this.directLinks = directLinks;
                }).finally(() => this.loadingDirectLinks = false);
            },
            addNewLink() {
                this.addingNewLink = true;
                this.$http.post(`channel/${this.channel.id}/direct`).then(({directLink}) => {
                    this.directLinks.push(directLink);
                });
            }
        },
        watch: {
            device: 'loadChannelDirectLinks',
        }
    };
</script>
