<template>
    <switches v-model="onoff"
        theme="bulma"
        type-bold="true"
        color="green"
        emit-on-mount="false"
        :text-enabled="$t(labelEnabled)"
        :text-disabled="$t(labelDisabled)"></switches>
</template>

<script>
    import Switches from 'vue-switches';

    export default {
        components: {Switches},
        props: ['value', 'label', 'trueValue'],
        data() {
            return {
                labelEnabled: 'Enabled',
                labelDisabled: 'Disabled',
            };
        },
        mounted() {
            if (this.label) {
                this.labelEnabled = this.labelDisabled = this.label;
            }
        },
        computed: {
            valueWhenSelected() {
                return this.trueValue || true;
            },
            onoff: {
                get() {
                    return Array.isArray(this.value) ? this.value.indexOf(this.valueWhenSelected) >= 0 : !!this.value;
                },
                set(value) {
                    if (Array.isArray(this.value)) {
                        if (value) {
                            if (!this.onoff) {
                                this.$emit('input', this.value.concat(this.valueWhenSelected).sort());
                            }
                        } else {
                            this.$emit('input', this.value.filter((v) => v !== this.valueWhenSelected));
                        }
                    } else {
                        this.$emit('input', value);
                    }
                }
            }
        }
    };
</script>

<style lang="scss">
    /*.vue-switcher {*/
    /*&__label {*/
    /*text-align: right;*/
    /*}*/
    /*&--unchecked {*/
    /*&__label {*/
    /*text-align: left;*/
    /*}*/
    /*}*/
    /*}*/
</style>
