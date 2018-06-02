<template>
    <div id="task-list">
        <div v-for="(tasks, day) in groupedTasks">
            <strong>{{ day }}</strong>
            <draggable :list="tasks" :options="{group: 'undone'}" @change="update">
                <div v-for="task in tasks" class="card mb-1">
                    <div class="card-body">{{ task.description }}</div>
                </div>
            </draggable>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable';

export default {
    props: ['taskDays'],

    data() {
        return {
            groupedTasks: this.taskDays
        };
    },

    components: {
        draggable
    },

    methods: {

        update() {
            console.log(this.groupedTasks);

            this.updateIndices();

            axios.patch('/tasks/updateOrder', {
                tasks: this.groupedTasks
            })
        },

        updateIndices() {

            let newIndex = 1;

            for (let key in this.groupedTasks) {

                if (!this.groupedTasks.hasOwnProperty(key) || !Array.isArray(this.groupedTasks[key])) {
                    return;
                }

                for (let task in this.groupedTasks[key]) {
                    this.groupedTasks[key][task].day = key;
                    this.groupedTasks[key][task].order = newIndex++;
                }

            }

        }
    },
}
</script>
