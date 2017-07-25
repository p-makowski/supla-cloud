<template>
    <div class="list-group">
        <div class="list-group-item"
            v-for="directLink in directLinks">
            <div class="text-center"></div>
        </div>
        <div class="list-group-item no-padding">
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

    export default {
        components: {ButtonLoadingDots},
        props: ['channel'],
        data() {
            return {
                directLinks: [],
                loadingDirectLinks: true,
                addingNewLink: false,
            };
        },
        mounted() {
            this.loadDeviceChannels();
        },
        methods: {
            loadChannelDirectLinks() {
//                this.loadingChannels = true;
//                this.$http.get(`iodev/${this.device.id}/channels`).then(({body: channels}) => {
//                    this.channels = channels;
//                }).finally(() => this.loadingChannels = false);
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
