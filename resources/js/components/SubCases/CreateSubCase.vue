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
                                        <v-text-field v-model="editedSubCase.title" label="Project Title" required></v-text-field>
                                        <v-text-field v-model="editedSubCase.description" label="Project Description" required></v-text-field>
                                        <v-text-field v-model="editedSubCase.price" label="Project Price" required></v-text-field>
                                        <v-text-field disabled v-model="editedSubCase.project_case_id" :value="this.caseid" label="Project Case ID" required></v-text-field>
                                            <v-card-text>
                                                <v-btn color="info" @click="addNewDeliverable">Add deliverable</v-btn>
                                            <v-flex xs12 v-for="(deliverable, index) in editedSubCase.deliverables" :key="index">
                                            <v-card>
                                                <v-card-text>
                                                    <span class="text-md-right" @click="deleteDeliverable(index)"><v-icon medium color="red">remove_circle</v-icon></span>
                                                        <v-text-field v-model="deliverable.title" label="Deliverable"></v-text-field>
                                                        <v-text-field v-model="deliverable.price" label="Deliverable Price" required></v-text-field>
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
    }
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
                    setTimeout(() => {
                        this.editedSubCase = Object.assign({}, this.defaultSubCase)
                        this.editedIndex = -1
                    }, 300)
                    this.read()
                },
                save() {
                    if(this.editedIndex > -1) {
                        axios.put('/subcase/' + this.caseid, {
                            editedSubCase: this.editedSubCase,
                        }).then((response) => {
                            //response
                        })
                    } else {
                        axios.post('/subcase', {
                            editedSubCase: this.editedSubCase
                        }).then((response) => {
                            //response
                        })
                    }
                    this.close()
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
                }
    }
}
</script>
