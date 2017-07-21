<template>
    <div>
        <devices-carousel @select="deviceChanged"></devices-carousel>
        {{ device ? device.name : 'nie ma' }}
    </div>
</template>

<script>
    import DevicesCarousel from "./devices-carousel.vue";

    export default {
        components: {DevicesCarousel},
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
