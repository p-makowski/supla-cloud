<template>
    <div>
        <loader-dots v-if="loadingChannels"></loader-dots>
        <div v-else>
            <div v-for="channel in channels">
                <channel-direct-links :channel="channel"></channel-direct-links>
            </div>
        </div>
    </div>
</template>

<script>
    import LoaderDots from "../common/loader-dots.vue";
    import ChannelDirectLinks from "./channel-direct-links.vue";

    export default {
        components: {LoaderDots, ChannelDirectLinks},
        props: ['device'],
        data() {
            return {
                channels: [],
                loadingChannels: true,
            };
        },
        mounted() {
            this.loadDeviceChannels();
        },
        methods: {
            loadDeviceChannels() {
                this.loadingChannels = true;
                this.$http.get(`iodev/${this.device.id}/channels`).then(({body: channels}) => {
                    this.channels = channels;
                }).finally(() => this.loadingChannels = false);
            }
        },
        watch: {
            device: 'loadDeviceChannels',
        }
    };
</script>
