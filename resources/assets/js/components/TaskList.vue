<template>
    <div id="task-list">
        <div v-for="(tasks, day) in groupedTasks">
            <strong>{{ showDay(day) }}</strong>
            <draggable :list="tasks" :options="{group: 'undone', handle: '.drag-area'}" @change="update">
                <div v-for="task in tasks" class="card mb-1">
                    <task :item="task"></task>
                </div>
            </draggable>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
import Task from './Task';

export default {
    props: ['taskDays'],

    data() {
        return {
            groupedTasks: this.taskDays
        };
    },

    components: {
        Task, draggable
    },

    methods: {

        update() {
            this.updateIndices();

            axios.patch('/tasks/updateOrder', {
                tasks: this.groupedTasks
            })
        },

        /**
         * Recalculates all indizes and updates them
         */
        updateIndices() {

            let newIndex = 1;

            for (let key in this.groupedTasks) {

                if (!this.groupedTasks.hasOwnProperty(key) || !Array.isArray(this.groupedTasks[key])) {
                    return;
                }

                for (let task in this.groupedTasks[key]) {
                    this.groupedTasks[key][task].day = key;
                    this.groupedTasks[key][task].order = newIndex++;
                }

            }

        },

        /**
         * Deletes a task from database and the grouped task object
         */
        deleteTask(task) {
            if (!confirm('Wirklich löschen?')) {
                return;
            }

            axios.delete('/tasks/' + task.id)
                .then(() => {
                    for (let index in this.groupedTasks[task.day]) {
                        if (this.groupedTasks[task.day][index].id === task.id) {
                            this.groupedTasks[task.day].splice(index, 1);
                        }
                    }
                });
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

<style lang="scss" scoped>
    .task-row {
        padding: 0.5rem;

        label {
            margin: 0;
        }

        .drag-handle {
            cursor: pointer;
        }

        .description {
            &.finished {
                text-decoration: line-through;
            }

            user-select: none;
        }
    }
</style>