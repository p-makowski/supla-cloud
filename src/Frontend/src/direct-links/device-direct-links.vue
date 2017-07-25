<template>
    <div>
        <loader-dots v-if="loadingChannels"></loader-dots>
        <div v-else
            class="row">
            <div class="col-md-6"
                v-for="channel in channels">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="badge pull-right id">ID{{channel.id}}</span>
                        <h4>{{ channel.caption || $t(channel.functionEnum.caption) }}</h4>
                    </div>
                    <channel-direct-links :channel="channel"></channel-direct-links>
                </div>
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
