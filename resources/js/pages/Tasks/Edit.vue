<script setup>
import { router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    task: Object 
});

const form = ref({
    name: props.task.name,
    number: props.task.number,
    description: props.task.description
});

function submit() {
    router.put(`/tasks/${props.task.id}`, form.value); 
}
</script>

<style scoped>
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}
</style>

<template>
    <div>
        <div class="text-center mb-8 pt-2">
            <h1 class="text-3xl mb-4">Edit Task</h1> <!-- ✅ FIXED -->
        </div>

        <div class="max-w-md mx-auto">
            <div class="mb-4">
                <input 
                    v-model="form.name" 
                    class="w-full border border-gray-400 rounded px-3 py-2" 
                />
            </div>

            <div class="mb-4">
                <input 
                    v-model="form.number" 
                    type="number" 
                    class="w-full border border-gray-400 rounded px-3 py-2" 
                />
            </div>

            <div class="mb-6">
                <textarea 
                    v-model="form.description" 
                    class="w-full border border-gray-400 rounded px-3 py-2"
                ></textarea>
            </div>

            <div class="space-x-2">
                <Link 
                    href="/tasks" 
                    class="border border-gray-400 rounded px-3 py-2 hover:bg-gray-100 inline-block"
                >
                    Back
                </Link>

                <button 
                    @click="submit" 
                    class="border border-gray-400 rounded px-3 py-2 hover:bg-gray-100"
                >
                    Update
                </button>
            </div>
        </div>
    </div>
</template>