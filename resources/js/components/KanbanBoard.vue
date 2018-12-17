<template>
    <div class="visibility-drag row">
        <div class="col m4">
            <div class="card">
                <div class="card-content">
                <span class="card-title">To do</span>
                    <draggable class="collection plan-min-height" :list="deliverablesTodo" :options="{animation:200, group: 'planning'}" :element="'ul'" @add="onAdd($event, 1)" @change="updateTodo">
                        <li class="collection-item kanban-item" v-for="(item, index) in deliverablesTodoNew" :key="item.id" :data-id="item.id">
                            <div><strong>{{item.title}}</strong></div>
                            <div>{{item.quote}}</div>
                        </li>
                    </draggable>
                </div>
            </div>
        </div>
        <div class="col m4">
            <div class="card">
                <div class="card-content">
                <span class="card-title">Doing</span>
                    <draggable class="collection plan-min-height" :list="deliverablesDoing" :options="{animation:200, group: 'planning'}" :element="'ul'" @add="onAdd($event, 2)" @change="updateDoing">
                        <li class="collection-item kanban-item" v-for="(item, index) in deliverablesDoingNew" :key="item.id" :data-id="item.id">
                            <div><strong>{{item.title}}</strong></div>
                            <div>{{item.quote}}</div>
                        </li>
                    </draggable>
                </div>
            </div>
        </div>
        <div class="col m4">
            <div class="card">
                <div class="card-content">
                <span class="card-title">Done</span>
                    <draggable class="collection plan-min-height" :list="deliverablesDone" :options="{animation:200, group: 'planning'}" :element="'ul'" @add="onAdd($event, 3)" @change="updateDone">
                        <li class="collection-item kanban-item" v-for="(item, index) in deliverablesDoneNew" :key="item.id" :data-id="item.id">
                            <div><strong>{{item.title}}</strong></div>
                            <div>{{item.quote}}</div>
                        </li>
                    </draggable>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable
        },
        props: ['deliverablesTodo', 'deliverablesDoing', 'deliverablesDone', 'subcase'],

        data() {
            return {
                deliverablesTodoNew: this.deliverablesTodo,
                deliverablesDoingNew: this.deliverablesDoing,
                deliverablesDoneNew: this.deliverablesDone,

            }
        },

        methods: {
            onAdd(event, stage) {
                let id = event.item.getAttribute('data-id');
                axios.patch('/visibility/' + id,
                {stage: stage}
                );
            },
            updateTodo() {
                this.deliverablesTodo.map((deliverables, index) => {
                    deliverables.order = index + 1;
                })

                axios.put('/update/' + this.subcase, {
                    deliverables: this.deliverablesTodo
                }).then((response) => {
                    //success
                })
            },
            updateDoing() {
                this.deliverablesDoing.map((deliverables, index) => {
                    deliverables.order = index + 1;
                })
                axios.put('/update/' + this.subcase, {
                    deliverables: this.deliverablesDoingNew
                }).then((response) => {
                    //success
                })
            },
            updateDone() {
                this.deliverablesDone.map((deliverables, index) => {
                    deliverables.order = index + 1;
                })
                axios.put('/update/' + this.subcase, {
                    deliverables: this.deliverablesDone
                }).then((response) => {
                    //success
                })
            }
        },

        mounted() {
        }
    }
</script>
