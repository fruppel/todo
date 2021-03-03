<template>
    <app-layout>
        <template #header>
            <h2 class="header">Aufgabe erstellen</h2>
        </template>
        <div class="content">
            <task-form></task-form>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import TaskForm from '@/Pages/Tasks/TaskForm';

export default {
    components: {
        AppLayout,
        TaskForm
    }
}
</script>
