<template>
    <div id="task-archive">
        <span v-if="showNoTodos" class="text-gray-500 text-center">Keine Todos</span>
        <div v-for="(tasks, day) in groupedTasks">
            <task-section-headline :day="day"></task-section-headline>
            <div v-for="task in tasks" class="card mb-1">
                <task :item="task" @deleted="remove($event)"></task>
            </div>
        </div>
    </div>
</template>

<script>
import Task from './Task';
import Tasks from '../Mixins/Tasks';
import TaskSectionHeadline from '@/Components/TaskSectionHeadline';

export default {
    props: ['archived'],

    components: { Task, TaskSectionHeadline },

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
}
</script>
