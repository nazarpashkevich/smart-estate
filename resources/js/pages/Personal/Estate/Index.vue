<script lang="ts">
import { defineComponent } from 'vue'
import UserLayout from "@/layouts/UserLayout.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import EstateList from "@/components/Estate/EstateList.vue";
import { Head } from "@inertiajs/vue3";

export default defineComponent({
    name: "Create",
    components: { EstateList, PrimaryButton, UserLayout, Head },
    props: {}
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
                    <estate-list :items="[{}]"></estate-list>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Here will be the list of estate</div>
                </div>
            </div>
        </div>
    </user-layout>
</template>
