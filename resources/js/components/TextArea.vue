<script lang="ts" setup>
import { onMounted, ref } from 'vue';

const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value?.focus();
  }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
  <textarea
    ref="input"
    v-model="model"
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
  ></textarea>
</template>
