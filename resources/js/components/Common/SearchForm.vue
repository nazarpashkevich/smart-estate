<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: "SearchForm",
    props: {
        value: {
            type: String,
            default: ''
        }
    }
})
</script>

<template>
    <div class="flex gap-2">
        <div class="relative w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg aria-hidden="true" class="w-4 h-4 text-gray-500 dark:text-gray-400"
                     fill="none" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" stroke="currentColor" stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"/>
                </svg>
            </div>
            <form :action="route('search.index')" method="GET">
                <input :value="value"
                       class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50
                    focus:ring-blue-500 focus:border-blue-500"
                       name="q"
                       placeholder="Your location&preferences&promt"
                       required
                       type="search"
                />
                <button class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4
                    focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"
                        type="submit">
                    Find
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
