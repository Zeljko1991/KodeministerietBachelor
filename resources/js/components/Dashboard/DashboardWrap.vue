<template>
    <v-container fluid grid-list-lg>
        <v-layout row rap>
            <v-flex xs12 sm6>
                <case-statistics :project-case="ProjectCase"></case-statistics>
            </v-flex>
            <v-flex xs12 sm6>
                <project-statistics :new-cases="newCases" :pricing-cases="pricingCases" :billing-cases="billingCases" :ongoing-cases="ongoingCases" :completed-cases="completedCases"></project-statistics>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import draggable from 'vuedraggable'
import CaseStatistics from './CaseStatistics'

export default {
    components: {
        draggable,
        'case-statistics': CaseStatistics
    },
    props: ['ProjectCase', 'AllCases'],
    
    data() {
        return {
            newCases: this.AllCases.filter(function(deliverable) {
                return deliverable.case_status_id == 1;
            }).length,
            pricingCases: this.AllCases.filter(function(deliverable){
                return deliverable.case_status_id == 2;
            }).length,
            ongoingCases: this.AllCases.filter(function(deliverable) {
                return deliverable.case_status_id == 3;
            }).length,
            billingCases: this.AllCases.filter(function(deliverable) {
                return deliverable.case_status_id == 4;
            }).length,
            completedCases: this.AllCases.filter(function(deliverable) {
                return deliverable.case_status_id == 5;
            }).length,
            ProjectCaseNew: this.ProjectCase,
            AllCasesNew: this.AllCases,
        }
    }
}
</script>
