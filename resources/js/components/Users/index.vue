<template>
    <div class="container">
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
                    Info modal
                </b-button>
            </template>
            <template v-slot:cell(delete)="row">
                <b-button size="sm" @click="" class="mr-1">
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
                    <form ref="form" @submit.stop.prevent="handleSubmit">
                            <b-form-group
                                label="Name"
                                :state="states.name"
                                label-for="name-input"
                                invalid-feedback="Name is required"
                            >
                                <b-form-input
                                    id="name-input"
                                    :state="states.name"
                                    v-model="infoModal.content.name"
                                    required
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group
                                label="Email"
                                :state="states.email"
                                label-for="email-input"
                                invalid-feedback="Email is required"
                            >
                                <b-form-input
                                    id="email-input"
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
                    </form>
            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fields: [],
                items: [],
                states:{
                    name:null,
                    email:null,
                },
                infoModal: {
                    id: 'modal-prevent-closing',
                    title: '',
                    content: ''
                },
                options: [
                    { value: 'user', text: 'User' },
                    { value: 'admin', text: 'Admin' },
                ],
                password:'',
                confirmpass:'',
            }
        },
        methods: {
            checkFormValidity() {
                let valid=true;
                if(this.infoModal.content.name===''){
                    valid=false;
                    this.states.name=valid;
                }else{
                    this.states.name=null;
                }
                if(this.infoModal.content.email===''){
                    this.states.email=valid;
                }else{
                    this.states.email=null;
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
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing')
                })
            },
            info(item, index, button) {
                this.infoModal.title = `Row id: ${index}`
                this.infoModal.content=item
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            fetchData() {
                axios.get('api/users').then(response => {
                    if(response.data.auth.role==='admin'){
                        this.fields=['name', 'email','role', 'edit','delete']
                    }else{
                        this.fields=['name', 'email','role']
                    }
                    let item=[];
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
