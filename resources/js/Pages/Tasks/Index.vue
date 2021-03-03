<template>
    <app-layout>
        <template #header class="header">
            <h2 class="header">Offene Aufgaben</h2>
        </template>
        <div class="content">
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
