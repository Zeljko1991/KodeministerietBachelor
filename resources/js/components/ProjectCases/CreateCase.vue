<template>
    <v-dialog v-model="dialog" max-width="600px">
            <v-btn slot="activator" class="mb-2">New Project</v-btn>
                <v-form>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container grid-list-md>
                                <v-layout wrap>
                                    <v-flex xs12>
                                        <v-text-field v-model="editedProjectCase.title" label="Project Title" required></v-text-field>
                                        <v-text-field v-model="editedProjectCase.description" label="Project Description" required></v-text-field>
                                        <v-text-field disabled v-model="editedProjectCase.customer_id" :value="this.customerid" label="Customer"></v-text-field>
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

    props: ['customerid', 'reread'],

    data() {
        return {
            dialog:false,
            editedIndex: -1,
            customerNew: this.customerid,
            editedProjectCase: {
            description: '',
            title: '',
            customer_id: this.customerid,
            },
        }
    },
            computed: {
                        formTitle () {
                            return this.editedIndex === -1 ? 'New Project' : 'Edit Project'
                        },
                    },
            watch: {
                dialog (val) {
                    val || this.close()
                }
            },
            methods: {
                        editProjectCase(item) {
                            this.editedIndex = this.projectCasesNew.indexOf(item)
                            this.editedProjectCase = Object.assign(item)
                            this.dialog = true
                        },
                        deleteProjectCase(item) {
                            const index = this.projectCasesNew.indexOf(item)
                            confirm('Are you sure you want to delete this item?') && axios.delete('/projectcase/' +item.id).then((response) => {
                                this.read();
                            })
                        },
                        close() {
                            this.dialog = false
                            setTimeout(() => {
                                this.editedProjectCase = Object.assign({}, this.defaultProjectCase)
                                this.editedIndex = -1
                            }, 300)
                            this.read()
                        },
                        save() {
                            if(this.editedIndex > -1) {
                                Object.assign(this.projectCasesNew[this.editedIndex], this.editedProjectCase)
                                axios.put('projectcase/' + this.projectCasesNew[this.editedIndex].id, {
                                    editedProjectCase: this.editedProjectCase,
                                }).then((response) => {
                                    //response
                                })
                            } else {
                                axios.post('/projectcase', {
                                    editedProjectCase: this.editedProjectCase
                                }).then((response) => {
                                    //response
                                })
                            }
                            this.close()
                        },
                        read() {
                            this.reread()
                        }
                    }
        }
</script>