<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="info">

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <em>{{user.name}}</em>
                        </template>
                        <b-dropdown-item><router-link to="/profile">Profile</router-link></b-dropdown-item>
                        <b-dropdown-item><router-link to="/posts">Posts</router-link></b-dropdown-item>
                        <b-dropdown-item><router-link to="/users">Users List</router-link></b-dropdown-item>
                        <b-dropdown-item href="/logout">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
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
           //
        },
        created(){
            //
        },

        computed: {
            ...mapGetters({
                // map `this.user` to `this.$store.getters.USER`
                user: 'USER'
            })
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
