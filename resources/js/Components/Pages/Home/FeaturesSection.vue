<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: "FeaturesSection",
    data: () => ({
        features: [
            {
                image: "https://img.fortawesome.com/1ce05b4b/start-illustration.svg",
                text: "Feature 1"
            },
            {
                image: "https://purepng.com/public/uploads/large/purepng.com-photos-iconsymbolsiconsapple-iosiosios-8-iconsios-8-721522596102asedt.png",
                text: "Feature 2"
            },
            {
                image: "https://images.vexels.com/media/users/3/141120/isolated/preview/a5ff757d7423e6c757795e7b60183180-rocket-round-icon.png",
                text: "Feature 3"
            }
        ]
    })
})
</script>

<template>
    <div class="w-full bg-cover bg-black/10 grid grid-cols-3 gap-16 px-48 py-20"
         :style="{backgroundImage: 'url(\'/images/white-abstract-background.jpg\')'}">
        <template v-for="feature in features">
            <div class="bg-white rounded-lg shadow-lg px-12 py-8 flex gap-8 text-center">
                <div class="w-1/3 bg-cover"
                     :style="{backgroundImage: `url('${feature.image}')`}"></div>
                <p class="w-2/3 my-auto my-6">{{ feature.text }}</p>
            </div>
        </template>
    </div>
</template>

<style scoped>
</style>
