<template>
    <div>
        <div class="form-group">
            <devices-carousel @select="deviceChanged"></devices-carousel>
        </div>
        <device-direct-links v-if="device"
            :device="device"></device-direct-links>
    </div>
</template>

<script>
    import DevicesCarousel from "./devices-carousel.vue";
    import DeviceDirectLinks from "./device-direct-links.vue"

    export default {
        components: {DevicesCarousel, DeviceDirectLinks},
        data() {
            return {
                device: null,
            };
        },
        methods: {
            deviceChanged(device) {
                this.device = device;
            }
        }
    };
</script>
