<template>
    <div class="task d-flex align-items-center" :class="taskClass(item)" >
        <div class="d-flex align-items-center pr-1" @click="toggleStatus(item)">
            <div class="drag-handle p-1 pr-3" v-if="!item.finished">
                <font-awesome-icon :icon="iconOrder" />
            </div>
            <font-awesome-icon class="mr-3" :icon="item.finished ? iconChecked : iconUnchecked" />
            <div class="description" :class="item.finished ? 'finished' : ''">
                {{ item.description }}
            </div>
        </div>
        <div class="buttons ml-auto text-nowrap">
            <a class="btn btn-sm btn-outline-info" :href="'/tasks/' + item.id + '/edit/'">
                <font-awesome-icon :icon="iconEdit" />
            </a>
            <button class="btn btn-sm btn-outline-danger" @click="deleteTask(item)">
                <font-awesome-icon :icon="iconTrash" />
            </button>
        </div>
    </div>
</template>

<script>
import FontAwesomeIcon from '@fortawesome/vue-fontawesome';
import { faEllipsisV, faEdit, faTrash } from '@fortawesome/fontawesome-free-solid';
import { faSquare, faCheckSquare } from '@fortawesome/fontawesome-free-regular';

export default {
    props: ['item'],

    components: {
        FontAwesomeIcon
    },

    computed: {
        iconEdit() {
            return faEdit;
        },

        iconTrash() {
            return faTrash;
        },

        iconOrder() {
            return faEllipsisV;
        },

        iconUnchecked() {
            return faSquare;
        },

        iconChecked() {
            return faCheckSquare;
        }
    },

    methods: {

        toggleStatus(task) {
            task.finished = !task.finished;

            axios.patch('/tasks/updateFinished/' + task.id, {
                finished: task.finished
            });

        },

        /**
         * Deletes a task from database and the grouped task object
         */
        deleteTask(task) {
            if (!confirm('Wirklich löschen?')) {
                return;
            }

            axios.delete('/tasks/' + task.id)
                .then(() => this.$emit('deleted', task));
        },

        taskClass(item) {
            let classes = item.finished ? 'finished' : 'unfinished';

            const parsedDate = moment(item.day, 'YYYY-MM-DD').startOf('day');

            if (parsedDate < moment().startOf('day') && !item.finished) {
                classes += ' bg-warning';
            }

            return classes;
        }

    }
}
</script>

<style lang="scss" scoped>
    .task {
        padding: 0.5rem;

        &.finished {
            background: #ddd;
        }

        .description {
            user-select: none;
        }
    }
</style>

