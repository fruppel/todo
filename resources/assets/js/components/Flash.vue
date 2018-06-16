<template>
    <div class="alert alert-flash"
         :class="[show ? 'visible' : 'hidden', 'alert-' + level]"
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
            }
        }
    }
</script>

<style scoped>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }

    .visible {
        visibility: visible;
        opacity: 1;
        transition: opacity .1s linear;
    }

    .hidden {
        visibility: hidden;
        opacity: 0;
        transition: visibility 0s .5s, opacity .5s linear;
    }
</style>