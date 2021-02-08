<template>
    <app-layout>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
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
