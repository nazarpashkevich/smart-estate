<script lang="ts">
import { defineComponent } from 'vue'
import UserLayout from "@/layouts/UserLayout.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import EstateList from "@/components/Estate/EstateList.vue";
import { Head } from "@inertiajs/vue3";
import EstateItemForm from "@/pages/Personal/Estate/Partials/EstateItemForm.vue";
import { EstateItem } from "@/contracts/estate-item";

export default defineComponent({
    name: "Edit",
    components: { EstateItemForm, EstateList, PrimaryButton, UserLayout, Head },
    props: {
        item: Object as EstateItem
    }
});
</script>

<template>
    <Head title="Estate"/>

    <user-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Estate</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 px-12">
                    <estate-item-form :item="item"/>
                </div>
            </div>
        </div>
    </user-layout>
</template>
