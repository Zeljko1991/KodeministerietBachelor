<template>
    <div>
        <v-toolbar color="#ECEFF1">
        <v-toolbar-title>Projects</v-toolbar-title>
        <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="600px" v-if="customers.length > 0">
            <v-btn slot="activator" color="#3949AB" dark class="mb-2">New Project</v-btn>
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
                                        <v-textarea v-model="editedProjectCase.description" label="Project Description" required></v-textarea>
                                        <v-autocomplete v-model="editedProjectCase.customer_id" :items="customers" item-text="firstName" item-value="id" label="Choose customer"></v-autocomplete>
                                    </v-flex>
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
            <v-btn v-else color="#3949AB" dark class="mb-2" v-bind:href="'/customer'">No customers: Go look!</v-btn>
      </v-toolbar>
        <v-card>
            <v-card-title>
                <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
            </v-card-title>

            <v-data-table :headers="headers" :items="projectCasesNew" :search="search">
                    <template slot="items" slot-scope="props">
                        <tr @click="props.expanded = !props.expanded">
                            <td class="text-xs-left">{{props.item.id}}</td>
                            <td class="text-xs-left">{{props.item.title}}</td>
                            <td class="text-xs-left">{{props.item.case_status.stage}}</td>
                            <td class="justify-center layout px-0">
                                <v-icon small class="mr-2" @click="editProjectCase(props.item)">edit</v-icon>
                                <v-icon small @click="deleteProjectCase(props.item)">delete</v-icon>
                            </td>
                        </tr>
                    </template>
                    <template slot="expand" slot-scope="props">
                    <v-container fluid grid-list-lg>
                        <v-layout row wrap>
                            <v-flex xs12 sm6 md4 v-for="(SubCase, index) in props.item.sub_cases" :key="index">
                                <v-card color="#ECEFF1" class="ma-1" height="100%">
                                    <v-card-title primary-title>
                                        <div class="headline">{{SubCase.title}}</div>
                                        <v-spacer></v-spacer>
                                        <!-- <v-btn flat :href="'/subcase/'+SubCase.id"><v-icon>assignment</v-icon> Go to subcase</v-btn> -->
                                        <v-btn flat :href="'/projectcase/'+props.item.id">Go to subcase</v-btn>
                                    </v-card-title>
                                    <v-card-text grow class="grow">
                                        <p  height="100%">{{SubCase.description}}</p>
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                        </v-layout>
                        <v-alert v-if="props.item.sub_cases.length == 0" :value="true" color="error" icon="warning">
                                This project has no sub cases: <subcase-create :projectcaseid="props.item.id" :reread="read" :stages="stages"></subcase-create>
                        </v-alert>
                    </v-container>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>

export default {

    props: ['projectcases', 'customers', 'stages'],

    data () {
      return {
        dialog: false,
        search:'',
        headers: [
          {
            text: 'Project Case ID',
            align: 'left',
            value: 'id'
          },
            {
            text: 'Project Title',
            align: 'left',
            value: 'projectTitle'
          },
             {
            text: 'Project Status',
            align: 'left',
            value: 'projectStatus'
          },
         {
            text: 'Actions',
            align: 'center',
            value: 'id',
            sortable: false
        }
        ],
        projectCasesNew: this.projectcases,
        editedIndex: -1,
        editedProjectCase: {
            description: '',
            title: '',
            customer_id: '',
        },
        defaultProjectCase: {
            description: '',
            title: '',
            customer_id: '',
        }
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
                    axios.get('projectcase/read').then(({data}) => {
                        this.projectCasesNew = data[0]
                    });
                }
            }
  }
</script>
