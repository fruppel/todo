<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Archiv
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 px-2 lg:px-8">
            <task-archive :archived="archived" ref="taskArchive" @removed="onRemoved($event)"></task-archive>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import TaskArchive from '@/Components/TaskArchive';

export default {
    components: {
        AppLayout,
        TaskArchive
    },

    props: ['archived']
}
</script>
