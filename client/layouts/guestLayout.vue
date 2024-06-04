<template>
  <Navbar @search="onSearch" />
  <main>
    <slot />
  </main>
  <Footer />
</template>

<script lang="ts" setup>
import { useNotesStore } from '~/stores/notes';
const notesStore = useNotesStore();
const onSearch = (searchTerm: string) => {
  notesStore.setSearchQuery(searchTerm);
};
</script>
