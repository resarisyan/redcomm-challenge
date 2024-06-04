<template>
  <UModal v-model="isVisible" prevent-close>
    <UCard>
      <div class="space-y-2">
        <h1 class="text-xl">{{ title }}</h1>
        <p>{{ message }}</p>
        <div class="flex justify-end space-x-2">
          <UButton color="red" @click="confirm">{{
            confirmButtonText
          }}</UButton>
          <UButton @click="cancel">{{ cancelButtonText }}</UButton>
        </div>
      </div>
    </UCard>
  </UModal>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, ref, watch } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  message: {
    type: String,
    required: true,
  },
  confirmButtonText: {
    type: String,
    default: 'Delete',
  },
  cancelButtonText: {
    type: String,
    default: 'Cancel',
  },
  modelValue: {
    type: Boolean,
    required: true,
  },
});

const emits = defineEmits(['update:modelValue', 'confirm', 'cancel']);

const isVisible = ref(props.modelValue);

const confirm = () => {
  emits('confirm');
  close();
};

const cancel = () => {
  emits('cancel');
  close();
};

const close = () => {
  isVisible.value = false;
  emits('update:modelValue', false);
};

watch(
  () => props.modelValue,
  (newVal) => {
    isVisible.value = newVal;
  }
);
</script>

<style scoped></style>
