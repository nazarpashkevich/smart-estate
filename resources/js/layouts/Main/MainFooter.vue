<script lang="ts">
import { Link } from '@inertiajs/vue3';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'MainFooter',
  components: { Link },
});
</script>

<template>
  <div class="h-12 text-center flex bg-gray-100 border-slate-300 border-t">
    <p class="m-auto text-sm">
      <a
        class="pointer text-indigo-600 hover:text-indigo-800"
        href="https://github.com/nazarpashkevich/"
      >
        @Infocoder
      </a>
      All rights reserved
    </p>
  </div>
</template>

<style scoped></style>
