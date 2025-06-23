<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TextLink from '@/Components/TextLink.vue'
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ projects: Object })

const destroy = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(`/projects/${id}`)
    }
}
</script>

<template>
    <Head title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Manage projects
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="text-2xl font-bold mb-4">Projects</h1>

                        <TextLink href="/projects/create" class="inline-block">
                            New Project
                        </TextLink>

                        <table class="w-full mt-4 table-auto border">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left p-2">Name</th>
                                <th class="text-left p-2">Status</th>
                                <th class="text-left p-2">Priority</th>
                                <th class="text-left p-2">Deadline</th>
                                <th class="text-left p-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="project in projects.data" :key="project.id" class="border-t">
                                <td class="p-2">{{ project.name }}</td>
                                <td class="p-2 capitalize">{{ project.status }}</td>
                                <td class="p-2 capitalize">{{ project.priority }}</td>
                                <td class="p-2">{{ project.deadline || '-' }}</td>
                                <td class="p-2 space-x-2">
                                    <Link :href="`/projects/${project.id}/edit`" class="text-blue-500">Edit</Link>
                                    <button @click="destroy(project.id)" class="text-red-600">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
