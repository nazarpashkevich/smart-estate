<script lang="ts">
import { EstateItem } from '@/contracts/estate-item';
import EstateService from '@/services/EstateService';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'SuggestApartmentCart',
  data: () => ({
    apartment: null as null | EstateItem,
  }),
  methods: {
    async initApartment() {
      this.apartment = await new EstateService().find(this.id);
    },
  },
  mounted() {
    this.initApartment();
  },
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
});
</script>

<template>
  <Link
    v-if="apartment"
    :href="route('estate.show', apartment.id)"
    class="w-full border flex gap-4 py-4 px-4 my-4 bg-white rounded-lg text-blue-800 hover:text-blue-900 text-sm"
  >
    <img :src="apartment.preview" alt="" class="w-16 rounded-sm" />
    <div>{{ apartment.title?.slice(0, 50) }}</div>
  </Link>
</template>
