<template>
    <div class="container">
        <div>
            <ul class="list-unstyled">
                <b-media tag="li">
                    <template v-slot:aside>
                        <b-carousel
                            id="carousel-1"
                            :interval="4000"
                            controls
                            style="text-shadow: 1px 1px 2px #333; width: 200px; height: 100px!important;"
                            v-model="slide"
                        >
                            <b-carousel-slide  v-for="(file, key) in post.files" v-bind:key="file.id" :img-src="file.path" style="height: 100px !important"></b-carousel-slide>
                        </b-carousel>
                    </template>
                    <h4 class="media-heading">{{post.title}}</h4>
                    <p class="desc">{{post.description}}</p>
                    <p>
                        <router-link v-if="postUpdate" :to="{ name: 'posts.edit', query: { id: post.id, cover: cover }}">Edit</router-link>
                        <button @click="deletePost(post)" class="btn btn-danger" v-if="postDelete" >Delete</button>
                    </p>
                </b-media>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
//
        },
        data(){
            return{
                id:'',
                slide:0,
                cover:0,
                post:[],
                postUpdate:false,
                postDelete:false
            }
        },
        methods: {
            showData() {
                axios.get('/api/posts/'+this.$route.query.id).then(response => {
                    if(response.status === 200)
                    {
                        let id=0;
                        this.post = response.data.post
                        this.postUpdate = response.data.update
                        this.postDelete = response.data.delete
                        console.log(this.postUpdate)
                        console.log(this.postDelete)
                        $.each(this.post.files, function(k, file) {
                            if(file.category==='checked'){
                                id=file.id;
                            }
                        });
                        this.cover=id;
                    }
                }).catch((error) => {
                    this.errors = error.response.data
                })
            },
            deletePost(item) {
                axios.delete('/api/posts/'+item.id).then(response => {
                    if(response.status === 200)
                    {
                        window.location.href = '/posts';
                    }
                }).catch((error) => {
                    this.errors = error.response.data
                })
            }
        },
        created() {
            this.showData()
            this.slide=parseInt(this.$route.query.cover);
        }
    }
</script>

<style>
    .img-fluid{
        height: 100% !important;
    }
</style>
