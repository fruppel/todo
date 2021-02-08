<template>
    <div id="task-archive">
        <div v-for="(tasks, day) in groupedTasks">
            <strong>{{ showDay(day) }}</strong>
            <div v-for="task in tasks" class="card mb-1">
                <task :item="task" @statusToggled="move($event)" @deleted="remove($event)"></task>
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

    created() {
        this.groupedTasks = this.archived;
    },

    methods: {

        /**
         * Parses the day and produces a better readable output
         *
         * @param {String} day
         */
        showDay(day) {
            return moment(day, 'YYYY-MM-DD').format('DD.MM.YYYY');
        },

    }
}
</script>
