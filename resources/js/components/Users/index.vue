<template>
    <div class="container">
        <p v-if="isAdmin">
            <b-button size="sm" @click="addInfo($event.target)" class="mr-1">
                Add
            </b-button>
        </p>
        <!-- Main table element -->
        <b-table
            small
            stacked="md"
            :items="items"
            :fields="fields"
            row.id="1"
        >
            <template v-slot:cell(edit)="row">
                <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="mr-1">
                    Edit
                </b-button>
            </template>
            <template v-slot:cell(delete)="row">
                <b-button size="sm" @click="dataDelete(row.item.id)" class="mr-1" v-if="row.item.id!==authId">
                    Delete
                </b-button>
            </template>
        </b-table>

        <!-- Info modal -->
        <b-modal
            size="xl"
            :id="infoModal.id"
            :title="infoModal.title"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <template>
                <form ref="form" @submit.stop.prevent="">
                    <b-form-group
                        label="Name"
                        :state="states.name"
                        label-for="name-input"
                        :invalid-feedback="errors.name"
                    >
                        <b-form-input
                            id="name-input"
                            type="text"
                            :state="states.name"
                            v-model="infoModal.content.name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label="Email"
                        :state="states.email"
                        label-for="email-input"
                        :invalid-feedback="errors.email"
                    >
                        <b-form-input
                            id="email-input"
                            type="email"
                            :state="states.email"
                            v-model="infoModal.content.email"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label="Role"
                        label-for="role-select"
                    >
                        <b-form-select
                            id="role-select"
                            v-model="infoModal.content.role"
                            :options="options"
                        ></b-form-select>
                    </b-form-group>
                    <b-form-group
                        label="Password"
                        :state="states.password"
                        label-for="password-input"
                        :invalid-feedback="errors.password"
                    >
                        <b-form-input
                            id="password-input"
                            type="password"
                            :state="states.password"
                            v-model="infoModal.content.password"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label="Confirm Password"
                        :state="states.confirmPass"
                        label-for="confirmPass-input"
                        :invalid-feedback="errors.confirmPass"
                    >
                        <b-form-input
                            id="confirmPass-input"
                            type="password"
                            :state="states.confirmPass"
                            v-model="infoModal.content.confirmPass"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <!--<div class="text-right">-->
                        <!--<b-button pill variant="success" style="margin-right:10px" @click="saveData">Save</b-button>-->
                        <!--<b-button pill variant="danger" @click="cancel">Cancel</b-button>-->
                    <!--</div>-->
                </form>
            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new FormData,
                isAdmin:false,
                fields: [],
                items: [],
                states:{
                    name:null,
                    email:null,
                },
                infoModal: {
                    id: 'modal-prevent-closing',
                    title: '',
                    content: {

                    }
                },
                options: [
                    { value: 'user', text: 'User' },
                    { value: 'admin', text: 'Admin' },
                ],
                authId:'',
                // password:'',
                // confirmpass:'',
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                errors:{
                    name:'',
                    email:'',
                    password:'',
                    confirmPass:'',
                },
                modalCategory:'',
            }
        },
        methods: {
            checkFormValidity() {
                let valid=true;
                this.states.password=null;
                this.states.confirmPass=null;
                if(this.modalCategory==='update'){
                    if(this.infoModal.content.name===''){
                        valid=false;
                        this.states.name=valid;
                        this.errors.name='Name is required';
                    }else{
                        this.states.name=null;
                    }
                    if(this.infoModal.content.email===''){
                        valid=false;
                        this.states.email=valid;
                        this.errors.email='Email is required';
                    }else{
                        this.states.email=null;
                    }
                    if(!this.reg.test(this.infoModal.content.email)){
                        valid=false;
                        this.states.email=valid;
                        this.errors.email='Email is not correct';
                    }else{
                        this.states.email=null;
                    }
                    if(this.infoModal.content.confirmPass!==this.infoModal.content.password){
                        valid=false;
                        this.states.confirmPass=valid;
                        this.errors.confirmPass='Confirm password is not correct';
                    }else{
                        if(this.infoModal.content.password.length<8 && this.infoModal.content.password.length>0){
                            valid=false;
                            this.states.password=valid;
                            this.errors.password='Password is short';
                        }
                        this.states.confirmPass=null;
                    }
                }else if(this.modalCategory==='add'){
                    if(this.infoModal.content.name===''){
                        valid=false;
                        this.states.name=valid;
                        this.errors.name='Name is required';
                    }else{
                        this.states.name=null;
                    }
                    if(this.infoModal.content.email===''){
                        valid=false;
                        this.states.email=valid;
                        this.errors.email='Email is required';
                    }else{
                        this.states.email=null;
                    }

                    if(!this.reg.test(this.infoModal.content.email)){
                        valid=false;
                        this.states.email=valid;
                        this.errors.email='Email is not correct';
                    }else{
                        this.states.email=null;
                    }

                    if(this.infoModal.content.password===''){
                        valid=false;
                        this.states.password=valid;
                        this.errors.password='Password is required';
                    }else{
                        this.states.password=null;
                    }
                    if(this.infoModal.content.confirmPass===''){
                        valid=false;
                        this.states.confirmPass=valid;
                        this.errors.confirmPass='Confirm password is required';
                    }else{
                        this.states.confirmPass=null;
                    }
                    if(this.infoModal.content.confirmPass!==this.infoModal.content.password){
                        valid=false;
                        this.states.confirmPass=valid;
                        this.errors.confirmPass='Confirm password is not correct';
                    }else{
                        if(this.infoModal.content.password.length<8 && this.infoModal.content.password.length>0){
                            valid=false;
                            this.states.password=valid;
                            this.errors.password='Password is short';
                        }
                        this.states.confirmPass=null;
                    }
                }

                return valid
            },
            resetModal() {
                this.infoModal.contetnt = ''
                this.states.name=null
                this.states.email=null
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()

                let that=this;
                $.each(this.infoModal.content, function(key, value) {
                    if(key==='password'){
                        if(value!==''){
                            that.form.append(String(key), value)
                        }
                    }else if(key!=='confirmPass'){
                        that.form.append(String(key), value)
                    }
                })
                if(this.modalCategory==='update'){
                    this.form.append("_method", 'patch');
                    axios.post('/api/users/'+this.infoModal.content.id, this.form)
                        .then(response=>{
                            this.fetchData();
                            this.$store.dispatch('GET_USER');
                        })
                        .catch(function (error) {
                            this.errors = error.response.data
                        });
                }else if(this.modalCategory==='add'){
                    axios.post('api/users/', this.form)
                        .then(response=>{
                            this.fetchData();
                            this.$store.dispatch('GET_USER');
                        })
                        .catch(function (error) {
                            this.errors = error.response.data
                        });
                }

                this.form=new FormData
                // Trigger submit handler
                this.handleSubmit()
            },
            handleSubmit() {
                // Exit when the form isn't valid
                if (!this.checkFormValidity()) {
                    return
                }
                // Push the name to submitted names
                // Hide the modal manually
                let that=this
                this.$nextTick(() => {
                    setTimeout(function(){
                        that.$bvModal.hide('modal-prevent-closing')
                    }, 500);
                })
            },
            info(item, index, button) {
                this.infoModal.content={}
                this.infoModal.title = 'User Update'
                this.infoModal.content.name=item.name
                this.infoModal.content.email=item.email
                this.infoModal.content.role=item.role
                this.infoModal.content.id=item.id
                this.infoModal.content.password=''
                this.infoModal.content.confirmPass=''
                this.modalCategory='update'
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            addInfo(button){
                this.infoModal.content={}
                this.infoModal.title = 'Add User'
                this.infoModal.content.name=''
                this.infoModal.content.email=''
                this.infoModal.content.role='user'
                this.infoModal.content.id=''
                this.infoModal.content.password=''
                this.infoModal.content.confirmPass=''
                this.modalCategory='add'
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            dataDelete(id){
                if(confirm("Do you really want to delete?")){
                    // console.log(id);
                    axios.delete('/api/users/'+id)
                        .then(response => {
                            this.fetchData();
                            this.$store.dispatch('GET_USER');
                        })
                        .catch(error => {
                            console.log(error);
                        })
                }
            },
            fetchData() {
                axios.get('api/users').then(response => {
                    if(response.data.isAdmin){
                        this.isAdmin=response.data.isAdmin
                        this.fields=['name', 'email','role', 'edit','delete']
                    }else{
                        this.fields=['name', 'email','role']
                    }
                    let item=[];
                    this.authId=response.data.auth.id
                    item.push({
                        id:response.data.auth.id,
                        name: response.data.auth.name,
                        email: response.data.auth.email,
                        role: response.data.auth.role,
                    })
                    $.each(response.data.users, function(key, user) {
                        item.push({
                            id:user.id,
                            name: user.name,
                            email: user.email,
                            role: user.role,
                        })
                    })
                    this.items=item;
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
    .modal-header .close {
        display:none;
    }
</style>
