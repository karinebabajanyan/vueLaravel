<template>
    <div>
        <nav-component></nav-component>
        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
    export default {
        name: "app",
        mounted() {
            this.user()
        },
        created(){
            //
        },
        methods: {
            ...mapActions({
              user: 'GET_USER' // map `this.user()` to `this.$store.dispatch('GET_USER')`
            })
        }
    }
</script>

<!--<style lang="scss">-->


<!--</style>-->
