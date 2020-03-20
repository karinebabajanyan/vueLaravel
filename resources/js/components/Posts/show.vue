<template>
    <div class="container">
        <b-alert variant="danger" v-if="error" show>{{error}}</b-alert>
        <div>
            <ul class="list-unstyled">
                <b-media tag="li">
                    <template v-slot:aside>
                        <b-carousel
                            id="carousel-1"
                            :interval="4000"
                            controls
                            style="text-shadow: 1px 1px 2px #333; width: 200px; height: 100px!important;"
                            v-if="slide.cover"
                            v-model="slide.cover"
                        >
                            <b-carousel-slide  v-for="(file, key) in files" v-bind:key="key" :img-src="file.path" style="height: 100px !important" ></b-carousel-slide>
                        </b-carousel>
                    </template>
                    <h4 class="media-heading">{{post.title}}</h4>
                    <p class="desc">{{post.description}}</p>
                    <p>
                        <router-link v-if="postUpdate && !error" :to="{ name: 'posts.edit', query: { id: post.id,error:error}}">Edit</router-link>
                        <button @click="deletePost(post)" class="btn btn-danger" v-if="postDelete && !error" >Delete</button>
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
                slide:{},
                files:[],
                post:[],
                postUpdate:false,
                postDelete:false,
                error:'',
            }
        },
        methods: {
            showData() {
                const that= this;
                axios.get('/api/posts/'+this.$route.query.id).then(response => {
                    if(response.status === 200)
                    {
                        that.slide.cover=response.data.slide
                        $.each(response.data.post.files, function(key, file) {
                            that.files.push(file)
                        });
                        that.post = response.data.post
                        that.postUpdate = response.data.update
                        that.postDelete = response.data.delete
                    }
                }).catch((error) => {
                    that.error = error.message
                })
            },
            deletePost(item) {

                let that= this;
                axios.delete('/api/posts/'+item.id).then(response => {
                    if(response.status === 200)
                    {
                        that.$router.push({ name: 'posts.index' })
                    }
                }).catch((error) => {
                    that.error = error.message
                })
            }
        },
        created() {
            this.showData();
        }
    }
</script>

<style>
    .img-fluid{
        height: 100% !important;
    }
</style>
