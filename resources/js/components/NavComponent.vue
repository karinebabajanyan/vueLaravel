<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="info">
            <b-navbar-brand href="/login">Laravel</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <em>{{userName}}</em>
                        </template>
                        <b-dropdown-item><router-link to="/users">Profile</router-link></b-dropdown-item>
                        <b-dropdown-item><router-link to="/posts">Posts</router-link></b-dropdown-item>
                        <b-dropdown-item href="/logout">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
    export default {
        name: "NavComponent",
        data(){
            return{
                //
            }
        },
        mounted() {

        },
        methods: {
            routes(){
                axios.post('/logout').then(response => {
                    window.location='/login'
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        created(){
            //
        },

        computed: {
            userName() {
                return this.$store.getters.USER.name;
            },
        }
    }
</script>

<style>
    a:hover {
        text-decoration: none;
        color: black;
    }

    a:active {
        text-decoration: none;
        color: black;
    }
    a:link {
        text-decoration: none;
        color: black;
    }

    a:visited {
        text-decoration: none;
        color: black;
    }
</style>
