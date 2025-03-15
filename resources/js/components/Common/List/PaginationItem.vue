<script lang="ts">
import { router } from '@inertiajs/vue3';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'PaginationItem',
  computed: {
    classes() {
      return this.active
        ? 'bg-blue-700 text-white'
        : ' bg-white cursor-pointer hover:bg-blue-700 hover:text-white';
    },
  },
  props: {
    active: {
      type: Boolean,
      required: true,
    },
    path: {
      type: String,
      required: true,
    },
    page: {
      type: Number,
      required: true,
    },
    pageName: {
      type: String,
      default: 'page',
    },
  },
  methods: {
    navigate() {
      const params = new URLSearchParams(window.location.search);

      params.set(this.pageName, this.page);

      router.visit(this.path, { data: params });
    },
  },
});
// todo
</script>

<template>
  <span
    :class="classes"
    class="border border-slate-300 px-3 py-1.5 rounded-lg text-center"
    v-on:click="navigate"
    >{{ page }}</span
  >
</template>

<style scoped></style>
