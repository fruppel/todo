<template>
    <div id="task-list">
        <span v-if="showNoTodos" class="text-gray-500">Keine Todos</span>
        <div v-for="(tasks, day) in groupedTasks">
            <strong>{{ showFormattedDay(day) }}</strong>
            <draggable :list="tasks" v-bind="getOptions()" @change="updateOrder">
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

    data() {
        return {
            groupedTasks: this.todo
        }
    },

    computed: {
        showNoTodos() {
            return this.groupedTasks.length === 0;
        }
    },

    methods: {
        getOptions() {
            return {
                group: 'undone',
                handle: '.drag-handle'
            };
        },

        updateOrder() {
            this.calculateIndices();

            axios.patch(route('taskorder.update'), {
                tasks: this.groupedTasks
            })
            .then(() => flash('Todo verschoben'))
            .catch(error => console.error(error))
        },

        showFormattedDay(day) {
            return moment(day, 'YYYY-MM-DD').format('dddd, DD.MM.YYYY');
        },

    },
}
</script>
