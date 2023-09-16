<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap mt-8 justify-end">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />

                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                    :class="{ 'bg-indigo-600 hover:bg-indigo-800 text-white': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<script setup>
// import { defineComponent } from "vue";
import { Link } from "@inertiajs/vue3";
    defineProps({
        links:{
            Array
        }
    })
</script>