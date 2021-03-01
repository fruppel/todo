<template>
    <div id="task-archive">
        <span v-if="showNoTodos" class="text-gray-500">Keine Todos</span>
        <div v-for="(tasks, day) in groupedTasks">
            <strong>{{ showDay(day) }}</strong>
            <div v-for="task in tasks" class="card mb-1">
                <task :item="task" @deleted="remove($event)"></task>
            </div>
        </div>
    </div>
</template>

<script>
import Task from './Task';
import Tasks from '../Mixins/Tasks';

export default {
    props: ['archived'],

    components: { Task },

    mixins: [ Tasks ],

    data() {
        return {
            groupedTasks: this.archived
        }
    },

    computed: {
        showNoTodos() {
            return this.groupedTasks.length === 0;
        }
    },

    methods: {
        showDay(day) {
            return moment(day, 'YYYY-MM-DD').format('DD.MM.YYYY');
        },
    }
}
</script>
