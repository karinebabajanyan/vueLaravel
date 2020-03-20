<template>
    <div class="container">
        <div class="row justify-content-center">
            <div style="width: 80%; margin: 0 auto;">
                <b-alert variant="danger" v-if="error" show>{{error}}</b-alert>
                <div class="form-group">
                    <div class="large-12 medium-12 small-12 cell">
                        <label v-if="error" aria-disabled="true" class="btn btn-outline-secondary disabled">Files
                        </label>
                        <label v-else="true" class="btn btn-outline-secondary">Files
                            <input type="file" id="files" accept="image/*" multiple @change="handleFilesUpload"/>
                        </label>
                    </div>
                    <div class="img-upload-preview">
                        <div v-for="(image, k) in post.files" class="cc-selector-2 previewImage">
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
                    <input type="text" v-if="error" class="form-control" disabled>
                    <input type="text" v-else="true" class="form-control" v-model="title">
                    <label>Description:</label>
                    <textarea v-if="error" class="form-control" disabled></textarea>
                    <textarea v-else="true" class="form-control" v-model="description"></textarea>

                    <button class="btn btn-primary" v-if="error" style="margin-top: 10px" disabled>Submit</button>
                    <button class="btn btn-primary" v-else="true" @click="formSubmit" style="margin-top: 10px">Submit</button>
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
                error:'',
            }
        },
        methods: {
            showData() {
                axios.get('/api/posts/'+this.$route.query.id).then(response => {
                    if(response.status === 200)
                    {
                        let that=this;
                        this.post = response.data.post
                        this.title=this.post.title
                        this.description=this.post.description;
                        $.each(response.data.post.files, function(k, file) {
                            if(file.category==='checked'){
                                that.checked='old'+file.id;
                            }
                        });
                    }
                    console.log(this.checked)
                }).catch((error) => {
                    console.log(error)
                    this.error = error.message
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
                    this.index.push('new'+j);
                }
                let length=this.index.length;
                for (let i = 0; i < files.length; i++) {
                    this.files.push(files[i]);
                    this.images.push(files[i]);
                    let c=length+i
                    this.index.push('new'+c);
                }
                if (!this.files.length || this.post.files.length+this.files.length>10){
                    this.seen=false
                    this.files=[];
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
                let index=this.index.indexOf('new'+key);
                this.$refs.image[key].parentElement.parentElement.style.display='none'
                this.$refs.image[key].src='';
                this.files.splice(index,1)
                if('new'+key===this.checked){
                    if(this.index[this.index.length-1] === 'new'+key) {
                        this.checked='old'+this.post.files[0].id
                        this.index.splice(index,1)
                    } else {
                        this.index.splice(index,1)
                        this.checked=this.index[index];
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
                                    this.checked=this.index[0]
                                }
                            } else {
                                this.checked='old'+this.post.files[key+1].id
                            }
                        }
                    }
                }).catch((error) => {
                    this.error = error.message
                })
            },
            formSubmit(){
                for(let i=0; i<this.files.length;i++){

                    this.form.append('pictures[]',this.files[i]);
                }
                this.form.append('title',this.title);
                this.form.append('description',this.description);
                if(this.checked.includes('new')){
                    this.form.append('checked',this.index.indexOf(this.checked));
                }else{
                    this.form.append('checked',this.checked);
                }
                this.form.append("_method", 'patch');
                const config = { headers: { 'Content-Type': 'multipart/form-data'} };
                document.getElementById('files').value=[];
                // let currentObj = this;
                axios.post('/api/posts/'+this.post.id, this.form)
                    .then(response=>{
                        this.$router.push({ name: 'posts.index' })
                    })
                    .catch(function (error) {
                        console.log(error)
                        this.error = error.message
                    });
                this.form=new FormData
            }
        },
        created() {
//            this.checked='old'+parseInt(this.$route.query.cover);
            this.showData()

        }
    }
</script>

<style scoped>

</style>
