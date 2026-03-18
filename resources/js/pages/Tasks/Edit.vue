<script setup lang="ts">
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import DivContainer from '@/components/DivContainer.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, User } from '@/types';
import { router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

export interface Task {
    id: number;
    name: string;
    description: string |null;
    number: number | null;
    task_type_id: number | null;
    type: TaskType | null;
    users: User[];
    creator: User;

}

export interface TaskType {
    id: number;
    type: string;
    description: string |null;
}

interface Props {
    task: Task;
    types: TaskType[];
    users: Array<{id:number, name:string}>;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: TaskController.index(),
    },
   
    {
        title: `${props.task ? props.task.name : 'Edit'}`,
        href: `/tasks/${props.task?.id}/edit`,
    }
];

const form = ref({
    name: props.task?.name,
    number: props.task?.number,
    description: props.task?.description,
    task_type_id: props.task?.task_type_id || '',
    users: props.task?.users.map((u:any) => u.id)
});

function submit() {
    router.put(`/tasks/${props.task?.id}`, form.value); 
}
</script>



<template>
    <AppLayout :breadcrumbs>

    <div>
        <DivContainer :title="`Edit ${props.task?.name}`"/>

        <div class="max-w-md mx-auto">

            <!-- Name -->
            <div class="mb-4">
                <input 
                    v-model="form.name"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <!-- Number -->
            <div class="mb-4">
                <input 
                    v-model="form.number"
                    type="number"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <!-- Description -->
            <div class="mb-4">
                <textarea 
                    v-model="form.description"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
            </div>

            <!-- Type -->
            <div class="mb-6">
                <select 
                    v-model="form.task_type_id"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option v-for="type in types" :key="type.id" :value="type.id">
                        {{ type.type }}
                    </option>
                </select>
            </div>

            <!-- USERS -->
            <div class="mb-6">
                <label for="users" class="block mb-2 font-semibold">Assign Users</label>

                <div id="users" v-for="user in users" :key="user.id" class="flex items-center gap-2 mb-1">
                    <input type="checkbox" :value="user.id" v-model="form.users" class="cursor-pointer" />
                    <span>{{ user.name }}</span>
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="flex gap-2">
                <Link href="/tasks" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 cursor-pointer">
                    Back
                </Link>

                <button @click="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 cursor-pointer">
                    Update
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