<template>
    <div class="container">
        <div class="row justify-content-center">
            <div style="width: 80%; margin: 0 auto;">
                <div class="form-group">
                    <div class="large-12 medium-12 small-12 cell">
                        <label class="btn btn-outline-secondary">Files
                            <input type="file" id="files" accept="image/*" multiple @change="handleFilesUpload"/>
                        </label>
                    </div>
                    <div class="img-upload-preview">
                        <div v-for="(image, k) in post.files" class="cc-selector-2 previewImage" v-show="seen">
                            <div>
                                <input type="radio" name="check" :id="'old'+k"  :value="'old'+image.id" v-model="checked">
                                <label class="preview drinkcard-cc" :for="'old'+k"><img :src="image.path"/></label>
                                <i @click="handleFilesDelete(k)">x</i>
                            </div>
                        </div>
                        <div v-for="(image, key) in images" class="cc-selector-2 previewImage" v-show="seen">
                            <div>
                                <input type="radio" name="check" :id="'new'+key"  :value="'new'+key" v-model="checked">
                                <label class="preview drinkcard-cc" :for="'new'+key"><img :ref="'image'"/></label>
                                <i @click="handleFilesRemove(key)">x</i>
                            </div>
                        </div>
                    </div>
                    <label style=" width: 100%;">Title:</label>
                    <input type="text" class="form-control" v-model="title">
                    <label>Description:</label>
                    <textarea class="form-control" v-model="description"></textarea>

                    <button class="btn btn-primary" @click="formSubmit" style="margin-top: 10px">Submit</button>
                </div>
            </div>
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
                post:[],
                 title: '',
                 description: '',
                form: new FormData,
                files: [],
                isClicked:false,
                index: [],
                images: [],
                $refs:'',
                checked:0,
                seen:true,
            }
        },
        methods: {
            showData() {
                axios.get('/api/posts/'+this.$route.query.id).then(response => {
                    if(response.status === 200)
                    {
                        this.post = response.data.post
                        this.title=this.post.title
                        this.description=this.post.description;
                    }
                }).catch((error) => {
                    this.errors = error.response.data
                })
            },
            /*
             Handles the uploading of files
          */
            handleFilesUpload(e){
                let vm = this;
                this.index=[];
                var files = e.target.files;
                this.images=[];
                for(let j=0;j<this.files.length;j++){
                    this.images.push(this.files[j])
                    this.index.push(j);
                }
                let length=this.index.length;
                for (let i = 0; i < files.length; i++) {
                    this.files.push(files[i]);
                    this.images.push(files[i]);
                    this.index.push(length+i);
                }
                if (!this.files.length || this.post.files.length+this.files.length>10){
                    this.seen=false
                    location.reload()
                }else{
                    for (let i = 0; i < this.images.length; i++) {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.$refs.image[i].parentElement.parentElement.style.display='block'
                            this.$refs.image[i].src = reader.result;
                        };
                        reader.readAsDataURL(this.images[i]);
                    }
                }
            },
            /*
              Handles the deleting of files
            */
            handleFilesRemove(key){
                let index=this.index.indexOf(key);
                this.$refs.image[key].parentElement.parentElement.style.display='none'
                this.$refs.image[key].src='';
                this.files.splice(index,1)
                if('new'+key===this.checked){
                    if(this.index[this.index.length-1] === key) {
                        this.checked='old'+this.post.files[0].id
                    } else {
                        this.index.splice(index,1)
                        this.checked='new'+this.index[index];
                    }
                }else{
                    this.index.splice(index,1)
                }
            },
            handleFilesDelete(key){
                axios.post('/api/posts/'+this.post.files[key].id ).then(response => {
                    if(response.status === 200)
                    {
                         this.showData()  // to refresh table..
                        if('old'+this.post.files[key].id===this.checked){
                            if(this.post.files.length-1 === key) {
                                if(this.index.length===0){
                                    this.checked='old'+this.post.files[0].id
                                }else{
                                    this.checked='new'+this.index[0]
                                }

                            } else {
                                this.checked='old'+this.post.files[key+1].id
                            }
                        }
                    }
                }).catch((error) => {
                    this.errors = error.response.data
                })
            },
            formSubmit(){
                for(let i=0; i<this.files.length;i++){

                    this.form.append('pictures[]',this.files[i]);
                    console.log(this.files[i]);
                }
                this.form.append('title',this.title);
                this.form.append('description',this.description);
                this.form.append('checked',this.checked);
                this.form.append("_method", 'patch');
                const config = { headers: { 'Content-Type': 'multipart/form-data'} };
                document.getElementById('files').value=[];
                // let currentObj = this;
                console.log(this.form)
                axios.post('/api/posts/'+this.post.id, this.form)
                    .then(response=>{
                       window.location.href = '/posts';
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
                this.form=new FormData
            }
        },
        created() {
            this.checked='old'+parseInt(this.$route.query.cover);
            this.showData()

        }
    }
</script>

<style scoped>

</style>
