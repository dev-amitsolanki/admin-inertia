<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Pagination from '@/Components/Pagination.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import DeleteInvoiceForm from './Partials/DeleteInvoiceForm.vue';
    import { Head,Link } from '@inertiajs/vue3'
    // import { Head } from '@inertiajs/vue3';
    defineProps({
        invoices:{
            Object
        }
    })
</script>
<template>
    <Head title="Payout List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-indigo-600 leading-tight mb-5">Invoice List
                <!-- <PrimaryButton >Save</PrimaryButton> -->
                <Link class="float-right px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-800 " :href="route('invoices.create')" >Add Invoice</Link>
            </h2>

            <layout title="Users">
                <div class="container">
                    <table class="table border w-full text-sm">
                        <thead class="bg-indigo-100">
                            <tr class="">
                                <th class="border p-3">ID</th>
                                <th class="border p-3">User Email</th>
                                <th class="border p-3 text-center">Amount</th>
                                <th class="border p-3 text-center">Tax</th>
                                <th class="border p-3 text-center">Total</th>
                                <th class="border p-3 text-center">Paid</th>
                                <th class="border p-3 text-center">Stripe Link</th>
                                <th class="border p-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="invoice in invoices.data" :key="invoice.id">
                                <td class="border p-3">{{ invoice.id }}</td>
                                <td class="border p-3">{{ invoice.user.email }}</td>
                                <td class="border p-3 text-center">{{ invoice.amount_cents }}</td>
                                <td class="border p-3 text-center">{{ invoice.tax_percentage }}</td>
                                <td class="border p-3 text-center">{{ invoice.amount_cents * invoice.tax_percentage / 100 }}</td>
                                <td class="border p-3 text-center">{{ invoice.paid == 1 ? 'Paid' : 'Pending'  }}</td>
                                <td class="border p-3 text-center">
                                    <a class="flex items-center justify-center text-green-600" target="_blank" :href="invoice.stripe_link">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="mr-2"><path fill="rgb(22 163 74)" d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                                        Payment
                                    </a>
                                </td>
                                <td class="border p-3 flex items-center justify-center">                                    
                                    <PrimaryButton class="bg-transparent hover:bg-transparent focus:bg-transparent">
                                        <Link :href="route('invoices.edit',invoice.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="rgb(22 163 74)" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </Link> 
                                    </PrimaryButton>
                                    <DeleteInvoiceForm :invoice="invoice"></DeleteInvoiceForm>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination class="mt-6" :links="invoices.links" />
                </div>
            </layout>
        </template>
    </AuthenticatedLayout>
</template>

