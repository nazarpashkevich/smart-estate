<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'FeaturesSection',
  data: () => ({
    features: [
      {
        image: 'https://img.fortawesome.com/1ce05b4b/start-illustration.svg',
        text: ' Intelligent Property Valuation',
      },
      {
        image:
          'https://purepng.com/public/uploads/large/purepng.com-photos-iconsymbolsiconsapple-iosiosios-8-iconsios-8-721522596102asedt.png',
        text: 'Comprehensive Property Insights',
      },
      {
        image:
          'https://images.vexels.com/media/users/3/141120/isolated/preview/a5ff757d7423e6c757795e7b60183180-rocket-round-icon.png',
        text: 'Smart Market Analysis',
      },
    ],
  }),
});
</script>

<template>
  <div
    :style="{
      backgroundImage: 'url(\'/images/white-abstract-background.jpg\')',
    }"
    class="w-full bg-cover bg-black/10 grid grid-cols-3 gap-16 px-48 py-20"
  >
    <template v-for="feature in features">
      <div
        class="bg-white rounded-lg shadow-lg px-12 py-8 flex gap-8 text-center"
      >
        <div
          :style="{ backgroundImage: `url('${feature.image}')` }"
          class="w-1/3 bg-contain bg-no-repeat bg-center h-16"
        ></div>
        <p class="w-2/3 my-auto my-6 text-center">
          <strong>{{ feature.text }}</strong>
        </p>
      </div>
    </template>
  </div>
</template>
