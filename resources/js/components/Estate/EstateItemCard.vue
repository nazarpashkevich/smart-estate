<script lang="ts">
import { defineComponent } from 'vue'
import { EstateItem } from "@/contracts/estate-item";

export default defineComponent({
    name: "EstateItemCard",
    props: {
        item: {
            type: Object as () => EstateItem,
            required: true
        }
    }
})
</script>

<template>
    <div class="flex gap-12">
        <div class="w-1/3">
            <div
                :style="{ backgroundImage: 'url(https://www.rocketmortgage.com/resources-cmsassets/RocketMortgage.com/Article_Images/Large_Images/Stock-Front-Of-Smaller-House-AdobeStock-118866140%20copy.jpeg)'}"
                class="bg-cover w-full h-full rounded-sm">
            </div>
        </div>
        <div class="w-2/3">
            <h3 class="text-lg font-semibold mb-4">Some title ({{ item.id }})</h3>
            <ul class="list-disc text-gray-600 space-y-1 list-inside">
                <li>feature 1</li>
                <li>feature 2</li>
                <li>feature 3</li>
                <li>feature 4</li>
            </ul>
            <div class="mt-12 flex">
                <span class="text-2xl font-semibold">19.000$</span>
                <button class="ml-auto py-2 px-4 bg-blue-700 rounded-lg text-white">Buy now!</button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
