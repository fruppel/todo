export default {
    data() {
        return {
            groupedTasks: {}
        };
    },

    methods: {
        remove(task) {
            for (let index in this.groupedTasks[task.day]) {
                if (this.groupedTasks[task.day][index].id === task.id) {
                    this.groupedTasks[task.day].splice(index, 1);
                }
            }
        },

        /**
         * Recalculates all indizes and updates them
         */
        calculateIndices() {

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

        },
    }
}