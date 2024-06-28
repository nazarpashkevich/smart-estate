<script lang="ts">
import { defineComponent } from 'vue'
import UserLayout from "@/layouts/UserLayout.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import EstateList from "@/components/Estate/EstateList.vue";
import { Head } from "@inertiajs/vue3";
import { EstateItem } from "@/contracts/estate-item";
import { BaseData } from "@/contracts/base";
import Pagination from "@/components/Common/List/Pagination.vue";
import Dropdown from "@/components/Dropdown.vue";
import DropdownLink from "@/components/DropdownLink.vue";
import Sort from "@/components/Common/List/Sort.vue";

export default defineComponent({
    name: "Create",
    components: { Sort, DropdownLink, Dropdown, Pagination, EstateList, PrimaryButton, UserLayout, Head },
    data: () => ({
        sortOptions: [
            {
                key: 'rooms',
                name: 'Rooms (increasing)'
            },
            {
                key: 'rooms:desc',
                name: 'Rooms (decreasing)'
            },
            {
                key: 'floor',
                name: 'Floor (increasing)'
            },
            {
                key: 'floor:desc',
                name: 'Floor (decreasing)'
            },
            {
                key: 'price',
                name: 'Price (increasing)'
            },
            {
                key: 'price:desc',
                name: 'Price (decreasing)'
            }
        ]
    }),
    props: {
        items: {
            type: Object as BaseData<EstateItem>,
            required: true
        }
    }
});
</script>

<template>
    <Head title="Estate"/>

    <user-layout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Estate</h2>
                <Link :href="route('personal.estate.create')" class="ml-auto">
                    <primary-button>Add</primary-button>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-3 px-12 flex border-b">
                        <primary-button>Filters</primary-button>
                        <sort :options="sortOptions" class="ml-auto" path="personal.estate.index"></sort>
                    </div>
                    <estate-list :items="items.data" :personal-view="true"/>
                    <div>
                        <pagination :meta="items.meta"/>
                    </div>
                </div>
            </div>
        </div>
    </user-layout>
</template>
