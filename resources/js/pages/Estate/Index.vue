<script lang="ts">
import AskMeSection from '@/components/AI/AskMeSection.vue';
import Pagination from '@/components/Common/List/Pagination.vue';
import SearchForm from '@/components/Common/SearchForm.vue';
import EstateItemCard from '@/components/Estate/EstateItemCard.vue';
import EstateList from '@/components/Estate/EstateList.vue';
import RandomFactSection from '@/components/Useless/RandomFactSection.vue';
import { BaseData } from '@/contracts/base';
import { EstateItem } from '@/contracts/estate-item';
import MainLayout from '@/layouts/MainLayout.vue';
import { defineComponent, PropType } from 'vue';

export default defineComponent({
  name: 'Index',
  components: {
    RandomFactSection,
    AskMeSection,
    EstateList,
    Pagination,
    SearchForm,
    EstateItemCard,
    MainLayout,
  },
  data: () => ({}),
  props: {
    filters: {
      type: Object,
    },
    items: {
      type: Object as PropType<BaseData<EstateItem>>,
      default: [],
    },
  },
});
</script>

<template>
  <MainLayout>
    <div class="flex px-12 gap-12 py-20">
      <div class="w-2/3 flex flex-col gap-8">
        <div
          class="flex-1 border border-slate-300 rounded-lg shadow-lg bg-white py-6 px-8"
        >
          <h1 class="text-3xl bold">
            Hey, we have found {{ items.meta.total }} results for you!
          </h1>
          <p class="mt-2 mb-6 text-sm">
            You are always free to change search query
          </p>
          <SearchForm :value="filters?.search ?? ''" />
        </div>
        <div
          class="flex-1 border border-slate-300 rounded-lg shadow-lg bg-white"
        >
          <EstateList :items="items.data" />
        </div>

        <div>
          <Pagination :meta="items.meta" />
        </div>
      </div>
      <div class="w-1/3 flex flex-col gap-8">
        <AskMeSection />
        <RandomFactSection />
      </div>
    </div>
  </MainLayout>
</template>

<style scoped></style>
