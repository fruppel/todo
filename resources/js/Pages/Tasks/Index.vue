<template>
    <app-layout>
        <div class="max-w-7xl mx-auto py-10 px-2 lg:px-8">
            <task-list :todo="todo" ref="taskList"></task-list>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import TaskList from '@/Components/TaskList';
import JetButton from '@/Jetstream/Button';

export default {
    components: {
        AppLayout,
        JetButton,
        TaskList
    },

    props: ['todo'],
}
</script>
