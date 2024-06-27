<script lang="ts">
import { defineComponent } from 'vue'
import { EstateItem } from "@/contracts/estate-item";
import EstateItemCard from "@/components/Estate/EstateItemCard.vue";

export default defineComponent({
    name: "EstateList",
    components: { EstateItemCard },
    props: {
        items: {
            type: Array<EstateItem>,
            required: true
        }
    }
})
</script>

<template>
    <div>
        <template v-for="item in items">
            <div class="py-12 border-b px-12">
                <estate-item-card :item="item"/>
            </div>
        </template>
    </div>
</template>

<style scoped>

</style>
