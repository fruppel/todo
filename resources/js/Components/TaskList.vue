<template>
    <div id="task-list">
        <div v-for="(tasks, day) in groupedTasks">
            <strong>{{ showFormattedDay(day) }}</strong>
            <draggable :list="tasks" :options="{group: 'undone', handle: '.drag-handle'}" @change="updateOrder">
                <div v-for="task in tasks" class="mb-1">
                    <task :item="task" @statusToggled="move($event)" @deleted="remove($event)"></task>
                </div>
            </draggable>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
import Task from './Task';
import Tasks from '../Mixins/Tasks';

export default {
    props: ['todo'],

    mixins: [Tasks],

    components: {
        Task, draggable
    },

    created() {
        this.groupedTasks = this.todo;
    },

    methods: {

        /**
         * Updates the order of all items
         */
        updateOrder() {
            this.calculateIndices();

            axios.patch('/tasks/updateOrder', {
                tasks: this.groupedTasks
            }).then(() => {
                flash('Aufgabe verschoben');
            });
        },

        /**
         * Parses the day and produces a better readable output
         *
         * @param {String} day
         */
        showFormattedDay(day) {
            return moment(day, 'YYYY-MM-DD').format('dddd, DD.MM.YYYY');
        },

    },
}
</script>