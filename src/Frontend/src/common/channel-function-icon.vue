<template>
    <span class="channel-function-icon" :style="{height: height + 'px'}">
        <img :src="'/assets/img/functions/' + (value.value || value) + '.svg'">
    </span>
</template>

<script>
    export default {
        props: ['value', 'height']
    };
</script>

<style lang="scss">
    .channel-function-icon {
        display: inline-block;
        img {
            max-height: 100%;
        }
    }
</style>
