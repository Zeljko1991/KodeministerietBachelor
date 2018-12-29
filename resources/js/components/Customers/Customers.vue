<template>
    <div>
        <v-toolbar flat color="white">
        <v-toolbar-title>Customers</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="600px">
          <v-btn slot="activator" color="primary" dark class="mb-2">New Customer</v-btn>
         <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="save">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                </v-card-title>
  
                <v-card-text>
                    <v-container grid-list-md>  
                        <v-layout wrap>
                            <v-flex xs12>
                                <v-text-field v-model="editedCustomer.companyName" label="Company" required :rules="rules.companyNameRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.firstName" label="First Name" required :rules="rules.firstNameRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.lastName" label="Surname" required :rules="rules.lastNameRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.eMail" label="Email address" required :rules="rules.emailRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.phoneNumber" label="Phone Number" required :counter="8" maxlength="8" :rules="rules.phoneNumberRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 d-flex>
                                <v-select :items="CVR" v-model="CVRVal" label="EAN or CVR?" ></v-select>
                            </v-flex>
                            <v-flex xs12 sm6 v-if="EANorCVR === 'CVR'">
                                <v-text-field v-model="editedCustomer.CVR" label="CVR" required :counter="8" maxlength="8" :rules="rules.CVRRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 v-if="EANorCVR === 'EAN'">
                                <v-text-field v-model="editedCustomer.EAN" label="EAN" required :counter="13" maxlength="13" :rules="rules.EANRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.street" label="Street" required :rules="rules.streetRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.streetNumber" label="Street Number" required :rules="rules.streetNumberRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.zipCode" label="Zip" required :counter="4" maxlength="4" :rules="rules.zipCodeRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.city" label="City" required :rules="rules.cityRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field v-model="editedCustomer.address.country" label="Country" required :rules="rules.countryRules"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                    <v-btn type="submit" color="blue darken-1" flat >Save</v-btn>
                </v-card-actions>
            </v-card>
          </v-form>
        </v-dialog>
      </v-toolbar>
        <v-card>
            <v-card-title>
                <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="customersNew" :search="search">
                <template slot="items" slot-scope="props">
                    <tr @click="props.expanded = !props.expanded">
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
                    </tr>
                </template>
                <template slot="expand" slot-scope="props">
                    <v-container fluid grid-list-lg>
                        <v-layout row wrap>
                            <v-flex xs12 sm6 md4 v-for="(ProjectCase, index) in props.item.project_case" :key="index">
                                <v-card light class="ma-1" height="100%">
                                    <v-card-title primary-title>
                                        <div class="headline">{{ProjectCase.title}}</div>  
                                        <v-spacer></v-spacer>  
                                        <v-btn flat :href="'/projectcase/'+ProjectCase.id">Go to case</v-btn>
                                    </v-card-title>
                                    <v-card-text grow class="grow">
                                        <p  height="100%">{{ProjectCase.description}}</p>
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
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
            valid: true,
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
            CVRVal: 'CVR',
            CVR: [
                'CVR', 
                'EAN'
            ],
            editedIndex: -1,
            editedCustomer: {
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
            rules: {
                companyNameRules: [
                    v => !!v || 'The Company name is required',
                    v => (v && v.length > 1) || 'Company name must be longer than one symbol'
                ],
                firstNameRules: [
                    v => !!v || 'First name is required',
                    v => (v && v.length > 1) || 'First name must be longer than one symbol'
                ],
                lastNameRules: [
                    v => !!v || 'Surname is required',
                    v => (v && v.length > 1) || 'Surname must be longer than one symbol'
                ],
                emailRules: [
                    v => !!v || 'Email is required',
                    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
                ],
                phoneNumberRules: [
                    v => !!v || 'Phone number is required',
                    v => (v && v.length >= 8) || 'Phone number must be 8 digits',
                    v => (v && !isNaN(v)) || 'Phone number must be a number',     
                ],
                CVRRules: [
                    v => !!v || 'CVR or EAN is required',
                    v => (v && v.length >= 8) || 'CVR must be 8 digits',
                    v => (v && !isNaN(v)) || 'CVR must be a number', 
                ],
                EANRules: [
                    v => !!v || 'CVR or EAN is required',
                    v => (v && v.length >= 13) || 'EAN must be 13 digits',
                    v => (v && !isNaN(v)) || 'EAN must be a number',
                ],
                streetRules: [
                    v => !!v || 'Street is required',
                    v => (v && v.length > 1 ) || 'Street must be longer than one symbol'
                ],
                streetNumberRules: [
                    v => !!v || 'Street number is required'
                ],
                zipCodeRules: [
                    v => !!v || 'Zip code is required',
                    v => (v && v.length >= 4) || 'Zip code must be 4 digits',
                    v => (v && !isNaN(v)) || 'Zip code must be a number'
                ],
                cityRules: [
                    v => !!v || 'City is required',
                    v => (v && v.length > 1) || 'City must be more than one symbol'
                ], 
                countryRules: [
                    v => !!v || 'Country is required',
                    v => (v && v.length > 1) || 'Country must be longer than one symbol' 
                ]
            },  
        }
    },
            
            computed: {
                formTitle () {
                    return this.editedIndex === -1 ? 'New Customer' : 'Edit Customer'
                },
                EANorCVR() {
                    return this.CVRVal === 'CVR' ? 'CVR' : 'EAN'
                }
            },

            watch: {
                dialog (val) {
                    val || this.close()
                }
            },

            methods: {
                editCustomer(item) {
                    this.clear()
                    this.editedIndex = this.customersNew.indexOf(item)
                    this.editedCustomer = Object.assign(item)
                    if(this.editedCustomer.CVR !== null) {
                        this.CVRVal = 'CVR'
                    } else {
                        this.CVRVal = 'EAN'
                    }
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
                    this.clear()
                },
                save () {
                    if (this.$refs.form.validate()){
                        if (this.editedIndex > -1) {
                            Object.assign(this.customersNew[this.editedIndex], this.editedCustomer)
                            axios.put('/customer/' + this.customersNew[this.editedIndex].id, {
                                editedCustomer: this.editedCustomer,
                            }).then((response) => {
                                
                            }).catch((error) => {
                                alert(error.message)
                            })
                        } else {
                            //this.customers.push(this.editedCustomer)
                            axios.post('/customer', {
                                editedCustomer: this.editedCustomer
                            }).then((response) => {
                                
                            }).catch((error) => {
                                alert(error.message)
                            })
                        }
                        this.close()
                    }
                    
                },
                read() {
                    axios.get('/customer/read').then(({data}) => {
                        this.customersNew = data[0]
                    });
                },
                clear() {
                    this.$refs.form.resetValidation()
                }
            }
        }

</script>
