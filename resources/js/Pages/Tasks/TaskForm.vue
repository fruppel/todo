<template>
    <div>
        <jet-form-section @submitted="submit">
            <template #title>
                {{ task ? 'Todo bearbeiten' : 'Todo erstellen' }}
            </template>

            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="description" value="Beschreibung" />
                    <jet-input type="text" name="description" v-model="form.description" class="mt-1 block w-full"></jet-input>
                    <jet-input-error :message="form.errors.description" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="day" value="Datum" />
                    <jet-input type="date" id="day" name="day" v-model="form.day"></jet-input>
                    <jet-input-error :message="form.errors.day" class="mt-2" />
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
import JetButton from '@/Jetstream/Button';
import JetFormSection from '@/Jetstream/FormSection';
import JetInput from '@/Jetstream/Input';
import JetInputError from '@/Jetstream/InputError';
import JetLabel from '@/Jetstream/Label';
import JetSecondaryButton from '@/Jetstream/SecondaryButton';

export default {
    components: {
        JetButton,
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
                day: this.task ? this.task.day : this.getTomorrow(),
            }),
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

        getTomorrow() {
            return moment().add(1, 'days').format('YYYY-MM-DD');
        }
    }
}
</script>
