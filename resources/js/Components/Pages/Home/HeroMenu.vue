<script lang="ts">
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/vue3'

export default defineComponent({
    name: "HeroMenu",
    components: {Link},
    data: ()=> ({
        items: [
            {
                name: "Home",
                link: "/"
            },
            {
                name: "Not Home",
                link: "/not-home"
            }
        ]
    })
})
</script>

<template>
    <div class="w-full flex bg-green gap-6 px-12 py-4 border-slate-50/40 border-b">
        <div class="bg-cover bg-center w-48 mr-16" :style='{backgroundImage: `url("/images/logo.png")`}'>
        </div>
        <template v-for="(item, index) in items">
            <Link
                class="px-6 px-2 cursor-pointer text-white hover:text-gray-200 border-b-4 border-b-transparent
                 border-t-4 border-t-transparent my-auto"
                :href="item.link"
                :class="{'border-r': index !== items.length - 1}"
            >
                {{ item.name }}
            </Link>
        </template>
        <Link class="ml-auto px-6 px-2 cursor-pointer text-white hover:text-gray-200" href="/login">Login</Link>
    </div>
</template>

<style scoped>

</style>
