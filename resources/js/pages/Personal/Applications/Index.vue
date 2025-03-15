<script lang="ts">
import Pagination from '@/components/Common/List/Pagination.vue';
import Sort from '@/components/Common/List/Sort.vue';
import SelectInput from '@/components/SelectInput.vue';
import { BaseData } from '@/contracts/base';
import { EstateApplication } from '@/contracts/estate-application';
import { EstateApplicationStatus } from '@/enums/estate-application';
import { enumToSelectOptions } from '@/helpers/helpers';
import UserLayout from '@/layouts/UserLayout.vue';
import ApplicationList from '@/pages/Personal/Applications/Partials/ApplicationList.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'Index',
  computed: {
    EstateApplicationStatus() {
      return EstateApplicationStatus;
    },
  },
  methods: {
    enumToSelectOptions,
    onUpdateStatus(status) {
      const oldStatus = this.filtersForm.status ?? null;
      this.filtersForm.status = status;

      if (oldStatus !== status) {
        router.visit(route('personal.application.index'), {
          data: { filters: { status } },
        });
      }
    },
  },
  components: {
    ApplicationList,
    SelectInput,
    Sort,
    Pagination,
    UserLayout,
    Head,
  },
  data: () => ({
    sortOptions: [
      {
        key: 'created_at',
        name: 'Created (newest first)',
      },
      {
        key: 'created_at:desc',
        name: 'Created (older first)',
      },
    ],
    showFilters: false,
  }),
  props: {
    items: {
      type: Object as BaseData<EstateApplication>,
      required: true,
    },
    filters: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const filtersForm = useForm({
      status: props.filters?.status ?? null,
    });

    const statuses = enumToSelectOptions(EstateApplicationStatus);
    statuses.unshift({ key: null, value: 'All' });

    return { filtersForm, statuses };
  },
});
</script>

<template>
  <Head title="Applications" />

  <user-layout>
    <template #header>
      <div class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Estate Applications
        </h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="py-3 px-12 flex border-b items-center">
            <select-input
              :model-value="filtersForm.status"
              :options="statuses"
              @update:model-value="onUpdateStatus"
            ></select-input>
            <sort
              :options="sortOptions"
              class="ml-auto"
              path="personal.application.index"
            ></sort>
          </div>
          <div class="min-h-24">
            <application-list v-if="items.meta.total > 0" :items="items.data" />
          </div>
          <div>
            <pagination :meta="items.meta" />
          </div>
        </div>
      </div>
    </div>
  </user-layout>
</template>
