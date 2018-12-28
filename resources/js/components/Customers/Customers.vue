<template>
    <div>
        <v-toolbar flat color="white">
        <v-toolbar-title>Customers</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="600px">
          <v-btn slot="activator" color="primary" dark class="mb-2">New Customer</v-btn>
         <v-form>
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                </v-card-title>
  
                <v-card-text>
                    <v-container grid-list-md>  
                        <v-layout wrap>
                            <v-flex xs12>
                                <v-text-field v-model="editedCustomer.companyName" label="Company" required :rules="editCustomer.companyNameRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.firstName" label="First Name" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.lastName" label="Surname" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.eMail" label="Email address" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.phoneNumber" label="Phone Number" required :counter="8"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.CVR" label="CVR" required :counter="8"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.EAN" label="EAN" required :counter="13"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.street" label="Street" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.streetNumber" label="Street Number" required></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.zipCode" label="Zip" required :counter="4"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.city" label="City" required></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field v-model="editedCustomer.address.country" label="Country" required></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                    <v-btn color="blue darken-1" flat @click="save()">Save</v-btn>
                </v-card-actions>
            </v-card>
          </v-form>
        </v-dialog>
      </v-toolbar>
        <v-card>
            <v-card-title>
                <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="customersNew" item-key="index" :search="search">
                <template slot="items" slot-scope="props">
                    <td class="text-xs-left">{{props.item.companyName}}</td>
                    <td class="text-xs-left">{{props.item.firstName}}</td>
                    <td class="text-xs-left">{{props.item.lastName}}</td>
                    <td class="text-xs-left">{{props.item.eMail}}</td>
                    <td class="text-xs-left">{{props.item.phoneNumber}}</td>
                    <td class="text-xs-left">{{props.item.CVR}}</td>
                    <td class="text-xs-left">{{props.item.EAN}}</td>
                    <td class="text-xs-left">{{props.item.address.street}} {{props.item.address.streetNumber}}</td>
                    <td class="text-xs-left">{{props.item.address.city}}</td>
                    <td class="text-xs-left">{{props.item.address.zipCode}}</td>
                    <td class="justify-center layout px-0">
                        <v-icon small class="mr-2" @click="editCustomer(props.item)">edit</v-icon>
                        <v-icon small @click="deleteCustomer(props.item)">delete</v-icon>
                    </td>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
import { required, minLength, between } from 'vuelidate/lib/validators'
export default {
    
    props: ['customers'],

    data () {
        return {
            dialog: false,
            search:'',
            headers: [
                {
                text: 'Company',
                align: 'left',
                value: 'companyName'
                },{
                text: 'First Name',
                align: 'left',
                value: 'firstName',
                },{
                text: 'Surname',
                align: 'left',
                value: 'lastName',
                },{
                text: 'Email',
                align: 'left',
                value: 'eMail'
                },{
                text: 'Phone Number',
                align: 'left',
                value: 'phoneNumber'
                },{
                text: 'CVR',
                align: 'left',
                value: 'CVR'
                },{
                text: 'EAN',
                align: 'left',
                value: 'EAN'
                },{
                text: 'Address',
                align: 'left',
                value: 'address.street'
                },{
                text: 'City',
                align: 'left',
                value: 'address.city'
                },{
                text: 'Zip Code',
                align: 'left',
                value: 'address.zipCode'
                },{
                text: 'Actions',
                align: 'left',
                value: 'id',
                sortable: false
            }],
            customersNew: this.customers,
            editedIndex: -1,
            editedCustomer: {
                companyName: '',
                companyNameRules: [
                    v => !!v || 'The Company name is required',
                    v => (v && v.length <= 10) || 'Company name must work'
                ],
                firstName: '',
                lastName: '',
                eMail: '',
                phoneNumber: '',
                CVR: '',
                EAN: '',
                address: {
                    street: '',
                    streetNumber: '',
                    city: '',
                    zipCode: '',
                    country: ''
                }
            },
            defaultCustomer: {
                companyName: '',
                firstName: '',
                lastName: '',
                eMail: '',
                phoneNumber: '',
                CVR: '',
                EAN: '',
                address: {
                    street: '',
                    streetNumber: '',
                    city: '',
                    zipCode: '',
                    country: ''
                }
            },  
        }},
            
            computed: {
                formTitle () {
                    return this.editedIndex === -1 ? 'New Customer' : 'Edit Customer'
                },
            },

            watch: {
                dialog (val) {
                    val || this.close()
                }
            },

            methods: {
                editCustomer(item) {
                    this.editedIndex = this.customersNew.indexOf(item)
                    this.editedCustomer = Object.assign(item)
                    this.dialog = true
                },
                deleteCustomer(item) {
                    const index = this.customersNew.indexOf(item)
                    confirm('Are you sure you want to delete this item?') && axios.delete('/customer/' +item.id).then((response) => {
                        this.read();
                    })
                },
                close () {
                    this.dialog = false
                    setTimeout(() => {
                        this.editedCustomer = Object.assign({}, this.defaultCustomer)
                        this.editedIndex = -1
                    }, 300)
                    this.read()
                },
                save () {
                    if (this.editedIndex > -1) {
                        Object.assign(this.customersNew[this.editedIndex], this.editedCustomer)
                        axios.put('/customer/' + this.customersNew[this.editedIndex].id, {
                            editedCustomer: this.editedCustomer,
                        }).then((response) => {
                            //response
                        })
                    } else {
                        //this.customers.push(this.editedCustomer)
                        axios.post('/customer', {
                            editedCustomer: this.editedCustomer
                        }).then((response) => {
                            //response
                        })
                    }
                    this.close()
                },
                read() {
                    axios.get('/customer/read').then(({data}) => {
                        this.customersNew = data[0]
                    });
                }
            }
        }

</script>
