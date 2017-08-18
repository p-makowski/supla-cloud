<template>
    <div class="devices-carousel">
        <carousel v-if="devices !== undefined"
            :navigation-enabled="true"
            :pagination-enabled="false"
            navigation-next-label="&gt;"
            navigation-prev-label="&lt;"
            :per-page="4">
            <slide v-for="device in devices"
                :key="device.id">
                <a class="device"
                    :class="{'selected': selectedDevice == device}"
                    @click="onDeviceClick(device)">
                    <h3 class="name">{{ device.name }}</h3>
                    <div class="guid">{{ device.guid }}</div>
                    {{ $t('SoftVer') }} <strong>{{ device.softwareVersion }}</strong><br>
                    {{ $t('Location') }} <strong>{{ device.location.caption }}</strong>
                    <div v-if="device.comment"
                        class="comment">
                        {{ device.comment }}
                    </div>
                </a>
            </slide>
        </carousel>
        <loader-dots></loader-dots>
    </div>
</template>

<script>
    import {Carousel, Slide} from 'vue-carousel';
    import LoaderDots from "../common/loader-dots.vue"

    export default {
        components: {Carousel, Slide, LoaderDots},
        data() {
            return {
                selectedDevice: undefined,
                devices: undefined
            };
        },
        mounted() {
            this.$http.get('iodev').then(({body}) => {
                this.devices = body;
            });
        },
        methods: {
            onDeviceClick(device) {
                this.selectedDevice = device;
                this.$emit('select', device)
            }
        }
    };
</script>

<style lang="scss">
    .devices-carousel {
        .VueCarousel-navigation-button {
            background: black;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            color: white !important;
            text-align: center;
            font-size: 2em;
            line-height: 1.1em;
            font-family: 'Quicksand';
            &.VueCarousel-navigation-prev {
                left: -5px;
            }
            &.VueCarousel-navigation-next {
                right: -5px;
            }
        }
        .device {
            position: relative;
            display: block;
            background: #00D151;
            height: 240px;
            color: white;
            padding: 5px 10px;
            margin: 4px 5px 0 4px;
            &:hover, &:active {
                margin-top: 0;
                box-shadow: 0 4px 3px rgba(0, 0, 0, .6);
            }
            &:active {
                transform: scale(0.95);
            }
            &.selected {
                border: 2px solid black;
                &:after {
                    content: '';
                    position: absolute;
                    width: 52px;
                    height: 52px;
                    background: url('/assets/img/checked.svg');
                    top: -1px;
                    right: -1px;
                    border-top-right-radius: 3px;
                    transition: all .5s ease-in-out;
                    animation-duration: 0.5s;
                    animation-fill-mode: both;
                    animation-name: fadeIn;
                }
            }
            .guid {
                margin-top: 4px;
                margin-bottom: 4px;
                word-break: break-all;
                font-size: .9em;
            }
            .comment {
                margin-top: 4px;
                padding-top: 4px;
                border-top: solid 1px rgba(255, 255, 255, 0.6)
            }
        }
    }
</style>
