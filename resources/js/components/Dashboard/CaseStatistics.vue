<template>
    <v-card height="100%">
        <v-container fluid grid-list-lg height="100%">
            <v-layout row wrap>
                <v-flex xs12 class="text-md-left">Upcoming deadlines & ongoing cases</v-flex>
                <v-flex xs4 height="100%">
                    <v-card flat height="100%" class="pa-auto">
                        <v-card-text>
                            <v-icon height="100%" size="150px" class="ma-auto">assignment</v-icon>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex xs8>
                    <v-card height="100%">
                        <v-list two-line>
                            <template v-for="(item, index) in projectCaseNew">
                                <v-list-tile :key="item.title">
                                    <v-list-tile-content>
                                        <v-list-tile-title>{{item.title}}</v-list-tile-title>
                                        <v-progress-linear :value="calculateProgress(item)"></v-progress-linear>
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-list-tile-action-text>
                                        {{item.created_at.split(' ')[0]}}
                                        </v-list-tile-action-text>
                                        <v-btn flat icon v-bind:href="'/projectcase/'+item.id">
                                            <v-icon large color="grey lighten-1" class="ma-auto">date_range</v-icon>
                                        </v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </template>
                        </v-list>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-card>
</template>

<script>
export default {
    props: ['projectCase'],

    data() {
        return {
            projectCaseNew: this.projectCase,
            calcProgress: '',

        }
    },
    methods: {
        calculateProgress(item) {
            this.calcProgress = Object.assign(item)
            this.deliverablesDone = this.calcProgress.sub_cases[0].deliverables.filter(function(deliverable) {
                return deliverable.stage == 3;
            })
            this.origin = this.calcProgress.sub_cases[0].deliverables.length
            this.value = this.deliverablesDone.length / this.origin * 100
            return this.value
        }
    }
}
</script>
