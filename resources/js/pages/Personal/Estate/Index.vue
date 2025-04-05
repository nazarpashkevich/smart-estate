<script lang="ts">
import Filters from '@/components/Common/Filters.vue';
import RangeFilter from '@/components/Common/Filters/RangeFilter.vue';
import Pagination from '@/components/Common/List/Pagination.vue';
import Sort from '@/components/Common/List/Sort.vue';
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import EstateList from '@/components/Estate/EstateList.vue';
import MapInput from '@/components/MapInput.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import SelectInput from '@/components/SelectInput.vue';
import { BaseData } from '@/contracts/base';
import { EstateItem } from '@/contracts/estate-item';
import {
  BedroomsOptions,
  RoomsOptions,
  YearBuildingOptions,
} from '@/enums/estate-item';
import { enumToSelectOptions } from '@/helpers/helpers';
import UserLayout from '@/layouts/UserLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { defineComponent, PropType } from 'vue';

export default defineComponent({
  name: 'Create',
  methods: {
    enumToSelectOptions,
    onSubmitFilters() {
      this.filtersForm.get(route('personal.estate.index'));
    },
  },
  computed: {
    yearBuildingOptions() {
      return YearBuildingOptions;
    },
    bedroomsOptions() {
      return BedroomsOptions;
    },
    roomsOptions() {
      return RoomsOptions;
    },
  },
  components: {
    MapInput,
    SelectInput,
    RangeFilter,
    Filters,
    Sort,
    DropdownLink,
    Dropdown,
    Pagination,
    EstateList,
    PrimaryButton,
    UserLayout,
    Head,
  },
  data: () => ({
    sortOptions: [
      {
        key: 'rooms',
        name: 'Rooms (increasing)',
      },
      {
        key: 'rooms:desc',
        name: 'Rooms (decreasing)',
      },
      {
        key: 'floor',
        name: 'Floor (increasing)',
      },
      {
        key: 'floor:desc',
        name: 'Floor (decreasing)',
      },
      {
        key: 'price',
        name: 'Price (increasing)',
      },
      {
        key: 'price:desc',
        name: 'Price (decreasing)',
      },
    ],
    showFilters: false,
  }),
  props: {
    items: {
      type: Object as PropType<BaseData<EstateItem>>,
      required: true,
    },
    filters: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const filtersForm = useForm({
      filters: {
        rooms: props.filters.rooms ?? null,
        bedrooms: props.filters.bedrooms ?? null,
        yearOfBuild: props.filters.yearOfBuild ?? null,
        priceFrom: props.filters.priceFrom ?? null,
        priceTo: props.filters.priceTo ?? null,
      },
    });

    return { filtersForm };
  },
});
</script>

<template>
  <Head title="Estate" />

  <user-layout>
    <template #header>
      <div class="flex">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Estate
        </h2>
        <Link :href="route('personal.estate.create')" class="ml-auto">
          <primary-button>Add</primary-button>
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="py-3 px-12 flex border-b">
            <primary-button v-on:click="showFilters = !showFilters"
              >Filters</primary-button
            >
            <sort
              :options="sortOptions"
              class="ml-auto"
              path="personal.estate.index"
            ></sort>
          </div>
          <div
            :class="showFilters ? 'h-56 opacity-1' : 'h-0 opacity-0'"
            class="transition-height duration-150 ease-in-out"
          >
            <div v-if="showFilters" class="py-3 px-12 flex border-b">
              <filters @submit="onSubmitFilters">
                <template #filters>
                  <div class="flex gap-12">
                    <div
                      class="grow border rounded-xl border-gray-300 py-4 px-6 flex flex-col"
                    >
                      <range-filter
                        :from="filtersForm.filters.priceFrom"
                        :path="route('personal.estate.index')"
                        :to="filtersForm.filters.priceTo"
                        title="Price"
                        @update:from="
                          (from) => (filtersForm.filters.priceFrom = from)
                        "
                        @update:to="(to) => (filtersForm.filters.priceTo = to)"
                      />
                    </div>
                    <div class="grow">
                      <label class="mb-2 text-gray-500 text-sm">Rooms:</label>
                      <select-input
                        v-model="filtersForm.filters.rooms"
                        :options="enumToSelectOptions(roomsOptions)"
                        :with-empty="true"
                      />
                    </div>
                    <div class="grow">
                      <label class="mb-2 text-gray-500 text-sm"
                        >Bedrooms:</label
                      >
                      <select-input
                        v-model="filtersForm.filters.bedrooms"
                        :options="enumToSelectOptions(bedroomsOptions)"
                        :with-empty="true"
                      />
                    </div>
                    <div class="grow">
                      <label class="mb-2 text-gray-500 text-sm"
                        >Year of building:</label
                      >
                      <select-input
                        v-model="filtersForm.filters.yearOfBuild"
                        :options="enumToSelectOptions(yearBuildingOptions)"
                        :with-empty="true"
                      />
                    </div>
                  </div>
                </template>
              </filters>
            </div>
          </div>
          <estate-list :items="items.data" :personal-view="true" />
          <div>
            <pagination :meta="items.meta" />
          </div>
        </div>
      </div>
    </div>
  </user-layout>
</template>
