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
                        <div v-for="(image, key) in images" class="cc-selector-2 previewImage" v-show="seen">
                            <div>
                                <input type="radio" name="check" :id="key"  :value="key" v-model="checked">
                                <label class="preview drinkcard-cc" :for="key"><img :ref="'image'"/></label>
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
            console.log('Component mounted.')
        },
        data() {
            return {
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
            };
        },
        methods: {
            /*
               Handles the posting of files
            */
            formSubmit(e) {
                // e.preventDefault();
                for(let i=0; i<this.files.length;i++){

                    this.form.append('pics[]',this.files[i]);
                }
                this.form.append('title',this.title);
                this.form.append('description',this.description);
                this.form.append('checked',this.checked);
                const config = { headers: { 'Content-Type': 'multipart/form-data'} };
                document.getElementById('files').value=[];
                // let currentObj = this;
                axios.post('/api/posts/',this.form,config)
                    .then(response=>{
                        window.location.href = '/posts';
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
                this.form=new FormData
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
                if (!this.files.length || this.files.length>10){
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
                if(key === this.checked) {
                    if(this.index[this.index.length-1] === key) {
                        this.index.splice(index,1)
                        if(this.$el.querySelector('input[type="radio"]')!==null){
                            this.checked=this.$el.querySelector('input[type="radio"]').value;
                        }
                    } else {
                        this.index.splice(index,1)
                        this.checked=this.index[index];
                    }
                } else {
                    this.index.splice(index,1)
                }
            },
        },
    }
</script>

<style scoped>

</style>
