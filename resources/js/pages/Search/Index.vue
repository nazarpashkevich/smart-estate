<script lang="ts">
import { defineComponent } from 'vue'
import MainLayout from "@/layouts/MainLayout.vue";
import HeroSearch from "@/components/Pages/Home/HeroSearch.vue";
import EstateItemCard from "@/components/Estate/EstateItemCard.vue";
import { EstateItem } from "@/contracts/estate-item";

export default defineComponent({
    name: "Index",
    components: { EstateItemCard, HeroSearch, MainLayout },
    data: () => ({}),
    props: {
        searchQuery: {
            type: String,
            default: ''
        },
        results: {
            type: Array as EstateItem[],
            default: []
        }
    }
})
</script>

<template>
    <MainLayout>
        <div class="flex px-12 gap-12 py-20">
            <div class="w-2/3 flex flex-col gap-8">
                <div class="h-42 flex-1 border rounded-lg shadow-lg bg-white py-6 px-8">
                    <h1 class="text-3xl bold">Hey, we have found 123 results for you!</h1>
                    <p class="mt-2 mb-6 text-sm">You always free to change search query</p>
                    <hero-search :value="searchQuery"/>
                </div>
                <div class="h-42 flex-1 border rounded-lg shadow-lg bg-white px-8">
                    <template v-for="item in results">
                        <div class="py-12 border-b  ">
                            <estate-item-card :item="item"/>
                        </div>
                    </template>
                </div>

                <div>
                    // pagination
                </div>
            </div>
            <div class="w-1/3">
                <!--@todo to component -->
                <div class="border rounded-lg bg-white shadow-sm py-4 px-12">
                    <h2 class="font-bold text-xl">Looking for something else?</h2>
                    <a class="w-32 flex justify-center rounded-lg bg-blue-700 text-white px-3 py-2 my-4" href="#">
                        Read more
                        <svg aria-hidden="true"
                             class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto translate-y-2/4	animate-bounce"
                             fill="none" viewBox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>

</style>
