<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-indigo-600 leading-tight mb-5">Profile</h2>
            <div class="container">
                <div class="p-6 bg-white shadow sm:rounded-lg mb-4">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-6 bg-white shadow sm:rounded-lg mb-4">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-6 bg-white shadow sm:rounded-lg mb-4">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
