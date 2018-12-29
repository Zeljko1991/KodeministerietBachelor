<template>
    <v-card>
        <v-container fluid grid-list-lg>
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card color="blue-grey darken-2" class="white--text">
                        <v-card-title primary-title>
                            <div>
                                <div class="headline">{{projectCaseNew.title}}</div>
                                <span>{{projectCaseNew.description}}</span>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <v-btn flat dark>Edit/delete here</v-btn>
                        </v-card-actions>
                    </v-card>
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
                        <td class="text-xs-left">{{props.item.price}}</td>
                    </tr>
                </template>
                <template slot="expand" slot-scope="props">
                    <v-container fluid grid-list-lg>
                        <v-layout row wrap>
                            <v-card>
                                
                            </v-card>
                        </v-layout>
                    </v-container>
                </template>
            </v-data-table>
        </v-card>
        </v-card>
        
</template>

<script>
export default {
    props: ['projectcase', 'subcases'],

    data () {
        return {
        projectCaseNew: this.projectcase,
        subcasesNew: this.subcases,
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
            }
        ]
        }
    }
}
</script>
