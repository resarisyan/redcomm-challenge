<template>
  <div class="dark:bg-gray-800 bg-white rounded-lg shadow-lg p-4">
    <div class="flex justify-between items-center">
      <h2 class="text-xl font-semibold dark:text-white">{{ note.title }}</h2>
      <div class="flex space-x-2">
        <UIcon
          name="i-mdi-pencil"
          dynamic
          class="dark:text-white cursor-pointer"
          @click="$emit('edit', note)"
        />
        <UIcon
          name="i-mdi-delete"
          dynamic
          class="dark:text-white cursor-pointer"
          @click="$emit('delete', note.id)"
        />
      </div>
    </div>
    <p class="text-gray-600 dark:text-gray-400">{{ note.desc }}</p>
  </div>
</template>

<script lang="ts" setup>
import type { NoteType } from '~/utils/types/noteType';
defineProps<{
  note: NoteType;
}>();
</script>

<style></style>
