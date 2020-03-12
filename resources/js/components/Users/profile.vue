<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <picture-input
                    ref="pictureInput"
                    width="600"
                    height="600"
                    margin="16"
                    accept="image/jpeg,image/png"
                    size="10"
                    button-class="btn"
                    @change="onChange">
                </picture-input>
                <h1> Welcome!</h1>
                <h2>{{user.name}}</h2>
                <p>{{user.email}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import PictureInput from 'vue-picture-input'
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                name: '',
                email: '',
                form: new FormData,
            };
        },
        components: {
            PictureInput
        },
        methods: {
            onChange (file) {
                this.form.append('avatar',file);
                const config = { headers: { 'Content-Type': 'multipart/form-data'} };
                axios.post('/api/users/image',this.form,config)
                    .then(response=>{
                      //
                    })
                    .catch(function (error) {
                        this.errors = error.response.data
                    });
                this.form=new FormData
                console.log(file)

            }
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
<style>
    #picture-input{
        width: 200px !important;
        height: 200px !important;
        margin: 0px !important;
    }
    img{
        width: 100% !important;
    }
    .picture-inner{
        border: none !important;
        padding: 0px!important;
    }
    .picture-preview{
        background: none !important;
    }
    .preview-container{
        margin: 0px !important;
        border-radius: 50% !important;
        overflow: inherit !important;
    }
</style>
