export default {
    data() {
        return {
            groupedTasks: {}
        }
    },

    methods: {
        add(task) {
            if (typeof this.groupedTasks[task.day] === 'undefined') {
                Vue.set(this.groupedTasks, task.day, [task]);
                return;
            }

            this.groupedTasks[task.day].push(task);
        },

        remove(task) {
            for (let index in this.groupedTasks[task.day]) {
                if (this.groupedTasks[task.day][index].id === task.id) {
                    this.groupedTasks[task.day].splice(index, 1);
                }
            }
        },

        move(task) {
            this.remove(task);
            this.$emit('removed', task);
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