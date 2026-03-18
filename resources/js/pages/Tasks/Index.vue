<script setup lang="ts">

import TaskController from '@/actions/App/Http/Controllers/TaskController';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { BreadcrumbItem } from '@/types';

import { Link, router } from '@inertiajs/vue3';
import { Task, TaskType } from './Edit.vue';
import { computed, ref } from 'vue';
import DivContainer from '@/components/DivContainer.vue';
import TaskTypeController from '@/actions/App/Http/Controllers/TaskTypeController';
import AssignedUsers from './AssignedUsers.vue';
import Pagination from '@/components/Pagination.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: TaskController.index(),
    }
];

const props = defineProps({
    tasks: Array as () =>    Task[],
    taskTypes: Array as () => TaskType[],
});

function deleteTask(id:number) {
    if (confirm("Are you sure?")) {
        router.delete(`/tasks/${id}`);
    }
}

const search = ref('');
const perPage = ref(4);
const currentPage = ref(1);

function handlePageChange() {
    currentPage.value = 1; // reset to first page
    Query();
}

function Query() {
    router.get(
        TaskController.index(),
        { 
            per_page: perPage.value, 
            search: search.value,
            page: currentPage.value
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}



// const taskTypeOptions = computed(() => {
//     ...props
// })
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

    <div class = "pt-10 pb-10">
        <!-- Header -->

        <DivContainer :title="'Tasks'">
        


            <Link :href="TaskController.create()" class="border border-gray-400 rounded px-3 py-2 hover:bg-gray-800 inline-block">
                Create New
            </Link>
            <Link :href="TaskTypeController.index()" class="border border-gray-400 rounded px-3 py-2 hover:bg-gray-800 inline-block ml-2">
                Task Types
            </Link>
            
            <input
                v-model="search"
                @input="Query()"
                placeholder="Search..."
                class="ml-4 px-3 py-2 border rounded dark:bg-gray-800"/>

            <div class="flex justify-end max-w-5xl mx-auto mb-4">
                <select
                    v-model="perPage"
                    @change="handlePageChange"
                    class="border rounded px-3 py-2 dark:bg-gray-800"
                >
                    <option :value="4">4</option>
                    <option :value="8">8</option>
                    <option :value="12">12</option>
                    <option :value="16">16</option>
                </select>
            </div>
        </DivContainer>

        <!-- GRID CONTAINER -->
        <ul class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

            <li 
                v-for="(task, index) in props.tasks.data" 
                :key="task.id"
            >
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-lg hover:-translate-y-1 transition duration-200 p-5 border border-gray-200 dark:border-gray-700 h-full">

                    <!-- Name -->
                    <div class="text-lg font-semibold mb-1">
                        {{ task.name }}
                    </div>

                    <!-- Number -->
                    <div class="text-sm text-gray-500 mb-1">
                        Number: {{ task.number }}
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        {{ task.description }}
                    </div>

                 

               
                    <AssignedUsers v-if="task.users.length" :task />
                  

                    <!-- Type -->
                    <div v-if="task.type" class="mb-3">
                        <span class="text-xs px-2 py-1 rounded bg-gray-200 dark:bg-gray-700">
                            {{ task.type.type }}
                        </span>
                    </div>

                    <!-- Related Tasks -->
                    <div v-if="task.type?.type?.length" class="mb-3">
                        <div class="text-xs text-gray-500 mb-1">
                            Related tasks:
                        </div>

                        <ul class="ml-4 list-disc text-sm">
                            <li 
                                v-for="t in props.taskTypes?.filter((t:TaskType) => t.id !== task.id)" 
                                :key="t.id"
                            >
                                {{ t.type }}
                            </li>
                        </ul>
                    </div>

                    <!-- Creator -->
                    <div class="text-xs text-gray-500 mb-3" v-if="task.creator">
                        Created by: {{ task.creator.name }} ({{ task.creator.email }})
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <Link 
                            :href="TaskController.edit(task.id)" 
                            class="border border-gray-400 rounded px-3 py-1 text-sm hover:bg-gray-500"
                        >
                            Edit
                        </Link>

                        <button 
                            @click="deleteTask(task.id)" 
                            class="border border-red-400 rounded px-3 py-1 text-sm hover:bg-red-800"
                        >
                            Delete
                        </button>
                    </div>

                </div>
            </li>

        </ul>
        <Pagination :links="props.tasks.links" />

    </div>

    </AppLayout>
</template>