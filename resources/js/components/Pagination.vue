<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
}>();
</script>

<template>
    <div class="flex justify-center mt-8 flex-wrap gap-2">
        <template v-for="(link, index) in links" :key="index">
            
            <!-- Disabled -->
            <span
                v-if="!link.url"
                class="px-3 py-1 text-gray-400 border border-gray-300 rounded"
                v-html="link.label"
            />

            <!-- Active -->
            <span
                v-else-if="link.active"
                class="px-3 py-1 bg-blue-600 text-white rounded border border-blue-600"
                v-html="link.label"
            />

            <!-- Clickable -->
            <Link
                v-else
                :href="link.url"
                class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-700"
                v-html="link.label"
            />
        </template>
    </div>
</template>