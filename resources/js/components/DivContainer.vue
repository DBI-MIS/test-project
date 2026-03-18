<script setup lang="ts">
const props = defineProps({
    title: {
        type: String,
        default: 'Title',
        required: true,
    }
});
</script>

<template>
    <div class="max-w-5xl mx-auto mb-8">

        <div class="rounded-2xl shadow-md border border-gray-200 dark:border-gray-700 
                    bg-white dark:bg-gray-800 p-6">

            <!-- Title -->
            <h1 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white text-center">
                {{ title }}
            </h1>

            <!-- Slot (buttons / actions) -->
            <div class="flex justify-center gap-2 flex-wrap">
                <slot />
            </div>

        </div>

    </div>
</template>