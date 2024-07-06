<script lang="ts">
import { defineComponent } from 'vue'
import MainLayout from "@/layouts/MainLayout.vue";
import { EstateItem } from "@/contracts/estate-item";
import PrimaryButton from "@/components/PrimaryButton.vue";
import MapSection from "@/components/Common/MapSection.vue";
import BuyForm from "@/pages/Estate/Partials/BuyForm.vue";
import AskMeSection from "@/components/AI/AskMeSection.vue";

export default defineComponent({
    name: "Show",
    components: { AskMeSection, BuyForm, MapSection, PrimaryButton, MainLayout },
    data: () => ({
        showBuyForm: false
    }),
    props: {
        item: {
            type: Object as EstateItem,
        }
    }
})
</script>

<template>
    <MainLayout>
        <div class="gap-12 py-8 px-8 md:px-20">
            <div class="bg-white px-8 py-5 rounded-md shadow-md">
                <div class="flex gap-12 mb-12">
                    <div class="w-2/3">
                        <img :src="item.preview" alt="" class="w-[60rem]">
                    </div>
                    <div class="w-1/3">
                        <ask-me-section/>
                    </div>
                </div>
                <h1 class="text-4xl font-bold mb-4">{{ item.title }}</h1>
                <div class="px-4">
                    <div class="flex gap-8 items-center mb-6 flex-col sm:flex-row">
                        <p class="font-semibold text-3xl">{{ item.price.format }}</p>
                        <span class="text-sm text-gray-500"> some additional text here</span>
                        <primary-button class="ml-auto" size="large" v-on:click="showBuyForm = true">
                            Buy
                        </primary-button>
                    </div>
                    <div class="flex gap-4 mb-6 flex-col sm:flex-row">
                        <span class="text-md text-gray-700">· Square: {{ item.square }} m2</span>
                        <span class="text-md text-gray-700">· Rooms: {{ item.rooms }}</span>
                        <span class="text-md text-gray-700">· Bedrooms: {{ item.bedrooms }}</span>
                    </div>
                    <div class="flex gap-4 mb-6 ml-8">
                        <ul class="list-disc text-gray-600 space-y-1 list-inside">
                            <li>Floor: {{ item.floor }}</li>
                            <li>Year of building: {{ item.yearOfBuild }}</li>
                            <li>With{{ item.hasParking ? '' : 'out' }} parking</li>
                        </ul>
                    </div>
                    <div class="mb-8">
                        <p><span class="font-semibold">Seller description:</span> {{ item.description }}</p>
                    </div>
                    <div class="">
                        <h2 class="text-2xl font-semibold mb-4">Location</h2>
                        <map-section :lat="item.location.lat" :lng="item.location.lng" :zoom="15"/>
                    </div>
                </div>
            </div>
        </div>
        <buy-form v-if="showBuyForm" :item="item" @close="showBuyForm = false"/>
    </MainLayout>
</template>
