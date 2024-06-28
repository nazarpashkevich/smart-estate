<script lang="ts">
import { defineComponent } from 'vue'
import { router } from "@inertiajs/vue3";

export default defineComponent({
    name: "PaginationItem",
    computed: {
        classes() {
            return this.active ? 'bg-blue-700 text-white' : 'cursor-pointer hover:bg-blue-700 hover:text-white';
        }
    },
    props: {
        active: {
            type: Boolean,
            required: true
        },
        path: {
            type: String,
            required: true
        },
        page: {
            type: Number,
            required: true
        },
        pageName: {
            type: String,
            default: 'page'
        }
    },
    methods: {
        navigate() {
            router.visit(this.path, { data: { [this.pageName]: this.page } })
        }
    }
});
// todo
</script>

<template>
    <span :class="classes" class="border px-3 py-1.5 rounded-lg text-center" v-on:click="navigate">{{ page }}</span>
</template>

<style scoped>

</style>
