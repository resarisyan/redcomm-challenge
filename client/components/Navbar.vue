<template>
  <div
    class="navbar flex justify-between items-center p-4 dark:bg-gray-800 bg-gray-100 shadow-md"
  >
    <div class="text-xl font-bold">My Notes</div>
    <div class="flex items-center gap-4">
      <!-- Input with icon search -->
      <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
          <UIcon name="i-mdi-search" dynamic />
        </div>
        <input
          type="text"
          class="pl-10 pr-4 py-2 rounded-lg w-64 dark:bg-gray-700 bg-gray-200 focus:outline-none focus:ring focus:ring-gray-300"
          placeholder="Search"
          v-model="searchTerm"
          v-on:input="emitSearchEvent"
        />
      </div>
      <ClientOnly>
        <UButton
          :icon="
            isDark ? 'i-heroicons-moon-20-solid' : 'i-heroicons-sun-20-solid'
          "
          color="gray"
          variant="ghost"
          aria-label="Theme"
          @click="isDark = !isDark"
        />
        <template #fallback>
          <div class="w-8 h-8" />
        </template>
      </ClientOnly>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
const searchTerm = ref('');
const emit = defineEmits(['search']);

const emitSearchEvent = () => {
  setTimeout(() => {
    emit('search', searchTerm.value);
  }, 500);
};

const colorMode = useColorMode();
const isDark = computed({
  get() {
    return colorMode.value === 'dark';
  },
  set() {
    colorMode.preference = colorMode.value === 'dark' ? 'light' : 'dark';
  },
});
</script>
