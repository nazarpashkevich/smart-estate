<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: "PrimaryButton",
    props: {
        size: {
            type: String,
            default: 'small'
        }
    },
    computed: {
        classList() {
            return this.size === 'small' ? 'px-4 py-2 text-xs' : 'px-6 py-3 text-md';
        }
    }
})
</script>
<template>
    <button
        :class="classList"
        class="inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold
        text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700
        active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
        transition ease-in-out duration-150"
    >
        <slot/>
    </button>
</template>
