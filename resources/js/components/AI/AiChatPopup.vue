<script lang="ts">
import AiChatMessage from '@/components/AI/AiChatMessage.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import SecondaryButton from '@/components/SecondaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { ChatMessage } from '@/contracts/ai-chat';
import { ChatRole } from '@/enums/ai-chat';
import AIService from '@/services/AIService';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, defineComponent, ref } from 'vue';

const aiService = new AIService();

export default defineComponent({
  name: 'AiChatPopup',
  components: {
    SecondaryButton,
    Link,
    AiChatMessage,
    PrimaryButton,
    TextInput,
  },
  data: () => ({
    message: '',
    loading: false,
    history: [] as ChatMessage[],
  }),
  emits: ['close'],
  async mounted() {
    await this.init();
  },
  methods: {
    async init() {
      const messages = await new AIService().history();
      if (Array.isArray(messages)) {
        this.history.push(...messages);
        await this.$nextTick(() => {
          setTimeout(this.scrollToEnd, 4000);
        });
      } else {
        await this.initChat();
      }
    },
    async sendMessage() {
      const message = this.message;
      this.history.push({
        id: 0,
        text: message,
        role: ChatRole.User,
        createdAt: new Date(),
      });
      this.message = '';
      this.loading = true;

      const stream = setInterval(() => {
        if (!this.loading) {
          clearInterval(stream);
        } else {
          this.scrollToEnd();
        }
      }, 1000);

      const answer = ref('');
      this.history.push({
        id: 0,
        text: answer.value,
        role: ChatRole.Assistant,
        createdAt: new Date(),
      });
      await aiService.send(
        message,
        (message) => (answer.value = answer.value + message),
      );
      this.loading = false;
    },
    scrollToEnd() {
      const el = this.$refs.messagesBlock as HTMLElement;
      if (el) {
        el.scrollTo({
          top: el.scrollHeight - el.clientHeight,
          behavior: 'smooth',
        });
      }
    },
    async initChat() {
      this.history.push({
        id: 0,
        text: await aiService.getInitMessage(),
        role: ChatRole.Assistant,
        createdAt: new Date(),
      });
    },
    async deleteChat() {
      await aiService.deleteChat();
      await this.init();
    },
  },
  setup() {
    const page = usePage();

    return {
      user: computed(() => page.props.auth.user),
    };
  },
});
</script>

<template>
  <div
    class="fixed border border-slate-300 rounded-xl bg-white right-12 bottom-6 w-96 flex flex-col z-[9999]"
  >
    <div class="bg-gray-300 px-6 py-3 items-center rounded-t-xl flex relative">
      <img alt="" class="mr-6 w-10" src="/images/chat/avatar.png" />
      <p class="text-md text-blue-900 font-semibold">AI Bot</p>
      <span class="text-xs text-gray-500 ml-4">online</span>
      <span class="cursor-pointer ml-auto" v-on:click="$emit('close')">
        <svg
          height="20px"
          viewBox="0 0 50 50"
          width="20px"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"
          />
        </svg>
      </span>
    </div>
    <template v-if="!user">
      <div class="flex h-96">
        <div class="m-auto text-center flex flex-col gap-2 font-medium">
          You have to
          <Link v-if="!user" :href="route('login')">
            <secondary-button>Login</secondary-button>
          </Link>
        </div>
      </div>
    </template>
    <template v-else>
      <div
        ref="messagesBlock"
        class="bg-white h-96 px-6 py-3 flex flex-col gap-4 overflow-y-scroll"
      >
        <template v-for="message in history">
          <ai-chat-message v-if="message.text !== ''" :message="message" />
        </template>
        <div
          v-if="loading"
          class="border border-slate-300 px-4 pt-2 pb-6 relative rounded-lg text-gray-700 min-w-32 bg-gray-100 mr-auto rounded-bl-none h-4 flex"
        >
          <div class="message-loader m-auto"></div>
        </div>
      </div>
      <div class="border-t border-slate-300 rounded-b-xl py-3 px-4 flex gap-4">
        <TextInput
          v-model="message"
          :disabled="loading"
          class="w-full px-4 py-2"
          placeholder="Type your message"
          v-on:keyup.enter="sendMessage"
        />
        <template v-if="!loading">
          <primary-button class="ml-auto" v-on:click="sendMessage"
            >Send
          </primary-button>
          <span
            v-if="history.length > 0"
            class="ml-auto my-auto cursor-pointer"
            v-on:click="deleteChat"
          >
            <svg
              height="24px"
              viewBox="0 0 24 24"
              width="24px"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"
              />
            </svg>
          </span>
        </template>
        <PrimaryButton v-else class="ml-auto loader"></PrimaryButton>
      </div>
    </template>
  </div>
</template>

<style>
.loader {
  aspect-ratio: 1;
  border-radius: 50%;
  border: 8px solid;
  border-color: #ffffff #0000;
  animation: l1 5s infinite;
}

@keyframes l1 {
  to {
    transform: rotate(0.5turn);
  }
}

.message-loader {
  width: 10px;
  aspect-ratio: 1;
  position: relative;
}

.message-loader::before,
.message-loader::after {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: #000;
}

.message-loader::before {
  box-shadow: -25px 0;
  animation: l8-1 1s infinite linear;
}

.message-loader::after {
  transform: rotate(0deg) translateX(25px);
  animation: l8-2 1s infinite linear;
}

@keyframes l8-1 {
  100% {
    transform: translateX(25px);
  }
}

@keyframes l8-2 {
  100% {
    transform: rotate(-180deg) translateX(25px);
  }
}
</style>
