<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import HeroSection from "@/Components/Pages/Home/HeroSection.vue";
import AboutSection from "@/Components/Pages/Home/AboutSection.vue";
import FeaturesSection from "@/Components/Pages/Home/FeaturesSection.vue";
import FooterSection from "@/Components/Pages/Home/FooterSection.vue";

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>
    <Head title="Welcome"/>
    <main class="bg-slate-100">
        <hero-section/>
        <about-section/>
       <features-section/>
       <footer-section/>
    </main>
</template>
