<template>
    <div>
        <div class="text-center"
            v-if="loadingDirectLinks">
            <button-loading-dots></button-loading-dots>
        </div>
        <div v-else>
            <button type="button"
                class="btn btn-default pull-right"
                @click="addNewLink()">
                <button-loading-dots v-if="addingNewLink"></button-loading-dots>
                <span v-else>
                    <i class="pe-7s-plus"></i>
                    {{ $t('Add') }}
                </span>
            </button>
            <h3>
                {{ channel.caption || $t(channel.functionEnum.caption) }}
            </h3>

            <div class="row">
                <div class="col-xs-12">
                    <div class="list-group">
                        <div class="list-group-item"
                            v-for="directLink in directLinks">
                            <direct-link-form :direct-link="directLink"></direct-link-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ButtonLoadingDots from "../common/button-loading-dots.vue";
    import DirectLinkForm from "./direct-link-form.vue";

    export default {
        components: {ButtonLoadingDots, DirectLinkForm},
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
                this.$http.post(`channel/${this.channel.id}/direct`).then(({body: directLink}) => {
                    this.directLinks.push(directLink);
                }).finally(() => this.addingNewLink = false);
            }
        },
        watch: {
            device: 'loadChannelDirectLinks',
        }
    };
</script>
