<script lang="ts">
import { defineComponent } from 'vue'
import HeroMenu from "@/Components/Pages/Home/HeroMenu.vue";
import HeroSearch from "@/Components/Pages/Home/HeroSearch.vue";

export default defineComponent({
    name: "HeroSection",
    components: { HeroSearch, HeroMenu }
})
</script>

<template>
    <div
        class="flex flex-col h-[33rem] bg-contain bg-[url('https://ssl.cdn-redfin.com/v525.2.0/images/homepage/banners/genHomepageDesktopBanner/HPTO_2120-NW-97th-St-Seattle_PremierHP.jpg')]">
       <hero-menu/>
        <div class="flex h-full">
            <div class="w-1/2 flex flex-col">
                <div class="my-auto mx-24 bg-white rounded-lg shadow-lg border-b py-4 px-6">
                    <p class="mb-4 text-sm">
                        Looking for apartment? Choose your location and get the best options.
                    </p>
                    <hero-search/>
                </div>
            </div>
            <div class="w-1/2 flex">
                <p class="text-6xl text-white my-auto px-8">
                    Over 1756+ propositions, super powered by AI search and absolutely free!
                </p>
            </div>
        </div>
    </div>
</template>
