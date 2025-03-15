<script lang="ts">
import MainFooter from '@/layouts/Main/MainFooter.vue';
import MainHeader from '@/layouts/Main/MainHeader.vue';
import { Link } from '@inertiajs/vue3';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'MainLayout',
  components: { MainFooter, MainHeader, Link },
});
</script>
<template>
  <div class="min-h-screen flex flex-col">
    <main-header />
    <main class="flex-1">
      <div class="bg-gray-100 flex">
        <div class="container mx-auto">
          <slot />
        </div>
      </div>
    </main>
    <main-footer />
  </div>
</template>
