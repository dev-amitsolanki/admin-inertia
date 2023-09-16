<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const confirmingInvoiceDeletion = ref(false);

const form = useForm({});
const data = defineProps({
    invoice:{
        Object
    }
})

const confirmUserDeletion = () => {
    confirmingInvoiceDeletion.value = true;

};

const deleteInvoice = () => {
    form.delete(route('invoices.destroy',data.invoice), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {},
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingInvoiceDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <DangerButton @click="confirmUserDeletion"  class="bg-transparent hover:bg-transparent focus:bg-transparent">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="rgb(185 28 28)" d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
        </DangerButton>

        <Modal :show="confirmingInvoiceDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete your account?
                </h2>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteInvoice"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
