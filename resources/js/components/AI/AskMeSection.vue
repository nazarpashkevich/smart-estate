<script lang="ts">
import { defineComponent } from 'vue'
import AiChatPopup from "@/components/AI/AiChatPopup.vue";

export default defineComponent({
    name: "AskMeSection",
    components: { AiChatPopup },
    data: () => ({
        showChat: false
    })
})
</script>

<template>
    <div class="border rounded-lg bg-white shadow-sm py-4 px-12">
        <h2 class="font-bold text-xl">Looking for something else?</h2>
        <div class="w-32 flex justify-center rounded-lg bg-blue-700 text-white px-3 py-2 my-4"
             v-on:click="showChat = true">
            Ask AI
            <svg aria-hidden="true"
                 class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto translate-y-2/4	animate-bounce"
                 fill="none" viewBox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"/>
            </svg>
        </div>
    </div>
    <ai-chat-popup v-if="showChat" @close="showChat = false"/>
</template>
