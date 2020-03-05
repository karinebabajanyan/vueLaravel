<template>
    <div class="container">
        <p>
            <router-link to="/posts/create">Add New Post</router-link>
        </p>
            <div>
                <b-tabs content-class="mt-3">
                    <b-tab title="All Posts" active>
                        <div v-for="(post1, k1) in allPosts" v-bind:key="post1.id">
                            <div>
                                <ul class="list-unstyled">
                                    <b-media tag="li">
                                        <template v-slot:aside>
                                            <b-carousel
                                                :id="'carousel-' + k1"
                                                v-model="slide1[k1]"
                                                :interval="4000"
                                                controls
                                                style="text-shadow: 1px 1px 2px #333; width: 200px; height: 100px!important;"
                                            >
                                                <b-carousel-slide  v-for="(file1, key1) in post1.files" v-bind:key="file1.id" :img-src="file1.path" style="height: 100px !important"></b-carousel-slide>
                                            </b-carousel>
                                        </template>
                                        <h4 class="media-heading">{{post1.title}}</h4>
                                        <p class="desc">{{post1.description}}</p>
                                        <p>
                                            <router-link :to="{ name: 'posts.show', query: { id: post1.id, cover: cover1[k1] }}">See More</router-link>
                                        </p>
                                    </b-media>
                                </ul>
                            </div>
                        </div>
                    </b-tab>
                    <b-tab title="My Posts">
                        <div v-for="(post2, k2) in myPosts" v-bind:key="post2.id">
                            <div>
                                <ul class="list-unstyled">
                                    <b-media tag="li">
                                        <template v-slot:aside>
                                            <b-carousel
                                                :id="'carousel-' + k2"
                                                v-model="slide2[k2]"
                                                :interval="4000"
                                                controls
                                                style="text-shadow: 1px 1px 2px #333; width: 200px; height: 100px!important;"
                                            >
                                                <b-carousel-slide  v-for="(file2, key2) in post2.files" v-bind:key="file2.id" :img-src="file2.path" style="height: 100px !important"></b-carousel-slide>
                                            </b-carousel>
                                        </template>
                                        <h4 class="media-heading">{{post2.title}}</h4>
                                        <p class="desc">{{post2.description}}</p>
                                        <p>
                                            <router-link :to="{ name: 'posts.show', query: { id: post2.id, cover: cover2[k2] }}">See More</router-link>
                                        </p>
                                    </b-media>
                                </ul>
                            </div>
                        </div>
                    </b-tab>
                </b-tabs>
            </div>
    </div>
</template>

<script>
    import {tabs} from 'bootstrap-vue';
    export default {
        mounted() {

        },
        data(){
            return{
                slide1: [],
                slide2: [],
                cover1:0,
                cover2:0,
                posts: [],
                allPosts: [],
                myPosts: [],
                errors: '',
            }
        },
        methods: {
            fetchData() {
                axios.get('api/posts').then(response => {
                    if(response.status === 200)
                    {

                        this.posts = response.data
                        this.allPosts = response.data.allPosts
                        this.myPosts = response.data.myPosts
                        let arr1=[];
                        let arr2=[];
                        let item1=[];
                        let item2=[];
                        $.each(this.allPosts, function(k1, post1) {
                            $.each(post1.files, function(key1, file1) {
                                if(file1.category==='checked'){
                                    arr1.push(key1)
                                    item1.push(key1);
                                }
                            });
                        });
                        this.slide1=arr1
                        this.cover1=item1
                        $.each(this.myPosts, function(k2, post2) {
                            $.each(post2.files, function(key2, file2) {
                                if(file2.category==='checked'){
                                    arr2.push(key2)
                                    item2.push(key2)
                                }
                            });
                        });
                        this.slide2=arr2
                        this.cover2=item2
                    }
                }).catch((error) => {
                    this.errors = error.response.data
                })
            },
        },
        created() {
            this.fetchData();
        }
    }
</script>

<style>
.img-fluid{
    height: 100% !important;
}
</style>
