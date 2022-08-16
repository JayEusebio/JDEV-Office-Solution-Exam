<template>
    <div class="container">
        <form @submit.prevent="!editMode ? saveData() : updateData()">
            <Modal :open="isModalVisible" @close="isModalVisible = !isModalVisible">
                <template v-slot:header>
                    <h3>{{ !editMode ? 'Add Customer' : 'Update Customer' }}</h3> 
                </template>

                <template v-slot:body>
                    <div class="row mb-4 ms-3 me-5">
                        <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                        <input type="text" v-model="form.name" class="form-control" id="inputName">
                        </div>
                        <span class="text-danger" v-show="cErrors.name"> Name is Required! </span>
                    </div>
                    <div class="row mb-4 ms-3 me-5">
                        <label for="inputCname" class="col-sm-3 col-form-label">Contact Name</label>
                        <div class="col-sm-9">
                        <input type="text" v-model="form.contact_person" class="form-control me-3" id="inputCname">
                        </div>
                    </div>
                    <div class="row mb-4 ms-3 me-5">
                        <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                        <input type="text" v-model="form.address" class="form-control me-3" id="inputAddress">
                        </div>
                        <span class="text-danger" v-show="cErrors.address"> Address is Required! </span>
                    </div>
                    <div class="row mb-4 ms-3 me-5">
                        <label for="inputContactno" class="col-sm-3 col-form-label">Contact No</label>
                        <div class="col-sm-9">
                        <input type="text" v-model="form.contact_no" class="form-control me-3" id="inputContactno">
                        </div>
                    </div>
                    <div class="row mb-4 ms-3 me-5">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Email address</label>
                        <div class="col-sm-9">
                        <input type="email" v-model="form.email_address" class="form-control me-3" id="inputEmail3">
                        </div>
                    </div>
                    <div class="row mb-4 ms-3 me-5">
                        <label for="inputTin" class="col-sm-3 col-form-label">Tin</label>
                        <div class="col-sm-9">
                        <input type="text" v-model="form.tin" class="form-control me-3" id="inputTin">
                        </div>
                    </div>
                    <div class="row mb-4 ms-3 me-5">
                        <label for="inputCustomerType" class="col-sm-3 col-form-label">Customer Type</label>
                        <div class="col-sm-9">
                        <input type="text" hidden v-model="form.customer_type_id" class="form-control me-3" id="inputCustomerType">
                        <select class="form-select" v-model="form.customer_type_id" aria-label="Default select example">
                            <option v-for="(type, index) in cTypedata" :key="index">{{ type.id }}</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-12 ms-3">
                        <button type="submit" class="btn btn-primary">{{ !editMode ? 'Submit' : 'Update' }}</button>
                    </div>
                </template>
            </Modal>
        </form>
        <h1 class="text-center m-5">JDEV-Exam</h1>
        <div class="container-xl">
            <div class="d-flex my-4">
                <div class="p-2 flex-grow-1">
                    <button @click="modalVisible()" class="btn btn-outline-primary btn-sm">New Customer</button>
                </div>
                <div class="p-2 me-5">
                    <button type="submit" @click="print" class="btn btn-outline-primary btn-sm">Print</button>
                </div>
                <div class="p-2">
                    <input type="text" v-model="strSearch" class="form-control" style="width: 100%;" placeholder="Search Name Here!">
                </div>
            </div>
            <div>
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Contact Person</th>
                        <th scope="col">Address</th>
                        <th scope="col">Contact Number</th>
                        <th  scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in cData" :key="index">
                        <td>{{ data.name }}</td>
                        <td>{{ data.contact_person }}</td>
                        <td>{{ data.address }}</td>
                        <td>{{ data.contact_no }}</td>
                        <td>
                            <button @click="editData(data)" class="btn btn-outline-info btn-sm me-2">Edit</button>
                            <button @click="deleteData(data)" class="btn btn-outline-danger btn-sm">Delete</button>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
import Modal from '../components/Modal.vue'
import { ref } from 'vue'
import { jsPDF } from "jspdf"
import autoTable from 'jspdf-autotable'

    export default{
        name: 'pdf',
        components: { Modal },
        setup(){
            const isModalVisible = ref(false)
            return { isModalVisible }
        },
        data() {
            return {
                editMode: false,
                strSearch: null,
                form: {
                    id: '',
                    name: '',
                    contact_person: '',
                    address: '',
                    contact_no: '',
                    email_address: '',
                    tin: '',
                    customer_type_id: ''
                },
                cErrors: {
                    name: false,
                    address: false,
                },
                cData: {},
                cTypedata: {},
            }
            
        },
        watch: {
            strSearch(after, before) {
                this.getResults();
            }
        },
        mounted() {
            this.showData()
            this.showCustomertype()
        },
        methods: {
            print() {
                var pdf = jsPDF();
                var pdfData = this.cData
                
                var info = []
                pdf.text("Customers Masterfile", 78, 10);
                pdfData.forEach((element, index, array)=> {
                    info.push([element.name, element.contact_person, element.address, element.contact_no, element.email_address, element.tin, element.customer_type_id])
                })

                autoTable(pdf, {
                    headStyles: {halign: 'center', cellPadding: {top: 2, bottom: 2}},
                    bodyStyles: {halign: 'center', cellPadding: {top: 2, bottom: 2}},
                    alternateRowStyles: {fillColor: [204, 229, 255]},
                    margin: { top: 20 },
                    head:[['Name', 'Contact Person', 'Address', 'Contact No.', 'Email Address', 'Tin', 'ID Type']],
                    body:info
                })
                
                pdf.save('Customer Master File.pdf');
            },
            getResults() {
                axios.get('customer/index', {params: {search: this.strSearch}}).then(response => {
                    this.cData = response.data
                }).catch(errors => {
                    console.log(errors)
                })
            },
            modalVisible() {
                this.editMode= false
                this.form = {
                    id: '',
                    name: '',
                    contact_person: '',
                    address: '',
                    contact_no: '',
                    email_address: '',
                    tin: '',
                    customer_type_id: ''
                }
                this.cErrors = {
                    name: false,
                    address: false,
                }
                this.isModalVisible = true
            },
            deleteData(data) {
                this.form.id = data.id
                axios.post('customer/delete/' + this.form.id).then(response => {
                    alert('Are you sure you want to delete this data?')
                    this.showData()
                }).catch(errors => {
                    console.log(errors)
                });
            },
            updateData() {
                this.form.name == '' ? this.cErrors.name = true : this.cErrors.name = false
                this.form.address == '' ? this.cErrors.address = true : this.cErrors.address = false

                if(this.form.name && this.form.address){
                    axios.post('customer/update/' + this.form.id, this.form).then(response => {
                        this.showData()
                    }).catch(errors => {
                        console.log(errors)
                    }).finally(()=>{
                        this.isModalVisible = false
                    });
                }

            },
            editData(data) {
                this.editMode = true
                this.isModalVisible = true
                this.form = {
                    id: data.id,
                    name: data.name,
                    contact_person: data.contact_person,
                    address: data.address,
                    contact_no: data.contact_no,
                    email_address: data.email_address,
                    tin: data.tin,
                    customer_type_id: data.customer_type_id
                }
                this.cErrors = {
                    name: false,
                    address: false,
                }                
            },
            showData() {
                axios.get('customer/index').then(response => {
                        this.cData = response.data
                    }).catch(errors => {
                        console.log(errors)
                    })
            },
            showCustomertype() {
                axios.get('customerType/index').then(response => {
                        this.cTypedata = response.data
                    }).catch(errors => {
                        console.log(errors)
                    })
            },
            saveData() {
                this.form.name == '' ? this.cErrors.name = true : this.cErrors.name = false
                this.form.address == '' ? this.cErrors.address = true : this.cErrors.address = false

                if(this.form.name && this.form.address){
                    axios.post('customer/store', this.form).then(response => {
                        this.showData()
                    }).catch(errors => {
                        console.log(errors)
                    }).finally(()=>{
                        this.isModalVisible = false
                    });
                }
            }
        }
    }

    
  
</script>