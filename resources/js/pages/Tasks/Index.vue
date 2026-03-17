<script setup>
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    tasks: Array
});

function deleteTask(id) {
    if (confirm("Are you sure?")) {
        router.delete(`/tasks/${id}`);
    }
}
</script>

<template>
    <div>
        <div class="text-center mb-8 pt-2">
            <h1 class="text-3xl mb-4">Tasks</h1>

            <Link href="/tasks/create" class="border border-gray-400 rounded px-3 py-2 hover:bg-gray-100 inline-block">
                Create New
            </Link>
        </div>

        <ul>
            <li 
                v-for="(task, index) in tasks" 
                :key="task.id" 
                :class="{ 'border-t': index === 0 }" 
                class="mb-4 pb-4 border-b border-gray-400"
            >
                <div class="mb-2 mx-4 mt-2">Name: {{ task.name }}</div>
                <div class="mb-2 mx-4">Number: {{ task.number }}</div>
                <div class="mb-2 mx-4">Description: {{ task.description }}</div>

                <!-- creator -->
                <div class="mb-2 mx-4 text-sm text-gray-600" v-if="task.creator">
                    Created by: {{ task.creator.name }}
                </div>

                <div class="mb-2 mx-4 text-sm text-gray-600" v-if="task.creator">
                    Email: {{ task.creator.email }}
                </div>

                <div class="space-x-2">
                    <Link 
                        :href="`/tasks/${task.id}/edit`" 
                        class="border border-gray-400 rounded px-3 py-2 hover:bg-gray-100 inline-block mx-4"
                    >
                        Edit
                    </Link>

                    <button 
                        @click="deleteTask(task.id)" 
                        class="border border-red-400 rounded px-3 py-2 hover:bg-red-100"
                    >
                        Delete
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>