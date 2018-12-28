<template>
    <v-card>
        <h1 v-for="(item, index) in ProjectCase" :key="item.id">{{item.title}}</h1>
    </v-card>
</template>

<script>
export default {
    props: ['ProjectCase'], 

    data() {
        return {
            ProjectCaseNew: this.ProjectCase
        }
    }
} 
</script>
