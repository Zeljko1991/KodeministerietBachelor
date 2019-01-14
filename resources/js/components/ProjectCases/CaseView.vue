<template>
    <v-card>
        <v-container fluid grid-list-lg>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card color="#ECEFF1">
                        <v-card-title primary-title>
                            <div>
                                <div class="headline left">{{projectCaseNew.title}}</div>
                            </div>
                        </v-card-title>
                        <v-card-text class="text-md-left">
                            <span>{{projectCaseNew.description}}</span>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn slot="activator" color="#3949AB" dark class="mb-2" @click="deleteProjectCase(projectCaseNew)">Delete Case</v-btn>
                            <v-btn color="#3949AB" dark class="mb-2" v-bind:href="'/PDF/'+projectCaseNew.id">Create Bill</v-btn>
                            <v-spacer></v-spacer>
                            <v-flex xs2 d-flex>
                                <v-select @change="changeStatus()"
                                    outline
                                    background-color="#3949AB"
                                    :items="casestatusesNew"
                                    item-text="stage"
                                    item-value="id"
                                    label="Status"
                                    v-model="newCaseStatus"
                                ></v-select>
                            </v-flex>
                        </v-card-actions>

                    </v-card>

                    <v-dialog v-model="hoursdialog" max-width="600px">
                        <v-form>
                            <v-card>
                                <v-card-title>
                                    <span class="headline">Add Hours to SubCase</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container grid-list-md>
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <v-text-field v-model="newHours.hours" label="Add some hrs" required v-validate="'required|numeric'" data-vv-name="subcase_hours" data-vv-scope="subcase_hours" :error-messages="errors.collect('subcase_hours', 'subcase_hours')"></v-text-field>
                                                <v-text-field disabled v-model="newHours.subcase_id" label="ID" required></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="#3949AB" @click="closeHours">Cancel</v-btn>
                                    <v-btn flat color="#3949AB" @click="commitHours">Add Hours</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-form>
                    </v-dialog>

                    <v-toolbar flat color="white">
                        <v-toolbar-title>Subcases</v-toolbar-title>
                        <v-spacer></v-spacer>

                            <v-dialog v-model="dialog" max-width="600px">
                            <v-btn slot="activator" color="#3949AB" dark class="mb-2">New Subcase</v-btn>
                                <v-form>
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container grid-list-md>
                                                <v-layout wrap>
                                                    <v-flex xs12>
                                                        <v-text-field v-model="editedSubCase.title" label="Subcase Title" required v-validate="'required'" data-vv-name="subcase_title" data-vv-scope="subcase" :error-messages="errors.collect('subcase_title', 'subcase')"></v-text-field>
                                                        <v-text-field v-model="editedSubCase.description" label="Subcase Description" required v-validate="'required'" data-vv-name="subcase_description" data-vv-scope="subcase" :error-messages="errors.collect('subcase_description', 'subcase')"></v-text-field>
                                                        <v-text-field v-model="editedSubCase.price" label="Subcase Price" required v-validate="'required|numeric'" data-vv-name="subcase_price" data-vv-scope="subcase" :error-messages="errors.collect('subcase_price', 'subcase')"></v-text-field>
                                                        <v-text-field disabled v-model="editedSubCase.project_case_id" :value="editedSubCase.project_case_id" label="Project Case number"></v-text-field>
                                                    </v-flex>
                                            <v-card-text>
                                                <v-btn color="info" @click="addNewDeliverable">Add deliverable</v-btn>
                                            <v-flex xs12 v-for="(deliverable, index) in editedSubCase.deliverables" :key="index">
                                            <v-card>
                                                <v-card-text>
                                                    <span class="text-md-right" @click="deleteDeliverable(index)"><v-icon medium color="red">remove_circle</v-icon></span>
                                                        <v-text-field v-model="deliverable.title" label="Deliverable" required v-validate="'required'" :data-vv-name="'deliverable_title'+index" data-vv-scope="subcase" :error-messages="errors.collect('deliverable_title'+index, 'subcase')"></v-text-field>
                                                        <v-text-field v-model="deliverable.price" label="Deliverable Price" required v-validate="'numeric'" :data-vv-name="'deliverable_price'+index" data-vv-scope="subcase" :error-messages="errors.collect('deliverable_price'+index, 'subcase')"></v-text-field>
                                                </v-card-text>
                                            </v-card>
                                            </v-flex>
                                            </v-card-text>
                                                </v-layout>
                                            </v-container>
                                        </v-card-text>
                                        <v-card-actions>
                                        <v-spacer></v-spacer>
                                            <v-btn color="#3949AB" flat @click="close">Cancel</v-btn>
                                            <v-btn color="#3949AB" flat @click="save()">Save</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-form>
                            </v-dialog>

                    </v-toolbar>
                </v-flex>
            </v-layout>
        </v-container>
        <v-card>
            <v-card-title>
                <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="subcasesNew" :search="search">
                <template slot="items" slot-scope="props">
                    <tr @click="props.expanded = !props.expanded">
                        <td class="text-xs-left">{{props.item.title}}</td>
                        <td class="text-xs-left">{{props.item.description}}</td>
                        <td class="text-xs-left">{{totalPrice(props.item)}}</td>
                        <td class="text-xs-left">{{sumHours(props.item)}}</td>
                        <td class="text-xs-left">
                            <v-icon small @click="editSubCase(props.item)">edit</v-icon>
                            <v-icon small @click="addHours(props.item.id)">alarm_add</v-icon>
                            <v-icon small @click="deleteSubCase(props.item)">delete</v-icon>
                        </td>
                    </tr>
                </template>
                <template slot="expand" slot-scope="props">
                    <v-container fluid grid-list-lg>
                        <v-layout row wrap>
                                <v-flex xs12>
                                    <v-card color="#3949AB">
                                        <kanban-board :deliverables="props.item.deliverables" :subcase="props.item.id" :showspec="read"></kanban-board>
                                    </v-card>
                                </v-flex>
                        </v-layout>
                    </v-container>
                </template>
            </v-data-table>
        </v-card>
        </v-card>

</template>

<script>
export default {
    props: ['projectcase', 'customers', 'subcases', 'casestatuses'],

    data () {
        return {
            projectCaseNew: this.projectcase,
            subcasesNew: this.subcases,
            casestatusesNew: this.casestatuses,
            newCaseStatus: this.projectcase.case_status_id,
            dialog: false,
            hoursdialog: false,
            search: '',
            headers: [
                {
                    text: 'Sub case title',
                    align: 'left',
                    value: 'title'
                },{
                    text: 'Description',
                    align: 'left',
                    value: 'description'
                },{
                    text: 'Price',
                    align: 'left',
                    value: 'price'
                },{
                    text: 'Total Hours worked',
                    align: 'left',
                    value: ''
                }, {
                    text: 'Actions',
                    align: 'left',
                    value: 'id',
                    sortable: false
                }
            ],
            editedIndex: -1,
            editedSubCase: {
                title: '',
                description: '',
                price: '',
                project_case_id: this.projectcase.id,
                deliverables:[{
                    title: '',
                    price: '',
                    id: '',
                }],
            },
            defaultSubCase: {
                title: '',
                description: '',
                price: '',
                project_case_id: this.projectcase.id,
                deliverables: [{
                    title: '',
                    price: '',
                    id: '',
                }],
            },
            newHours: {
                hours: '',
                subcase_id: ''
            },
            defaultHours: {
                hours: '',
                subcase_id: ''
            },
            dictionary: {
                custom: {
                    formScope: ['subcase', 'subcase_hours'],
                    subcase_hours: {
                        required: () => 'Hours are required',
                        numeric: () => 'Hours must be a number'
                    },
                    subcase_title: {
                        required: () => 'The subcase must have a title'
                    },
                    subcase_description: {
                        required: () => 'Please describe the subcase'
                    },
                    subcase_price: {
                        required: () => 'Please declare a price, may also be 0',
                        numeric: () => 'The price must be a number'
                    },
                    deliverable_title: {
                        required: () => 'The deliverable must have be named'
                    },
                    deliverable_price: {
                        numeric: () => 'The price must be a numeric value'
                    }
                }
            }
        }
    },

    mounted () {
        this.$validator.localize('en', this.dictionary)
    },
    
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New Subcase' : 'Edit Subcase'
        },
    },

    watch: {
        dialog (val) {
            val || this.close()
        }
    },

    methods: {
        changeStatus() {
            axios.put('/projectcase/updatestatus/' + this.projectcase.id, {
                editedProjectCase: this.newCaseStatus
            }).then((response) => {
                console.log(response.message)
            })
        },
        sumHours(item) {
            var totalHours = item.user_works_on.reduce(function(prev,cur) {
                return prev + cur.pivot.hrs
            }, 0)
            return totalHours
        },
        totalPrice(item) {
            var hourPrice = item.user_works_on.reduce(function(prev,cur) {
                return prev + cur.pivot.hrs
            }, 0) * 300;
            var delivPrice = item.deliverables.reduce(function(prev,cur) {
                return prev + cur.price
            }, 0);
            var total = Number(hourPrice) + Number(delivPrice) + Number(item.price)
            return total
        },
        addHours(id){
            this.newHours.subcase_id = id;
            this.hoursdialog = true;
        },

        commitHours() {
            this.$validator.validateAll('subcase_hours').then((result) => {
            if(!result) {
                alert('Hours must be valid')
                return
            }else{
            axios.post('/subcase/hrs/'+this.newHours.subcase_id, {
                newHours: this.newHours
            }).then((response) => {
                alert(JSON.stringify(response.data))
            }).catch((error) => {
                alert(error.response.data.message)
            });
            this.closeHours();
            }
            }).catch(() => {
                alert('Not valid, please try again')
            })
        },

        closeHours() {
            this.hoursdialog = false;
            this.newHours = Object.assign({}, this.defaultHours)
            this.clear()
            this.read()
        },

        editSubCase(item) {
            this.editedIndex = this.subcasesNew.indexOf(item)
            this.editedSubCase = Object.assign(item)
            this.dialog = true
        },

        deleteSubCase(item) {
            const index = this.subcasesNew.indexOf(item)
            confirm('Are you sure you want to delete this item?') && axios.delete('/subcase/' +item.id).then((response) => {
                this.read();
            })
        },

        close() {
            this.dialog = false
            this.editedSubCase = Object.assign({}, this.defaultSubCase)
            this.editedIndex = -1
            this.read()
            this.clear()
        },

        save() {
            this.$validator.validateAll('subcase').then((result) => {
            if(!result) {
                alert('The form must be valid')
                return
            }else{
            if(this.editedIndex > -1) {
                Object.assign(this.subcasesNew[this.editedIndex], this.editedSubCase)
                axios.put('/subcase/' + this.subcasesNew[this.editedIndex].id, {
                    editedSubCase: this.editedSubCase,
                }).then((response) => {
                    alert(JSON.stringify(response.data))
                }).catch((error) => {
                    alert(error.response.data.message)
                })
            } else {
                axios.post('/subcase', {
                    editedSubCase: this.editedSubCase
                }).then((response) => {
                    alert(JSON.stringify(response.data))
                }).catch((error) => {
                    alert(error.response.data.message)
                })
            }
            this.close()
            }
                }).catch(() => {
                    alert('Not valid')
                })
        },

        read() {
            axios.get('/projectcase/showread/' +this.projectcase.id).then(({data}) => {
                this.projectCaseNew = data['ProjectCase']
                this.subcasesNew = data['SubCases']
            });
        },
        addNewDeliverable() {
            this.editedSubCase.deliverables.push({
                title: '',
                price: ''
            })
        },
        deleteDeliverable(index) {
            this.editedSubCase.deliverables.splice(index, 1);
        },
        deleteProjectCase(item) {
            confirm('Are you sure you want to delete this item?') && axios.delete('/projectcase/' +item.id).then((response) => {
                window.location.href = "/dashboard"
            })
        },
        clear() {
            this.$validator.reset()
            this.errors.clear()
        }
    }
}

</script>
