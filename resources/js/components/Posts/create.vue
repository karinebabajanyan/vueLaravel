<template>
    <div class="container">
        <b-alert variant="danger" v-if="error" show>{{error}}</b-alert>
        <div class="row justify-content-center">
            <div style="width: 80%; margin: 0 auto;">
                <div class="form-group">
                    <div class="large-12 medium-12 small-12 cell">
                        <label class="btn btn-outline-secondary">Files
                            <input type="file" id="files" accept="image/*" multiple @change="handleFilesUpload"/>
                        </label>
                        <p v-if="!$v.file.required" style="color: red">{{ errors.file }}</p>
                    </div>
                    <div class="img-upload-preview">
                        <div v-for="(image, key) in images" class="cc-selector-2 previewImage" v-show="seen">
                            <div>
                                <input type="radio" name="check" :id="key"  :value="key" v-model="checked">
                                <label class="preview drinkcard-cc" :for="key"><img :ref="'image'"/></label>
                                <i @click="handleFilesRemove(key)">x</i>
                            </div>
                        </div>
                    </div>
                        <label style=" width: 100%;">Title:</label>
                        <input type="text" class="form-control" v-model.trim="$v.title.$model" name="title" />
                        <p v-if="!$v.title.required" style="color: red">{{ errors.title }}</p>
                        <label>Description:</label>
                        <textarea class="form-control" v-model="$v.description.$model" name="description"></textarea>
                        <p v-if="!$v.description.required" style="color: red">{{ errors.description }}</p>
                    <button class="btn btn-primary" @click="formSubmit" style="margin-top: 10px">Submit</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//    import { ValidationProvider } from 'vee-validate';
//    import { required } from 'vee-validate/dist/rules';

import { required } from 'vuelidate/lib/validators';

    export default {
        mounted() {
            console.log(this.$v)
        },
        data() {
            return {
                errors:{
                    title:'',
                    description:'',
                    file:'',
                },
                title:'',
                description:'',
                form: new FormData,
                files: [],
                isClicked:false,
                index: [],
                images: [],
                $refs:'',
                checked:0,
                seen:true,
                error:'',
            };
        },
        validations: {
            title: {
                required
            },
            description: {
                required
            },
            file: {
                required
            },
        },
        methods: {
            /*
               Handles the posting of files
            */
            formSubmit(e) {
                // e.preventDefault();
                let valid=true;
                if(this.title===''){
                    valid=false;
                    this.errors.title='Title is required';
                }else{
                    this.errors.title='';
                }
                if(this.description===''){
                    valid=false;
                    this.errors.description='Description is required';
                }else{
                    this.errors.description='';
                }
                if(this.files.length<=0){
                    valid=false;
                    this.errors.file='Files is required';
                }else{
                    this.errors.file=null;
                }
                console.log(this.errors)
                if(valid) {
                    for (let i = 0; i < this.files.length; i++) {

                        this.form.append('pics[]', this.files[i]);
                    }
                    this.form.append('title', this.title);
                    this.form.append('description', this.description);
                    this.form.append('checked', this.index.indexOf(this.checked));
                    const config = {headers: {'Content-Type': 'multipart/form-data'}};
                    document.getElementById('files').value = [];
                    axios.post('/api/posts', this.form, config)
                        .then(response => {
                            this.$router.push({name: 'posts.index'})
                        })
                        .catch(function (error) {
                            this.error = error.message
                        });
                    this.form = new FormData
                }
            },
            /*
               Handles the uploading of files
            */
            handleFilesUpload(e){
                this.errors.file='';
                let vm = this;
                this.index=[];
                var files = e.target.files;
                this.images=[];
                this.seen=true
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
                if (!this.files.length || this.files.length>10){
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
                let index=this.index.indexOf(key);
                this.$refs.image[key].parentElement.parentElement.style.display='none'
                this.$refs.image[key].src='';
                this.files.splice(index,1)
                if(key === this.checked) {
                    if(this.index[this.index.length-1] === key) {
                        this.index.splice(index,1)
                        this.checked=this.index[0];
                    } else {
                        this.index.splice(index,1)
                        this.checked=this.index[index];
                    }
                } else {
                    this.index.splice(index,1)
                }
                if(this.files.length<=0){
                    this.checked=0;
                }
            },
        },
    }
</script>

<style scoped>

</style>
