<script setup lang="ts">
import { Task } from './Edit.vue';

interface Props {
    task: Task;
}

const props = defineProps<Props>();

</script>
<template>
    <div>
        <span class="text-xs text-gray-400">Assigned:</span>

        <div class="text-sm">
            <span v-for="user in task.users" :key="user.id" class="mr-2">
                {{ user.name }}
            </span>
        </div>

    </div>
</template>