<template>
    <div>
        <div class="form-group">
            <label>{{ $t('Subject') }}</label>
            <select class="form-control"
                ref="channelsDropdown"
                :data-placeholder="$t('choose the channel')"
                v-model="channel">
                <option v-for="channel in userChannels"
                    :value="channel.id">
                    {{ channelTitle(channel) }}
                </option>
            </select>
        </div>
        <div v-if="chosenChannel">
            <div v-for="possibleAction in chosenChannel.function.possibleActions">
                <div class="radio">
                    <label>
                        <input type="radio"
                            :value="possibleAction.value"
                            v-model="action">
                        {{ $t(possibleAction.caption) }}
                    </label>
                </div>
                <span v-if="possibleAction.value == 50 && action == possibleAction.value">
                    <rolette-shutter-partial-percentage v-model="actionParam"></rolette-shutter-partial-percentage>
                </span>
                <span v-if="possibleAction.value == 80 && action == possibleAction">
                    <rgbw-parameters-setter v-model="actionParam" :channel-function="chosenChannel.function.value"></rgbw-parameters-setter>
                </span>
            </div>
        </div>
        <modal v-if="userChannels === undefined"
            class="modal-warning"
            @close="goToSchedulesList()"
            :header="$t('You have no devices that can be added to the schedule')">
            {{ $t('You will be redirected back to the schedules list now.') }}
        </modal>
    </div>
</template>

<script>
    import Vue from "vue";
    import "chosen-js";
    import "bootstrap-chosen/bootstrap-chosen.css";
    import RgbwParametersSetter from "./rgbw-parameters-setter.vue";
    import RoletteShutterPartialPercentage from "./rolette-shutter-partial-percentage.vue";
    import {withBaseUrl} from "../../../common/filters";

    export default {
        name: 'schedule-form-action-chooser',
        components: {RgbwParametersSetter, RoletteShutterPartialPercentage},
        data() {
            return {
                userChannels: []
            };
        },
        mounted() {
            this.$http.get('account/schedulable-channels').then(({body}) => {
                if (body.userChannels.length) {
                    this.userChannels = body.userChannels;
                    Vue.nextTick(() => $(this.$refs.channelsDropdown).chosen().change((e) => {
                        this.channel = e.currentTarget.value;
                    }));
                } else {
                    this.userChannels = undefined;
                }
            });
        },
        methods: {
            channelTitle(channel) {
                return (channel.caption || this.$t(channel.function.caption)) + ` (${channel.device.location.caption} / ${channel.device.name})`;
            },
            goToSchedulesList() {
                window.location.assign(withBaseUrl('schedule'));
            }
        },
        computed: {
            chosenChannel() {
                return this.userChannels.filter(c => c.id == this.channel)[0];
            },
            channel: {
                get() {
                    Vue.nextTick(() => $(this.$refs.channelsDropdown).trigger("chosen:updated"));
                    return this.$store.state.channel;
                },
                set(channelId) {
                    this.$store.commit('updateChannel', channelId);
                    if (channelId && this.chosenChannel.function.possibleActions.length == 1) {
                        this.action = this.chosenChannel.function.possibleActions[0].value;
                    }
                }
            },
            action: {
                get() {
                    return this.$store.state.action;
                },
                set(action) {
                    this.$store.commit('updateAction', action);
                }
            },
            actionParam: {
                get() {
                    return this.$store.state.actionParam;
                },
                set(actionParam) {
                    this.$store.commit('updateActionParam', actionParam);
                }
            }
        }
    };
</script>
