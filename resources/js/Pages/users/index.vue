<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Pagination from '@/Components/Pagination.vue'
    import { Link } from '@inertiajs/vue3'

    import { Head } from '@inertiajs/vue3';
    defineProps({
        users:{
            Object
        }
    })
</script>
<template>
    <Head title="User List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-indigo-600 leading-tight mb-5">User List</h2>
            <layout title="Users">
                <div class="container">
                    <table class="table border w-full text-sm">
                        <thead class="bg-indigo-100">
                        <tr class="text-left">
                            <th class="border p-3">ID</th>
                            <th class="border p-3">Name</th>
                            <th class="border p-3">Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td class="border p-3">{{ user.id }}</td>
                            <td class="border p-3">{{ user.name }}</td>
                            <td class="border p-3">{{ user.email }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <Pagination class="mt-6" :links="users.links" />
                </div>
            </layout>
        </template>
    </AuthenticatedLayout>
</template>

