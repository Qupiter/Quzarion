<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'

// Get tenant from Inertia props
const tenant = usePage().props.tenant
const user = usePage().props.auth.user
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        You're logged in!
                        <br />
                        <span class="text-sm text-gray-500">
                            Tenant: <strong>{{ user?.name }}</strong>
                        </span>
                        <br />
                        <span class="text-sm text-gray-500">
                            Plan: <strong>{{ user?.email ?? 'N/A' }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
