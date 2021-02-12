<template>
    <div class="task flex items-center border border-gray-200 rounded" :class="taskClass(item)" >
        <div class="flex items-center pr-1" @click="toggleStatus(item)">
            <div class="drag-handle p-1 pr-3" v-if="!item.finished">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                </svg>
            </div>
            <span class="w-5 h-5 border border-gray-900 mr-3">
                <svg v-if="item.finished" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </span>
            <div class="description" :class="item.finished ? 'finished' : ''">
                {{ item.description }}
            </div>
        </div>
        <div class="buttons ml-auto text-nowrap flex">
            <a class="text-blue-400" @click="edit(item)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 mr-1 p-1 box-content">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
            <button class="text-red-400" @click="deleteTask(item)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 p-1 box-content">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['item'],

    methods: {

        toggleStatus(task) {
            task.finished = !task.finished;

            axios.patch('/tasks/updateFinished/' + task.id, {
                finished: task.finished
            }).then(() => {
                this.$emit('statusToggled', task);
            }).catch(error => {
                flash(error + ' ' + error.response.data.message, 'error');
            });
        },

        deleteTask(task) {
            if (!confirm('Wirklich löschen?')) {
                return;
            }

            axios.delete('/tasks/' + task.id)
                .then(() => {
                    this.$emit('deleted', task);
                    flash('Todo gelöscht');
                });
        },

        edit(task) {
            this.$inertia.get(route('tasks.edit', task.id));
        },

        taskClass(item) {
            let classes = item.finished ? 'finished' : 'unfinished';

            const parsedDate = moment(item.day, 'YYYY-MM-DD').startOf('day');

            if (parsedDate < moment().startOf('day') && !item.finished) {
                classes += ' bg-yellow-200';
            } else {
                classes += ' bg-white';
            }

            return classes;
        }

    }
}
</script>

<style scoped>
    .task {
        padding: 0.5rem;
    }

    .task.finished {
        background: #ddd;
    }

    .task .description {
        user-select: none;
    }
</style>

