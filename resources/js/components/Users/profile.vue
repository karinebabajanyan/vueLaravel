<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1> Welcome!</h1>
                <h2>{{user.name}}</h2>
                <p>{{user.email}}</p>
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
            //
        },
        created() {
            //
        },
        computed: {
            user() {
                return this.$store.getters.USER;
            },
        }
    }
</script>
