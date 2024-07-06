<script lang="ts">
import { defineComponent } from 'vue'
import TextInput from "@/components/TextInput.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import AiChatMessage from "@/components/AI/AiChatMessage.vue";

export default defineComponent({
    name: "AiChatPopup",
    components: { AiChatMessage, PrimaryButton, TextInput },
    data: () => ({
        message: '',
        history: [
            {
                text: 'Hey, how are you?',
                created: '12.12.2021 12:31',
                sender: 'bot'
            },
            {
                text: 'Hey, how are you?',
                created: '12.12.2021 12:31',
                sender: 'author'
            }
        ]
    }),
    emits: ['close']
})
</script>

<template>
    <div class="fixed border rounded-xl bg-white right-12 bottom-6 w-96 flex flex-col">
        <div class="bg-gray-300 px-6 py-3 items-center rounded-t-xl flex relative">
            <img alt="" class="mr-6 w-10" src="/images/chat/avatar.png">
            <p class="text-md text-blue-900 font-semibold">AI Bot</p>
            <span class="text-xs text-gray-500 ml-4">online</span>
            <span class="absolute right-4 top-3 cursor-pointer" v-on:click="this.$emit('close')">
                <svg height="20px" viewBox="0 0 50 50" width="20px" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"/>
                </svg>
            </span>
        </div>
        <div class="bg-white h-96 px-6 py-3 flex flex-col gap-4">
            <template v-for="message in history">
                <ai-chat-message :message="message"/>
            </template>
        </div>
        <div class="border-t rounded-b-xl py-3 px-6 flex gap-4">
            <text-input :model-value="message" class="w-full" placeholder="Type your message"/>
            <primary-button class="ml-auto">Send</primary-button>
        </div>
    </div>
</template>

