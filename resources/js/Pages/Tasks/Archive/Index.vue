<template>
    <app-layout>
        <template #header>
            <h2 class="header">Archiv</h2>
        </template>

        <div class="content">
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
