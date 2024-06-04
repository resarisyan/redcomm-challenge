<template>
  <UModal v-model="isVisible" prevent-close>
    <UCard
      :ui="{
        ring: '',
        divide: 'divide-y divide-gray-100 dark:divide-gray-800',
      }"
    >
      <template #header>
        <div class="flex items-center justify-between">
          <h3
            class="text-base font-semibold leading-6 text-gray-900 dark:text-white"
          >
            {{ title }}
          </h3>
          <UButton
            color="gray"
            variant="ghost"
            icon="i-heroicons-x-mark-20-solid"
            class="-my-1"
            @click="close"
          />
        </div>
      </template>
      <template #default>
        <slot name="modal-content"></slot>
      </template>
    </UCard>
  </UModal>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, ref } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  modelValue: {
    type: Boolean,
    required: true,
  },
});

const emits = defineEmits(['update:modelValue']);

const isVisible = ref(props.modelValue);

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
