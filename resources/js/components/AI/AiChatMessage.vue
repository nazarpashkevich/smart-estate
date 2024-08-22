<script lang="ts">
import { defineComponent } from 'vue'
import { ChatMessage } from "@/contracts/ai-chat";
import { ChatRole } from "@/enums/ai-chat";
import dayjs from "dayjs";
import SuggestApartmentCart from "@/components/AI/SuggestApartmentCart.vue";
import showdown from 'showdown';

export default defineComponent({
    name: "AiChatMessage",
    props: {
        message: {
            type: Object as ChatMessage,
            required: true
        }
    },
    components: { SuggestApartmentCart },
    computed: {
        dayjs() {
            return dayjs
        },
        messageClasses() {
            return this.message.role === ChatRole.User ? 'bg-blue-100 text-right ml-auto rounded-br-none' :
                'bg-gray-100 mr-auto rounded-bl-none';
        },
        createdTipClasses() {
            return this.message.sender === ChatRole.User ? 'text-blue-400' : 'text-gray-400';
        },
        messageTextWithoutPlaceholders() {
            const converter = new showdown.Converter();
            return converter.makeHtml(
                this.message.text.replace(/<SUGGEST_APARTMENT>([0-9]*)<\/SUGGEST_APARTMENT>/g, '')
                    .replace(/<APARTMENT_APPLICATION>(.*)<\/APARTMENT_APPLICATION>/g, '')
            );
        },
        apartmentIds() {
            const ids = [];
            const regex = /<SUGGEST_APARTMENT>([0-9]*)<\/SUGGEST_APARTMENT>/g;
            let match;

            while ((match = regex.exec(this.message.text)) !== null) {
                ids.push(match[1]);
            }

            return ids;
        }
    }
})
</script>

<template>
    <div :class="messageClasses" class="border px-4 pt-2 pb-6 relative rounded-lg text-gray-700 min-w-32">
        <div v-html="messageTextWithoutPlaceholders"></div>
        <template v-for="id in apartmentIds">
            <suggest-apartment-cart :id="id"/>
        </template>
        <span :class="createdTipClasses" class="absolute right-2 bottom-1 text-xs text-gray-400">
            {{ dayjs(message.createdAt).format('HH:mm DD.MM.YYYY') }}
        </span>
    </div>
</template>
