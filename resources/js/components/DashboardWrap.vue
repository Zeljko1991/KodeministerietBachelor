<template>
        <case-statistics :project-case="ProjectCase"></case-statistics>
</template>

<script>
import draggable from 'vuedraggable'
import CaseStatistics from './CaseStatistics'
export default {
    components: {
        draggable,
        'case-statistics': CaseStatistics
    },
    props: ['ProjectCase'],
    
    data() {
        return {
            ProjectCaseNew: this.ProjectCase,
            valueDeterminate: 50
        }
    }
}
</script>
