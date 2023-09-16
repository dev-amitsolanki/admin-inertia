<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Multiselect from '@vueform/multiselect'

const props  = defineProps({
    users:{
        type:Array
    },
    payout:{
        type:Object
    },
    invoices:{
        type:Array
    }
});
const name = ref(null);
const invoice_id = ref(null);
const commission_percentage = ref(null);
const currency = ref(null);
const stripe_link = ref(null);
const email = ref(null);
const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const form = useForm({
    commission_percentage: props.payout.commission_percentage,
    invoice_id: props.payout.invoice_ids,
    currency: props.payout.currency,
    stripe_link: props.payout.stripe_link,
    user_id: props.payout.user_id,
    paid: props.payout.paid,
});
const submitForm = () => {
    form.put(route('payouts.update',props.payout), {
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
            <h2 class="font-semibold text-xl text-indigo-600 leading-tight mb-5">Update Payout</h2>
            <div class="container">
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <InputLabel for="user" value="User" class="mb-2" />
                                <select class="border-gray-300 focus:border-indigo-500 w-full focus:ring-indigo-500 rounded-md text-sm" id="user" v-model="form.user_id" >
                                    <option v-for="(user,index) in props.users" :key="index" :value="user.id">{{user.name}}</option>
                                </select>
                                <InputError :message="form.errors.user_id" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="invoice" value="Invoice" class="mb-2" />
                                <Multiselect v-model="form.invoice_id" :options="invoices" mode="tags" :disabled="true"></Multiselect>
                                <InputError :message="form.errors.invoice_id" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="commission_percentage" value="Commission Percentage" class="mb-2" />
                                <TextInput
                                    id="commission_percentage"
                                    ref="commission_percentage"
                                    v-model="form.commission_percentage"
                                    type="number"
                                    min="0"
                                    class="w-full text-sm"
                                />
                                <InputError :message="form.errors.commission_percentage" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="currency" value="Currency" class="mb-2" />
                                <select class="border-gray-300 focus:border-indigo-500 w-full focus:ring-indigo-500 rounded-md text-sm" id="currency" v-model="form.currency">
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
                </div>
            </div>
        </template>

    </AuthenticatedLayout>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>
