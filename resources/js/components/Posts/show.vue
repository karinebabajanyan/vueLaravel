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
                        <router-link :to="{ name: 'posts.edit', query: { id: post.id, cover: cover }}">Edit</router-link>
                        <!--<router-link to="/posts/show" :id="post.id">See More</router-link>-->
                        <!--<a href="{{route('posts.show',['id' => $post->id])}}">See More</a>-->
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
            }
        },
        methods: {
            showData() {
                axios.get('/api/posts/'+this.$route.query.id).then(response => {
                    if(response.status === 200)
                    {
                        console.log(response)

                        this.post = response.data.post
                    }
                }).catch((error) => {
                    this.errors = error.response.data
                })
            },
        },
        created() {
            this.showData()
            this.slide=parseInt(this.$route.query.cover);
            this.cover=parseInt(this.$route.query.cover);
        }
    }
</script>

<style>
    .img-fluid{
        height: 100% !important;
    }
</style>
