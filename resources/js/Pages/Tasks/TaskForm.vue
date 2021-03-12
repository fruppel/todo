<template>
    <div>
        <jet-form-section @submitted="submit">
            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="description" value="Beschreibung" />
                    <jet-input type="text" name="description" v-model="form.description" class="mt-1 block w-full"></jet-input>
                    <jet-input-error :message="form.errors.description" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="day" value="Datum" />
                    <div class="flex items-center">
                        <jet-input type="date" id="day" name="day" v-model="form.day" :disabled="anytime"></jet-input>
                        <div class="ml-2">
                            <jet-checkbox :checked="form.day === null" @change="form.day = null" v-model="anytime"></jet-checkbox> Irgendwann
                        </div>
                    </div>
                    <jet-input-error :message="form.errors.day" class="mt-2" />
                    <div class="flex mt-1">
                        <date-button @click.native="changeDay(0)" :disabled="anytime">Heute</date-button>
                        <date-button @click.native="changeDay(1)" :disabled="anytime">Morgen</date-button>
                        <date-button @click.native="changeDay(2)" :disabled="anytime">Übermorgen</date-button>
                    </div>
                </div>
            </template>
            <template #actions>
                <jet-secondary-button class="mr-2" @click.native.prevent="abort">Abbrechen</jet-secondary-button>
                <jet-button>Speichern</jet-button>
            </template>
        </jet-form-section>
    </div>
</template>

<script>
import DateButton from '@/Components/DateButton';
import JetButton from '@/Jetstream/Button';
import JetCheckbox from '@/Jetstream/Checkbox';
import JetFormSection from '@/Jetstream/FormSection';
import JetInput from '@/Jetstream/Input';
import JetInputError from '@/Jetstream/InputError';
import JetLabel from '@/Jetstream/Label';
import JetSecondaryButton from '@/Jetstream/SecondaryButton';
import {add, format} from 'date-fns';

export default {
    components: {
        DateButton,
        JetButton,
        JetCheckbox,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },

    props: ['task'],

    data() {
        return {
            form: this.$inertia.form({
                description: this.task ? this.task.description : '',
                day: this.task
                    ? this.task.day
                    : format(add(new Date(), {days: 1}), 'yyyy-MM-dd')
            }),
            anytime: this.task && this.task.day === null
        }
    },

    methods: {
        submit() {
            this.task ? this.update() : this.store();
        },

        store() {
            this.form.post(route('tasks.store'), {
                errorBag: 'storeTask',
                preserveScroll: true,
                onSuccess: () => {
                    flash('Todo angelegt')
                }
            });
        },

        update() {
            this.form.patch(route('tasks.update', this.task), {
                errorBag: 'updateTask',
                preserveScroll: true,
                onSuccess: () => {
                    flash('Todo bearbeitet')
                }
            });
        },

        abort() {
            this.$inertia.get(route('tasks.index'));
        },

        changeDay(plusDays) {
            this.form.day = format(
                add(new Date(), {days: plusDays}),
                'yyyy-MM-dd'
            );
        }
    }
}
</script>
