<template>
    <div id="task-list">
        <div v-for="(tasks, day) in groupedTasks">
            <strong>{{ showDay(day) }}</strong>
            <draggable :list="tasks" :options="{group: 'undone', handle: '.drag-handle'}" @change="updateOrder">
                <div v-for="task in tasks" class="card mb-1">
                    <task :item="task" @deleted="remove($event)"></task>
                </div>
            </draggable>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
import Task from './Task';
import tasks from '../mixins/tasks';

export default {
    props: ['todo'],

    mixins: [tasks],

    components: {
        Task, draggable
    },

    created() {
        this.groupedTasks = this.todo;
    },

    methods: {

        updateOrder() {
            this.calculateIndices();

            axios.patch('/tasks/updateOrder', {
                tasks: this.groupedTasks
            })
        },

        /**
         * Parses the day and produces a better readable output
         *
         * @param {String} day
         */
        showDay(day) {
            return moment(day, 'YYYY-MM-DD').format('dddd, DD.MM.YYYY');
        },

    },
}
</script>