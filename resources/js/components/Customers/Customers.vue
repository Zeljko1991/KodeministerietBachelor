<template>
    <div>
        <v-toolbar flat color="white">
        <v-toolbar-title>Customers</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="600px">
          <v-btn slot="activator" color="#3949AB" dark class="mb-2">New Customer</v-btn>
         <v-form ref="form" v-model="valid"  @submit.prevent="save">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>  
                        <v-layout wrap>
                            <v-flex xs12>
                                <v-text-field v-model="editedCustomer.companyName" label="Company" required v-validate="'required'" data-vv-name="company_name" :error-messages="errors.collect('company_name')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.firstName" label="First Name" required v-validate="'required'" data-vv-name="first_name" :error-messages="errors.collect('first_name')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.lastName" label="Surname" required v-validate="'required'" data-vv-name="last_name" :error-messages="errors.collect('last_name')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.eMail" label="Email address" required v-validate="'required|email'" data-vv-name="email" :error-messages="errors.collect('email')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.phoneNumber" label="Phone Number" required :counter="8" maxlength="8" v-validate="'required|digits:8'" data-vv-name="phone_number" :error-messages="errors.collect('phone_number')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 d-flex>
                                <v-select :items="CVR" v-model="CVRVal" label="EAN or CVR?" ></v-select>
                            </v-flex>
                            <v-flex xs12 sm6 v-if="EANorCVR === 'CVR'">
                                <v-text-field v-model="editedCustomer.CVR" label="CVR" required :counter="8" maxlength="8" v-validate="'required|digits:8'" data-vv-name="CVR" :error-messages="errors.collect('CVR')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 v-if="EANorCVR === 'EAN'">
                                <v-text-field v-model="editedCustomer.EAN" label="EAN" required :counter="13" maxlength="13" v-validate="'required|digits:13'" data-vv-name="EAN" :error-messages="errors.collect('EAN')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.street" label="Street" required v-validate="'required'" data-vv-name="street" :error-messages="errors.collect('street')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.streetNumber" label="Street Number" required v-validate="'required'" data-vv-name="street_number" :error-messages="errors.collect('street_number')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.zipCode" label="Zip" required :counter="4" maxlength="4" v-validate="'required|digits:4'" data-vv-name="zip_code" :error-messages="errors.collect('zip_code')"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field v-model="editedCustomer.address.city" label="City" required v-validate="'required'" data-vv-name="city" :error-messages="errors.collect('city')"></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field v-model="editedCustomer.address.country" label="Country" required v-validate="'required'" data-vv-name="country" :error-messages="errors.collect('country')"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                    <v-btn color="#3949AB" flat @click="close">Cancel</v-btn>
                    <v-btn type="submit" color="#3949AB" flat >Save</v-btn>
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
                                <v-card color="#ECEFF1" class="ma-1" height="100%">
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
                        <v-alert v-if="props.item.project_case.length == 0" :value="true" color="error" icon="warning">
                                This customer has no cases: <projectcase-create :customerid="props.item.id" :reread="read"></projectcase-create>
                        </v-alert>
                    </v-container>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
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
            dictionary: {
                custom: {
                    company_name: {
                        required: () => 'The company name is required'
                    },
                    first_name: {
                        required: () => 'First name is required'
                    },
                    last_name: {
                        required: () => 'Last name is required'
                    },
                    email: {
                        required: () => 'Email is required',
                        email: () => 'Must be a valid email'
                    },
                    phone_number: {
                        required: () => 'Phone number is required',
                        digits: () => 'Phone number must be 8 digits'
                    },
                    CVR: {
                        required: () => 'CVR is required',
                        digits: () => 'CVR must be 8 digits'
                    },
                    EAN: {
                        required: () => 'EAN is required',
                        digits: () => 'EAN must be 13 digits'
                    },
                    street: {
                        required: () => 'Street is required'
                    },
                    street_number: {
                        required: () => 'Street number is required',
                    },
                    zip_code: {
                        required: () => 'Zip code is required',
                        digits: () => 'Zip code must be 4 digits'
                    },
                    city: {
                        required: () => 'City is required'
                    },
                    country: {
                        required: () => 'Country is required'
                    },

                }
            }  
        }
    },
            mounted () {
                this.$validator.localize('en', this.dictionary)
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
                    this.editedCustomer = Object.assign({}, this.defaultCustomer)
                    this.editedCustomer.address = Object.assign({}, this.defaultCustomer.address)
                    this.editedIndex = -1
                    this.read()
                    this.clear()
                },
                save () {
                    this.$validator.validateAll().then((result) => {
                        if(!result) {
                            alert('The form must be valid')
                            return
                        }
                        if (this.editedIndex > -1) {
                            Object.assign(this.customersNew[this.editedIndex], this.editedCustomer)
                            axios.put('/customer/' + this.customersNew[this.editedIndex].id, {
                                editedCustomer: this.editedCustomer,
                            }).then((response) => {
                                alert(JSON.stringify(response.data))
                                this.close()
                            }).catch((error) => {
                                alert(error.response.data.message)
                            })
                        } else {
                            //this.customers.push(this.editedCustomer)
                            axios.post('/customer', {
                                editedCustomer: this.editedCustomer
                            }).then((response) => {
                                alert(JSON.stringify(response.data))
                                this.close()
                            }).catch((error) => {
                                alert(error.response.data.message)
                            })
                        }
                        }).catch(() => {
                            alert('Not valid')
                            this.close()
                            this.clear()
                        })
                },
                read() {
                    axios.get('/customer/read').then(({data}) => {
                        this.customersNew = data[0]
                    });
                },
                clear() {
                    this.$validator.reset()
                    this.errors.clear()
                }
            }
        }

</script>
