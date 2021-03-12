<template>
    <strong>{{ formattedDay }}</strong>
</template>

<script>
import {format, parse} from 'date-fns';

export default {
    props: ['day'],

    computed: {
        formattedDay() {
            if (this.day === '') {
                return 'Irgendwann';
            }

            return format(
                parse(this.day, 'yyyy-MM-dd', new Date()),
                'dd.MM.yyyy'
            );
        }
    }
}
</script>
