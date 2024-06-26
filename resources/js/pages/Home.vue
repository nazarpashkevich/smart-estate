<script lang="ts" setup>
import { Head } from '@inertiajs/vue3';
import HeroSection from "@/components/Pages/Home/HeroSection.vue";
import AboutSection from "@/components/Pages/Home/AboutSection.vue";
import FeaturesSection from "@/components/Pages/Home/FeaturesSection.vue";
import FooterSection from "@/components/Pages/Home/FooterSection.vue";

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
