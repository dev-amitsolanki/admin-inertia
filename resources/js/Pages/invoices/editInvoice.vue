<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users:{
        type:Array
    },
    payouts:{
        type:Array
    },
    invoice:{
        type:Object
    }
});
const user_id = ref(null);
const amount_cents = ref(null);
const tax_type = ref(null);
const tax_percentage = ref(null);
const currency = ref(null);
const stripe_link = ref(null);
const paid = ref(null);
const form = useForm({
    user_id: props.invoice.user_id,
    amount_cents: props.invoice.amount_cents,
    tax_type: props.invoice.tax_type,
    tax_percentage: props.invoice.tax_percentage,
    currency: props.invoice.currency,
    stripe_link: props.invoice.stripe_link,
    paid: props.invoice.paid,
});
const submitForm = () => {
    form.put(route('invoices.update',props.invoice), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {},
    });
};
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-indigo-600 leading-tight mb-5">Update Invoice</h2>

            <div class="container">
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitForm">
                        <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                            <p v-if="form.recentlySuccessful" class="text-sm bg-green-200 px-4 rounded-md  py-2 text-green-900">Invoice Updated Successfully.</p>
                        </Transition>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <InputLabel for="user" value="User" class="mb-2" />
                                <select class="border-gray-300 focus:border-indigo-500 w-full focus:ring-indigo-500 rounded-md text-sm" id="user" v-model="form.user_id" >
                                    <option v-for="(user,index) in props.users" :key="index" :value="user.id">{{user.name}}</option>
                                </select>
                                <InputError :message="form.errors.user_id" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="amount_cents" value="Amount" class="mb-2" />
                                <TextInput
                                    id="amount_cents"
                                    ref="amount_cents"
                                    v-model="form.amount_cents"
                                    type="number"
                                    min="0"
                                    class="w-full text-sm"
                                />
                                <InputError :message="form.errors.amount_cents" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="tax_type" value="TAX" class="mb-2" />
                                <TextInput
                                    id="tax_type"
                                    ref="tax_type"
                                    v-model="form.tax_type "
                                    type="text"
                                    placeholder="GST"
                                    class="w-full text-sm"
                                />
                                <InputError :message="form.errors.tax_type " class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="tax_percentage" value="TAX Percentage" class="mb-2" />
                                <TextInput
                                    id="tax_percentage"
                                    ref="tax_percentage"
                                    v-model="form.tax_percentage"
                                    type="number"
                                    min="0"
                                    class="w-full text-sm"
                                    step="0.01"
                                />
                                <InputError :message="form.errors.tax_percentage" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="currency" value="Currency" class="mb-2" />
                                <select class="border-gray-300 focus:border-indigo-500 w-full focus:ring-indigo-500 rounded-md text-sm" id="currency" v-model="form.currency" >
                                    <option value="AUD">AUD</option>
                                    <option value="USD">USD</option>
                                </select>
                                <InputError :message="form.errors.currency" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="stripe_link" value="Stripe Link" class="mb-2" />
                                <TextInput
                                    id="stripe_link"
                                    ref="stripe_link"
                                    v-model="form.stripe_link"
                                    type="text"
                                    class="w-full text-sm"
                                />
                                <InputError :message="form.errors.stripe_link" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="paid" value="Paid" class="mb-2" />
                                <select class="border-gray-300 focus:border-indigo-500 w-full focus:ring-indigo-500 rounded-md text-sm" id="paid" v-model="form.paid" >
                                    <option value="0">Pending</option>
                                    <option value="1">Paid</option>
                                </select>
                                <InputError :message="form.errors.paid" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing" class="border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-800 mt-3 px-4">Save</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
