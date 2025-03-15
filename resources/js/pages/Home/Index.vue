<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import AboutSection from './Partials/AboutSection.vue';
import FeaturesSection from './Partials/FeaturesSection.vue';
import FooterSection from './Partials/FooterSection.vue';
import HeroSection from './Partials/HeroSection.vue';
</script>

<template>
  <Head title="Welcome" />
  <main class="bg-slate-100">
    <hero-section />
    <about-section />
    <features-section />
    <footer-section />
  </main>
</template>
