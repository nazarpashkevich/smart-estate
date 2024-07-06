<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: "AiChatMessage",
    props: {
        message: {
            type: Object,
            required: true
        }
    },
    computed: {
        messageClasses() {
            return this.message.sender === 'author' ? 'bg-blue-100 text-right ml-auto rounded-br-none' :
                'bg-gray-100 mr-auto rounded-bl-none';
        },
        createdTipClasses() {
            return this.message.sender === 'author' ? 'text-blue-400' : 'text-gray-400';
        }
    }
})
</script>

<template>
    <div :class="messageClasses" class="border px-4 pt-2 pb-6 relative rounded-lg text-gray-700">
        {{ message.text }}
        <span :class="createdTipClasses" class="absolute right-2 bottom-1 text-xs text-gray-400">
            {{ message.created }}
        </span>
    </div>
</template>
