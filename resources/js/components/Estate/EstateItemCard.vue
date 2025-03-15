<script lang="ts">
import { EstateItem } from '@/contracts/estate-item';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'EstateItemCard',
  props: {
    item: {
      type: Object as () => EstateItem,
      required: true,
    },
  },
});
</script>

<template>
  <div class="flex gap-12">
    <div class="w-1/2">
      <div
        :style="{ backgroundImage: `url(${item.preview})` }"
        class="bg-cover w-full h-full rounded-sm"
      ></div>
    </div>
    <div class="w-1/2">
      <Link
        :href="route('estate.show', item.id)"
        class="text-2xl font-semibold mb-4 hover:text-blue-800 cursor-pointer"
      >
        Buy {{ item.rooms }} rooms, {{ item.title.slice(0, 50) }}...
      </Link>
      <p class="text-sm my-4 text-gray-500">
        Description: {{ item.description }}
      </p>
      <ul class="list-disc text-gray-600 space-y-1 list-inside">
        <li>Rooms: {{ item.rooms }}</li>
        <li>Floor: {{ item.floor }}</li>
        <li>Square: {{ item.square }}</li>
        <li>Year of building: {{ item.yearOfBuild }}</li>
        <li>Bedrooms: {{ item.bedrooms }}</li>
        <li>With{{ item.hasParking ? '' : 'out' }} parking</li>
      </ul>
      <div class="mt-12 flex">
        <span class="text-2xl font-semibold">{{ item.price.format }}</span>
        <slot name="controls"> </slot>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
