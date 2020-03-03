<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1> Welcome!</h1>
                <h2>{{name}}</h2>
                <p>{{email}}</p>
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
            fetchData() {
                axios.get('api/home').then(response => {
                    if (response.status === 200) {
                        this.email = response.data.user.email
                        this.name = response.data.user.name
                    }
                });
            }

        },
        created() {
            this.fetchData();
        }
    }
</script>

<style scoped>

</style>
