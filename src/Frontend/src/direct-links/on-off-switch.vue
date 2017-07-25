<template>
    <switches v-model="onoff"
        @input="update()"
        theme="bulma"
        type-bold="true"
        color="green"
        :text-enabled="$t('Enabled')"
        :text-disabled="$t('Disabled')"></switches>
</template>

<script>
    import Switches from 'vue-switches';

    export default {
        components: {Switches},
        props: ['value'],
        data(){
          return {
              onoff: this.value,
          }
        },
        methods: {
            update() {
                this.$emit('input', this.onoff);
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
