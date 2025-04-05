<script lang="ts">
import UselessService from '@/services/UselessService';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'RandomFactSection',
  data: () => ({
    fact: '',
  }),
  methods: {
    async initFact() {
      this.fact = await UselessService.randomFact();
    },
  },
  async mounted() {
    this.fact = await UselessService.randomFact();
  },
});
</script>

<template>
  <div class="border border-slate-300 rounded-lg bg-white shadow-sm py-4 px-12">
    <h2 class="font-bold text-xl">Have you known?)</h2>
    <p class="text-center text-lg font-semibold">{{ fact }}</p>
  </div>
</template>
