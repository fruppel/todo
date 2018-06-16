<template>
    <div>
        <task-list :todo="todo" ref="taskList" @removed="onRemoved($event)"></task-list>
        <hr>
        <h3>Archiv</h3>
        <task-archive :archived="archived" ref="taskArchive" @removed="onRemoved($event)"></task-archive>
    </div>
</template>

<script>
    import TaskList from './TaskList';
    import TaskArchive from './TaskArchive';

    export default {
        props: ['todo', 'archived'],

        components: {
            'task-list': TaskList,
            'task-archive': TaskArchive
        },

        methods: {

            onRemoved(task) {
                if (task.finished) {
                    this.$refs.taskArchive.add(task);
                    flash('Aufgabe erledigt');
                    return;
                }

                this.$refs.taskList.add(task);
                flash('Aufgabe wiederhergestellt');
            }
        }
    }
</script>