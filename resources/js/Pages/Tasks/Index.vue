<template>
    <app-layout>
        <div class="max-w-7xl mx-auto py-10 px-2 lg:px-8">
            <task-list :todo="todo" ref="taskList" @removed="onRemoved($event)"></task-list>
            <hr class="mt-2 mb-1">
            <h3 class="text-lg">Archiv</h3>
            <task-archive :archived="archived" ref="taskArchive" @removed="onRemoved($event)"></task-archive>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import TaskList from '@/Components/TaskList';
import TaskArchive from '@/Components/TaskArchive';
import JetButton from '@/Jetstream/Button';

export default {
    components: {
        AppLayout,
        JetButton,
        TaskList,
        TaskArchive
    },

    props: ['todo', 'archived'],

    methods: {
        onRemoved(task) {
            if (task.finished) {
                this.$refs.taskArchive.add(task);
                flash('Todo erledigt');
                return;
            }

            this.$refs.taskList.add(task);
            flash('Todo wiederhergestellt');
        }
    }
}
</script>
