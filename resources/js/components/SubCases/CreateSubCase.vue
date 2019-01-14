<template>
    <v-dialog v-model="dialog" max-width="600px">
            <v-btn slot="activator" class="mb-2">New Sub Case</v-btn>
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
                                        <v-text-field disabled v-model="editedSubCase.project_case_id" :value="this.caseid" label="Project Case ID" required></v-text-field>
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
</template>

<script>
export default {

props: ['projectcaseid', 'reread', 'stages'],

data() {
    return {
        stagesNew: this.stages,
        dialog: false,
        editedIndex: -1,
        caseid: this.projectcaseid,
        editedSubCase: {
            title: '',
            description: '',
            price: '',
            project_case_id: this.projectcaseid,
            deliverables:[{
                title: '',
                price: ''
            }],
        },
        defaultSubCase: {
            title: '',
            description: '',
            price: '',
            project_case_id: this.projectcaseid,
            deliverables: [{
                title: '',
                price: ''
            }],
        },
        
        dictionary: {
                custom: {
                    formScope: 'subcase',
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
            formTitle () {
                return this.editedIndex === -1 ? 'New Sub Case' : 'Edit Sub Case'
            },
        },
        watch: {
            dialog (val) {
                val || this.close()
            }
        },
        methods: {
            close() {
                this.dialog = false
                this.editedSubCase = Object.assign({}, this.defaultSubCase)
                this.editedIndex = -1
                this.clear()
                this.read()
            },
            save() {
                this.$validator.validateAll('subcase').then((result) => {
                    if(!result) {
                        alert('The form must be valid')
                        return
                    }
                
                if(this.editedIndex > -1) {
                    axios.put('/subcase/' + this.caseid, {
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
                }).catch(() => {
                    alert('Not valid, please try again')
                })
            },
                read() {
                this.reread()
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
            clear() {
                this.$validator.reset()
                this.errors.clear()
            }
    }
}
</script>
