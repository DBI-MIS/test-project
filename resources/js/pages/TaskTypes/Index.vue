<script setup lang="ts">
import TaskTypeController from '@/actions/App/Http/Controllers/TaskTypeController';
import TaskController from '@/actions/App/Http/Controllers/TaskController';
import AppLayout from '@/layouts/AppLayout.vue';
import DivContainer from '@/components/DivContainer.vue';
import { BreadcrumbItem } from '@/types';
import { Link, router } from '@inertiajs/vue3';

interface TaskType {
    id: number;
    type: string;
    description: string | null;
}

interface Props {
    types: TaskType[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Task Types',
        href: TaskTypeController.index(),
    }
];

function deleteType(id: number) {
    if (confirm("Are you sure?")) {
        router.delete(TaskTypeController.destroy(id));
    }
}
</script>

<template>
    <AppLayout :breadcrumbs>

        <div class="pt-10 pb-10">

            <!-- Header -->
            <DivContainer :title="'Task Types'">

                <Link 
                    :href="TaskController.index()" 
                    class="border border-gray-400 rounded px-3 py-2 hover:bg-gray-800 inline-block"
                >
                    Back
                </Link>

                <Link 
                    :href="TaskTypeController.create()" 
                    class="border border-gray-400 rounded px-3 py-2 hover:bg-gray-800 inline-block ml-2"
                >
                    Create New Type
                </Link>

            </DivContainer>

            <!-- GRID -->
            <ul class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

                <li v-for="type in props.types" :key="type.id">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition duration-200 p-5 border border-gray-200 dark:border-gray-700 h-full">

                        <!-- Type Name -->
                        <div class="text-lg font-semibold mb-2">
                            {{ type.type }}
                        </div>

                        <!-- Description -->
                        <div class="text-sm text-gray-500 mb-4">
                            {{ type.description || 'No description provided.' }}
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <Link 
                                :href="TaskTypeController.edit(type.id)"
                                class="border border-gray-400 rounded px-3 py-1 text-sm hover:bg-gray-500"
                            >
                                Edit
                            </Link>

                            <button 
                                @click="deleteType(type.id)"
                                class="border border-red-400 rounded px-3 py-1 text-sm hover:bg-red-800"
                            >
                                Delete
                            </button>
                        </div>

                    </div>
                </li>

            </ul>

        </div>

    </AppLayout>
</template>