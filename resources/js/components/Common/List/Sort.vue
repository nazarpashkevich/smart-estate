<script lang="ts">
import Dropdown from '@/components/Dropdown.vue';
import DropdownLink from '@/components/DropdownLink.vue';
import { defineComponent } from 'vue';

interface SortOption {
  key: string;
  name: string;
}

export default defineComponent({
  name: 'Sort',
  components: { DropdownLink, Dropdown },
  props: {
    options: {
      type: Array<SortOption>,
      required: true,
    },
    path: {
      type: String,
      required: true,
    },
  },
  setup() {
    const params = new URLSearchParams(window.location.search);

    const currentSort = params.get('sort');

    return { currentSort };
  },
});
</script>

<template>
  <dropdown>
    <template #trigger>
      <span class="inline-flex rounded-md">
        <button
          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
          type="button"
        >
          Sort
          <svg
            class="ms-2 -me-0.5 h-4 w-4"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              clip-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              fill-rule="evenodd"
            />
          </svg>
        </button>
      </span>
    </template>

    <template #content>
      <template v-for="option in options">
        <dropdown-link
          :class="currentSort === option.key ? 'bg-gray-100' : ''"
          :href="route(path, { sort: option.key })"
        >
          {{ option.name }}
        </dropdown-link>
      </template>
    </template>
  </dropdown>
</template>
