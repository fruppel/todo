<template>
    <div id="task-list">
        <span v-show="showNoTodos" class="text-gray-500">Super, alles erledigt!</span>
        <transition-group name="fade" tag="div">
            <div v-for="(tasks, day) in groupedTasks" :key="day" v-show="showDay(tasks)">
                <strong>{{ showFormattedDay(day) }}</strong>
                <draggable :list="tasks" v-bind="getOptions()" @change="updateOrder">
                    <transition-group name="bounce" tag="div">
                        <task v-for="task in tasks"
                              :item="task"
                              :key="task.id"
                              class="mb-1"
                              @deleted="remove($event)"
                              @checked="archive(task)">
                        </task>
                    </transition-group>
                </draggable>
            </div>
        </transition-group>
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
            return Object.entries(this.groupedTasks).length === 0;
        },
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

        archive(task) {
            this.remove(task);
        },


        showDay(tasks) {
            return tasks.length > 0;
        }

    },
}
</script>

<style>
.bounce-enter-active {
    animation: bounce-in .6s;
}
.bounce-leave-active {
    animation: bounce-in .6s reverse;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity .6s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.15);
    }
    100% {
        transform: scale(1);
    }
}
</style>
