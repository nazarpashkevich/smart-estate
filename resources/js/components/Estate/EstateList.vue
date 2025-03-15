<script lang="ts">
import EstateItemCard from '@/components/Estate/EstateItemCard.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import { EstateItem } from '@/contracts/estate-item';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'EstateList',
  components: { PrimaryButton, EstateItemCard },
  props: {
    items: {
      type: Array<EstateItem>,
      required: true,
    },
    personalView: {
      type: Boolean,
      default: false,
    },
  },
});
</script>

<template>
  <div>
    <template v-for="item in items">
      <div class="py-12 border-b border-slate-300 px-12">
        <estate-item-card :item="item">
          <template #controls>
            <template v-if="personalView">
              <Link
                :href="route('personal.estate.edit', item.id)"
                class="ml-auto"
              >
                <primary-button>Edit</primary-button>
              </Link>
            </template>
            <button
              v-else
              class="ml-auto py-2 px-4 bg-blue-700 rounded-lg text-white"
            >
              Buy now!
            </button>
          </template>
        </estate-item-card>
      </div>
    </template>
  </div>
</template>

<style scoped></style>
