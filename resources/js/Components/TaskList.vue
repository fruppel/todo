<template>

    <div id="task-list">
        <transition name="fadein">
            <div v-if="showNoTodos" class="text-gray-500 text-center">Super, alles erledigt!</div>
        </transition>
        <transition-group name="fade" tag="div">
            <div v-for="(tasks, day) in groupedTasks" :key="groupKey(day)" v-show="showDay(tasks)" class="mb-3">
                <task-section-headline :day="day"></task-section-headline>
                <draggable
                    :list="tasks"
                    v-bind="getOptions()"
                    @change="updateOrder"
                    @start="drag = true"
                    @end="drag = false"
                >
                    <transition-group
                        :name="drag === false ? 'bounce' : null"
                        tag="div"
                        @after-leave="afterLeave(day)"
                    >
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
import Task from '@/Components/Task';
import TaskSectionHeadline from '@/Components/TaskSectionHeadline';
import Tasks from '../Mixins/Tasks';

export default {
    props: ['todo'],

    mixins: [Tasks],

    components: {
        Task,
        TaskSectionHeadline,
        draggable
    },

    data() {
        return {
            groupedTasks: this.todo,
            drag: false
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

            this.$http.patch(route('taskorder.update'), {
                tasks: this.groupedTasks
            })
            .then(() => flash('Todo verschoben'))
            .catch(error => console.error(error))
        },

        showFormattedDay(day) {

        },

        archive(task) {
            this.remove(task);
        },

        showDay(tasks) {
            return tasks.length > 0;
        },

        afterLeave(day) {
            if (this.groupedTasks[day].length === 0) {
                delete this.groupedTasks[day];
                this.groupedTasks = Object.assign({}, this.groupedTasks);
            }
        },

        groupKey(day) {
            return day;
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

.fadein-enter-active, .fadein-leave-active {
    transition: opacity .6s;
}

.fadein-enter, .fadein-leave-to {
    opacity: 1;
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
