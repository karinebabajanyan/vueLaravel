<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1> Welcome!</h1>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                name: '',
                email: '',
            };
        },
        methods: {

        },
    }
</script>

<style scoped>

</style>
