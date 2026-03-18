<script setup lang="ts">
import TaskTypeController from '@/actions/App/Http/Controllers/TaskTypeController';
import AppLayout from '@/layouts/AppLayout.vue';
import DivContainer from '@/components/DivContainer.vue';
import { BreadcrumbItem } from '@/types';
import { router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

interface TaskType {
    id: number;
    type: string;
    description: string | null;
}

interface Props {
    type: TaskType;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Task Types',
        href: TaskTypeController.index(),
    },
    {
        title: `Edit ${props.type.type}`,
        href: TaskTypeController.edit(props.type.id),
    }
];

const form = ref({
    type: props.type.type,
    description: props.type.description || '' as string | null
});

function submit() {
    router.put(TaskTypeController.update(props.type.id), form.value);
}
</script>

<template>
    <AppLayout :breadcrumbs>

        <div>
            <DivContainer :title="`Edit ${props.type.type}`"/>

            <div class="max-w-md mx-auto">

                <!-- Type -->
                <div class="mb-4">
                    <input 
                        v-model="form.type"
                        class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <textarea 
                        v-model="form.description"
                        class="w-full bg-gray-800 text-white border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2">
                    <Link 
                        :href="TaskTypeController.index()" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 cursor-pointer"
                    >
                        Back
                    </Link>

                    <button 
                        @click="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 cursor-pointer"
                    >
                        Update
                    </button>
                </div>

            </div>
        </div>
        
    </AppLayout>
</template>