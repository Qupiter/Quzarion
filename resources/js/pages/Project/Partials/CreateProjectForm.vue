<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    description: '',
    status: 'pending',
    priority: 'medium',
    deadline: '',
    started_at: '',
    completed_at: '',
    assigned_to: '',
})

const submit = () => {
    form.post('/projects')
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                New Project
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Create a new project and assign its details.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">

            <!-- Name -->
            <div>
                <InputLabel for="name" value="Name" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Description -->
            <div>
                <InputLabel for="description" value="Description" />
                <textarea id="description" v-model="form.description" class="mt-1 block w-full rounded border-gray-300" rows="3" />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <!-- Status -->
            <div>
                <InputLabel for="status" value="Status" />
                <select id="status" v-model="form.status" class="mt-1 block w-full rounded border-gray-300">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="on_hold">On Hold</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <InputError class="mt-2" :message="form.errors.status" />
            </div>

            <!-- Priority -->
            <div>
                <InputLabel for="priority" value="Priority" />
                <select id="priority" v-model="form.priority" class="mt-1 block w-full rounded border-gray-300">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="critical">Critical</option>
                </select>
                <InputError class="mt-2" :message="form.errors.priority" />
            </div>

            <!-- Deadline -->
            <div>
                <InputLabel for="deadline" value="Deadline" />
                <TextInput id="deadline" type="date" class="mt-1 block w-full" v-model="form.deadline" />
                <InputError class="mt-2" :message="form.errors.deadline" />
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Create</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
