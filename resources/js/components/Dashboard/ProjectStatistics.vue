<template>
    <v-card height="100%">
        <v-container fluid grid-list-lg>
            <v-layout row wrap>
                <v-flex xs12 class="text-md-left">Case statistics</v-flex>
                    <v-flex xs8 height="100%">
                        <v-card flat height="100%" class="pa-auto">
                            <ve-ring :data="chartData"></ve-ring>
                        </v-card>
                    </v-flex>
            </v-layout>
        </v-container>
    </v-card>
</template>

<script>
export default {
    props: ['newCases', 'pricingCases', 'billingCases', 'ongoingCases', 'completedCases'],
    data() {
        return {
            chartData: {
                columns: ['Status', 'Amount'],
                rows: [
                    {'Status': 'New', 'Amount' : this.newCases},
                    {'Status': 'Pricing', 'Amount' : this.pricingCases},
                    {'Status': 'Ongoing', 'Amount' : this.ongoingCases},
                    {'Status': 'Billing', 'Amount': this.billingCases},
                    {'Status': 'Completed', 'Amount': this.completedCases}
                ]
            },
        }
    }
}
</script>
