<script lang="ts">
import { defineComponent } from 'vue'
import { PaginationMeta } from "@/contracts/base";
import PaginationItem from "@/components/Common/List/PaginationItem.vue";
import { router } from "@inertiajs/vue3";

export default defineComponent({
    name: "Pagination",
    components: { PaginationItem },
    computed: {
        pages() {
            const pages = [];

            if (this.meta.total === 0) {
                return pages;
            }
            const { current_page: currentPage, last_page: lastPage } = this.meta;

            pages.push(1); // first page

            if (currentPage > 3 && currentPage === lastPage) {
                pages.push(currentPage - 2); // previous previous page
            }

            if (currentPage > 2) {
                pages.push(currentPage - 1); // previous page
            }

            if (currentPage !== 1 && currentPage !== lastPage) {
                pages.push(currentPage); // current page (only if it's not the first or last page)
            }

            if (currentPage < lastPage - 1) {
                pages.push(currentPage + 1); // next page
            }

            if (lastPage > 1) {
                pages.push(lastPage); // last page
            }

            return pages;
        }
    },
    props: {
        meta: {
            type: Object as PaginationMeta,
            required: true
        }
    },
    methods: {
        router() {
            return router
        },
        isActive(page: number) {
            return this.meta.current_page === page;
        }
    }
});
</script>

<template>
    <div class="my-4 flex justify-center gap-4">
        <template v-for="(page, index) in pages">
            <pagination-item
                :active="isActive(page)"
                :page="page"
                :path="meta.path"
            />
            <span v-if="(pages[index+1] - page > 1)" class="mt-auto">...</span>
        </template>
    </div>
</template>
