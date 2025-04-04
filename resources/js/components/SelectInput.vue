<script lang="ts">
import { SelectOption } from '@/contracts/base';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'SelectInput',
  computed: {
    displayValue() {
      return (
        this.options?.find((option) => option.key == this.modelValue)?.value ??
        ''
      );
    },
  },
  data: () => ({
    showDropdown: false,
  }),
  props: {
    modelValue: {},
    options: {
      type: Array<SelectOption>,
      required: true,
    },
    withEmpty: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const displayOptions = props.options;

    if (props.withEmpty) {
      displayOptions.unshift({ key: '', value: '' });
    } else if (!props.modelValue) {
      emit('update:modelValue', props.options[0].key);
    }

    return {
      displayOptions,
    };
  },
});
</script>

<template>
  <div class="">
    <div
      v-click-outside="() => (showDropdown ? (showDropdown = false) : null)"
      :class="`rounded${showDropdown ? '-t' : ''}-md`"
      class="relative px-4 py-2.5 pr-10 min-w-32 border shadow-sm border-gray-300 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm mt-1 block w-full"
      v-on:click="showDropdown = !showDropdown"
    >
      <p class="text-sm h-5">{{ displayValue }}</p>
      <span
        :class="showDropdown ? 'rotate-[225deg]' : 'rotate-45'"
        class="absolute top-2/4 right-4 border-b border-r border-gray-600 w-2 h-2 translate-y-[-50%] transition-transform"
      >
      </span>
      <ul
        v-if="showDropdown"
        class="absolute z-[9999] w-full top-full left-0 border border-gray-300 rounded-b-lg bg-white shadow-md"
      >
        <template v-for="option in displayOptions">
          <li
            class="w-full py-2 px-4 hover:bg-gray-100 cursor-pointer h-10"
            v-on:click="() => $emit('update:modelValue', option.key)"
          >
            {{ option.value }}
          </li>
        </template>
      </ul>
    </div>
  </div>
</template>
