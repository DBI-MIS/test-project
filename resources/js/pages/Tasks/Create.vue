<script setup lang="ts">
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import DivContainer from '@/components/DivContainer.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, User } from '@/types';
import { router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { TaskType } from './Edit.vue';

interface Props {
    types: TaskType[];
    users: User[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: TaskController.index(),
    },
    {
        title: 'Create Task',
        href: TaskController.create(),
    }
];

const form = ref({
    name: '',
    number: null as number | null,
    description: '',
    task_type_id: '' as number | '',
    users: [] as number[]
});

function submit() {
    router.post('/tasks', form.value); 
}
</script>

<template>
    <AppLayout :breadcrumbs>

        <div>
            <DivContainer :title="'Create Task'"/>

            <div class="max-w-md mx-auto">

                <!-- Name -->
                <div class="mb-4">
                    <input 
                        v-model="form.name"
                        placeholder="Name"
                        class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <!-- Number -->
                <div class="mb-4">
                    <input 
                        v-model="form.number"
                        placeholder="Number"
                        type="number"
                        class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <textarea 
                        v-model="form.description"
                        placeholder="Description"
                        class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ></textarea>
                </div>

                <!-- Type -->
                <div class="mb-6">
                    <select 
                        v-model="form.task_type_id"
                        class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option disabled value="">Select Type</option>
                        <option v-for="type in props.types" :key="type.id" :value="type.id">
                            {{ type.type }}
                        </option>
                    </select>
                </div>

                <!-- USERS -->
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Assign Users</label>

                    <div v-for="user in props.users" :key="user.id" class="flex items-center gap-2 mb-1">
                        <input 
                            type="checkbox" 
                            :value="user.id" 
                            v-model="form.users" 
                            class="cursor-pointer" 
                        />
                        <span>{{ user.name }}</span>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="flex gap-2">
                    <Link 
                        :href="TaskController.index()" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 cursor-pointer"
                    >
                        Back
                    </Link>

                    <button 
                        @click="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 cursor-pointer"
                    >
                        Save
                    </button>
                </div>

            </div>
        </div>
        
    </AppLayout>
</template>

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