<template>
    <div>
        <nav-component></nav-component>
        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    export default {
        name: "app",
        mounted() {
            this.$store.dispatch('GET_USER');
        },
        created(){
            //
        },
    }
</script>

<!--<style lang="scss">-->


<!--</style>-->
