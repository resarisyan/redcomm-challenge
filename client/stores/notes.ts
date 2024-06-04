import { defineStore } from 'pinia';
import type { NoteType } from '~/utils/types/noteType';
import type { NotificationType } from '~/utils/types/notificationType';

interface NotesState {
  notes: NoteType[];
  page: number;
  totalPages: number;
  loading: boolean;
  searchQuery: string;
  next_page_url: string;
  notification: NotificationType;
}
export const useNotesStore = defineStore('notes', {
  state: (): NotesState => ({
    notes: [],
    page: 0,
    totalPages: 1,
    loading: false,
    searchQuery: '',
    next_page_url: '',
    notification: {
      message: '',
      type: 'Success',
      show: false,
    },
  }),
  actions: {
    async fetchNotes() {
      const API_BASE_URL = useRuntimeConfig().public.API_BASE_URL;
      if (this.loading) return;
      this.loading = true;
      try {
        const url = this.next_page_url || `${API_BASE_URL}/notes`;
        const response = (await $fetch(url, {
          method: 'GET',
          params: {
            search: this.searchQuery,
          },
        })) as any;
        this.notes = [...this.notes, ...response.data.data];
        this.next_page_url = response.data.next_page_url;
      } catch (error) {
        this.showErrorNotification('Failed to fetch notes');
      }
      this.loading = false;
    },
    async createNote(note: NoteType) {
      const API_BASE_URL = useRuntimeConfig().public.API_BASE_URL;
      try {
        const response = (await $fetch(`${API_BASE_URL}/notes`, {
          method: 'POST',
          body: note,
        })) as any;
        this.refreshNotes();
        this.showSuccessNotification(response.message);
      } catch (error) {
        this.showErrorNotification('Failed to create note');
      }
    },
    async updateNote(note: NoteType) {
      const API_BASE_URL = useRuntimeConfig().public.API_BASE_URL;
      try {
        const response = (await $fetch(`${API_BASE_URL}/notes/${note.id}`, {
          method: 'PUT',
          body: note,
        })) as any;
        this.refreshNotes();
        this.showSuccessNotification(response.message);
      } catch (error) {
        this.showErrorNotification('Failed to update note');
      }
    },
    async deleteNote(noteId: string) {
      const API_BASE_URL = useRuntimeConfig().public.API_BASE_URL;
      try {
        const response = (await $fetch(`${API_BASE_URL}/notes/${noteId}`, {
          method: 'DELETE',
        })) as any;
        this.refreshNotes();
        this.showSuccessNotification(response.message);
      } catch (error) {
        console.log(error);
        this.showErrorNotification('Failed to delete note');
      }
    },
    async refreshNotes() {
      this.notes = [];
      this.next_page_url = '';
      await this.fetchNotes();
    },
    setSearchQuery(searchQuery: string) {
      this.searchQuery = searchQuery;
      this.refreshNotes();
    },

    showSuccessNotification(message: string) {
      this.notification.message = message;
      this.notification.type = 'Success';
      this.notification.show = true;
      setTimeout(() => {
        this.notification.show = false;
      }, 3000);
    },

    showErrorNotification(message: string) {
      this.notification.message = message;
      this.notification.type = 'Error';
      this.notification.show = true;
      setTimeout(() => {
        this.notification.show = false;
      }, 3000);
    },
  },
});
