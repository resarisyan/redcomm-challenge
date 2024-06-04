<template>
  <UForm
    :schema="schema"
    :state="state"
    class="space-y-4"
    @submit="handleSubmit"
  >
    <UFormGroup label="Title" name="title">
      <UInput v-model="state.title" />
    </UFormGroup>

    <UFormGroup label="Description" name="desc">
      <UTextarea v-model="state.desc" />
    </UFormGroup>

    <UButton type="submit">Submit</UButton>
  </UForm>
</template>

<script lang="ts" setup>
import { reactive, computed, watch, defineEmits } from 'vue';
import type { NoteType } from '~/utils/types/noteType';
import {
  createNoteSchema,
  updateNoteSchema,
} from '~/utils/validators/noteValidation';
import type { FormSubmitEvent } from '#ui/types';
import type { Schema } from 'yup';

const props = defineProps<{
  note: NoteType;
}>();

const state = reactive({
  title: props.note.title || '',
  desc: props.note.desc || '',
});

const schema = computed(() => {
  return props.note && props.note.id ? updateNoteSchema : createNoteSchema;
});

const emit = defineEmits(['submit']);
const handleSubmit = (event: FormSubmitEvent<Schema>) => {
  const note: NoteType = {
    id: props.note.id,
    title: state.title,
    desc: state.desc,
  };
  emit('submit', note);
};

watch(
  () => props.note,
  (newNote) => {
    state.title = newNote.title;
    state.desc = newNote.desc;
  }
);
</script>

<style></style>
