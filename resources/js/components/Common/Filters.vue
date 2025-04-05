<script lang="ts">
import PrimaryButton from '@/components/PrimaryButton.vue';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Filters',
  components: { PrimaryButton },
  emits: ['submit'],
});
</script>

<template>
  <div class="px-8 py-4 w-full">
    <div class="mb-6">
      <slot name="filters"></slot>
    </div>
    <div class="flex">
      <primary-button class="ml-auto" v-on:click="$emit('submit')"
        >Apply</primary-button
      >
    </div>
  </div>
</template>
