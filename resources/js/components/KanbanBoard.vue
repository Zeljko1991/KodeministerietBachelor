<template>
    <v-container fluid grid-list-lg>
        <v-layout row wrap>
            <v-flex xs4>
                <v-card light class="ma-1" height="100%" color="grey lighten-2">
                    <v-card-title primary-title>
                        <div class="headline">To Do</div>
                    </v-card-title>
                        <draggable class="collection plan-min-height" :list="deliverablesTodoNew" :options="{animation:200, group: 'planning'}" :element="'div'" @add="onAdd($event, 1)" @change="updateTodo" height="100%">
                            <v-card class="collection-item kanban-item" v-for="(item, index) in deliverablesTodoNew" :key="item.id" :data-id="item.id">
                                <v-card-title><strong>{{item.title}}</strong><v-spacer></v-spacer>{{item.price}},-</v-card-title>
                            </v-card>
                        </draggable>
                </v-card>
            </v-flex>
            <v-flex xs4>
                <v-card light class="ma-1" height="100%" color="grey lighten-2">
                    <v-card-title primary-title>
                        <div class="headline">Doing</div>
                    </v-card-title>
                        <draggable class="collection plan-min-height" :list="deliverablesDoingNew" :options="{animation:200, group: 'planning'}" :element="'div'" @add="onAdd($event, 2)" @change="updateDoing" height="100%">
                            <v-card class="collection-item kanban-item" v-for="(item, index) in deliverablesDoingNew" :key="item.id" :data-id="item.id">
                                <v-card-title><strong>{{item.title}}</strong><v-spacer></v-spacer>{{item.price}},-</v-card-title>
                            </v-card>
                        </draggable>
                </v-card>
            </v-flex>
            <v-flex xs4>
                <v-card light class="ma-1" height="100%" color="grey lighten-2">
                    <v-card-title primary-title>
                        <div class="headline">Done</div>
                    </v-card-title>
                        <draggable class="collection plan-min-height" :list="deliverablesDoneNew" :options="{animation:200, group: 'planning'}" :element="'div'" @add="onAdd($event, 3)" @change="updateDone" height="100%">
                            <v-card class="collection-item kanban-item" v-for="(item, index) in deliverablesDoneNew" :key="item.id" :data-id="item.id">
                                <v-card-title><strong>{{item.title}}</strong><v-spacer></v-spacer>{{item.price}},-</v-card-title>
                            </v-card>
                        </draggable>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable
        },
        props: ['deliverables', 'subcase', 'showspec'],

        data() {
            return {
                deliverablesTodoNew: this.deliverables.filter(function(deliverable) {
                    return deliverable.stage == 1;
                }),
                deliverablesDoingNew: this.deliverables.filter(function(deliverable) {
                    return deliverable.stage == 2;
                }),
                deliverablesDoneNew: this.deliverables.filter(function(deliverable) {
                    return deliverable.stage == 3;
                }),

            }
        },

        methods: {
            onAdd(event, stage) {
                let id = event.item.getAttribute('data-id');
                    axios.patch('/visibility/' + id,
                    {stage: stage}
                ).then((response) => {
                    this.showspec()
                });
            },
            updateTodo() {
                this.deliverablesTodoNew.map((deliverables, index) => {
                    deliverables.order = index + 1;
                })

                axios.put('/update/' + this.subcase, {
                    deliverables: this.deliverablesTodoNew
                }).then((response) => {
                    this.showspec()
                })
            },
            updateDoing() {
                this.deliverablesDoingNew.map((deliverables, index) => {
                    deliverables.order = index + 1;
                })
                axios.put('/update/' + this.subcase, {
                    deliverables: this.deliverablesDoingNew
                }).then((response) => {
                    this.showspec()
                })
            },
            updateDone() {
                this.deliverablesDoneNew.map((deliverables, index) => {
                    deliverables.order = index + 1;
                })
                axios.put('/update/' + this.subcase, {
                    deliverables: this.deliverablesDoneNew
                }).then((response) => {
                    this.showspec()
                })
            }
        },

        computed: {
            filterDeliverables: function() {
                deliverablesTodoNew = this.deliverables.filter(function(deliverable) {
                    return deliverable.stage == 1;
                }),
                deliverablesDoingNew = this.deliverables.filter(function(deliverable) {
                    return deliverable.stage == 2;
                }),
                deliverablesDoneNew = this.deliverables.filter(function(deliverable) {
                    return deliverable.stage ==3;
                })
            }
        },

        mounted() {
        }
    }
</script>
