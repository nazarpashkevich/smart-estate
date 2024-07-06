<script lang="ts">
import { defineComponent } from 'vue'
import MainLayout from "@/layouts/MainLayout.vue";
import EstateItemCard from "@/components/Estate/EstateItemCard.vue";
import { EstateItem } from "@/contracts/estate-item";
import SearchForm from "@/components/Common/SearchForm.vue";
import Pagination from "@/components/Common/List/Pagination.vue";
import EstateList from "@/components/Estate/EstateList.vue";
import { BaseData } from "@/contracts/base";
import AskMeSection from "@/components/AI/AskMeSection.vue";

export default defineComponent({
    name: "Index",
    components: { AskMeSection, EstateList, Pagination, SearchForm, EstateItemCard, MainLayout },
    data: () => ({}),
    props: {
        filters: {
            type: Object,
        },
        items: {
            type: Object as BaseData<EstateItem>,
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
                    <h1 class="text-3xl bold">Hey, we have found {{ items.meta.total }} results for you!</h1>
                    <p class="mt-2 mb-6 text-sm">You are always free to change search query</p>
                    <search-form :value="filters?.search ?? ''"/>
                </div>
                <div class="h-42 flex-1 border rounded-lg shadow-lg bg-white">
                    <estate-list :items="items.data"/>
                </div>

                <div>
                    <pagination :meta="items.meta"/>
                </div>
            </div>
            <div class="w-1/3">
                <!--@todo to component -->
                <ask-me-section/>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>

</style>
