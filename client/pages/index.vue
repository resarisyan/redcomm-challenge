<template>
  <div class="h-screen">
    <div
      v-if="notesStore.loading"
      class="fixed left-0 top-0 h-0.5 w-full z-50 bg-green-500"
    ></div>
    <NuxtLayout name="guest-layout">
      <SliderBanner />
      <div class="container mx-auto px-4 py-8">
        <UButton @click="openModal('create')">
          <UIcon name="i-mdi-plus" class="mr-2" dynamic />Create Note
        </UButton>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
          <NoteCard
            v-for="note in notes"
            :key="note.id"
            :note="note"
            @edit="openModal('edit', note)"
            @delete="confirmDelete(note.id as string)"
          />
        </div>
      </div>
    </NuxtLayout>
    <div>
      <ModalSave :title="modalTitle" v-model="showModal">
        <template #modal-content>
          <NoteForm :note="currentNote" @submit="saveNote" />
        </template>
      </ModalSave>
      <ModalConfirmation
        v-model="showConfirmModal"
        title="Delete Note"
        message="Are you sure you want to delete this note?"
        @confirm="deleteNote"
        @cancel="showConfirmModal = false"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useNotesStore } from '~/stores/notes';
import type { NoteType } from '~/utils/types/noteType';

const notesStore = useNotesStore();
const toast = useToast();
const notes = computed(() => notesStore.notes);
const currentNote = ref<NoteType>({ id: '', title: '', desc: '' });
const showModal = ref(false);
const modalTitle = ref('');
const showConfirmModal = ref(false);
const noteToDeleteId = ref<string | null>(null);

const openModal = (
  type: string,
  note: NoteType = { id: '', title: '', desc: '' }
) => {
  if (type === 'edit') {
    modalTitle.value = 'Edit Note';
    currentNote.value = { ...note };
  } else if (type === 'create') {
    modalTitle.value = 'Create Note';
    currentNote.value = { id: '', title: '', desc: '' };
  }
  showModal.value = true;
};

const onScroll = () => {
  const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
  if (
    scrollTop + clientHeight >= scrollHeight - 200 &&
    !notesStore.loading &&
    notesStore.next_page_url
  ) {
    loadMoreNotes();
  }
};

const saveNote = async (note: NoteType) => {
  if (note.id) {
    await notesStore.updateNote(note);
  } else {
    await notesStore.createNote(note);
  }
  closeModal();
};

const confirmDelete = (noteId: string) => {
  noteToDeleteId.value = noteId;
  showConfirmModal.value = true;
};

const deleteNote = async () => {
  if (noteToDeleteId.value !== null) {
    await notesStore.deleteNote(noteToDeleteId.value);
    showConfirmModal.value = false;
    noteToDeleteId.value = null;
  }
};

const closeModal = () => {
  showModal.value = false;
  currentNote.value = { id: '', title: '', desc: '' };
};

const loadMoreNotes = async () => {
  await notesStore.fetchNotes();
  window.addEventListener('scroll', onScroll);
};

watchEffect(() => {
  if (notesStore.notification.show) {
    toast.add({
      title: notesStore.notification.type,
      description: notesStore.notification.message,
      color: notesStore.notification.type === 'Success' ? 'green' : 'red',
      icon:
        notesStore.notification.type === 'Success'
          ? 'i-heroicons-check-circle'
          : 'i-heroicons-x-circle',
      timeout: 3000,
    });
  }
});

onMounted(() => {
  loadMoreNotes();
});

useHead({
  title: 'My Notes',
  meta: [
    {
      content: 'My Notes App',
    },
  ],
});
</script>

<style scoped></style>
