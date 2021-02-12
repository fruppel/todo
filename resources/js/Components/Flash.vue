<template>
    <div class="alert fixed right-5 bottom-4 p-3"
         :class="classes"
         role="alert"
         v-text="body">
    </div>
</template>

<script>
export default {
    props: ['message'],

    data() {
        return {
            body: this.message,
            level: 'success',
            show: false
        }
    },

    computed: {
        classes() {
            return [
                this.show ? 'visible' : 'hidden',
                this.level === 'success' ? 'bg-green-300' : 'bg-red-300'
            ];
        }
    },

    created() {
        if (this.message) {
            this.flash();
        }

        window.events.$on('flash', data => {
            this.flash(data);
        });
    },

    methods: {
        flash(data) {
            if (data) {
                this.body = data.message;
                this.level = data.level;
            }

            this.show = true;

            this.hide();
        },

        hide() {
            window.setTimeout(() => {
                this.show = false;
            }, 3000);
        },
    }
}
</script>
