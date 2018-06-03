<template>
    <div>
        <task-list :todo="todo"></task-list>
        <hr>
        <h3>Archiv</h3>
        <task-archive :archived="archived"></task-archive>
    </div>
</template>

<script>
    import TaskList from './TaskList';
    import TaskArchive from './TaskArchive';

    export default {
        props: ['todo', 'archived'],

        components: {
            TaskList, TaskArchive
        }
    }
</script>