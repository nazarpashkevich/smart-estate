<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

const updatePassword = () => {
  form.put(route('password.update'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
    onError: () => {
      if (form.errors.password) {
        form.reset('password', 'password_confirmation');
        passwordInput.value?.focus();
      }
      if (form.errors.current_password) {
        form.reset('current_password');
        currentPasswordInput.value?.focus();
      }
    },
  });
};
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

      <p class="mt-1 text-sm text-gray-600">
        Ensure your account is using a long, random password to stay secure.
      </p>
    </header>

    <form class="mt-6 space-y-6" @submit.prevent="updatePassword">
      <div>
        <input-label for="current_password" value="Current Password" />

        <text-input
          id="current_password"
          ref="currentPasswordInput"
          v-model="form.current_password"
          autocomplete="current-password"
          class="mt-1 block w-full"
          type="password"
        />

        <input-error :message="form.errors.current_password" class="mt-2" />
      </div>

      <div>
        <input-label for="password" value="New Password" />

        <text-input
          id="password"
          ref="passwordInput"
          v-model="form.password"
          autocomplete="new-password"
          class="mt-1 block w-full"
          type="password"
        />

        <input-error :message="form.errors.password" class="mt-2" />
      </div>

      <div>
        <input-label for="password_confirmation" value="Confirm Password" />

        <text-input
          id="password_confirmation"
          v-model="form.password_confirmation"
          autocomplete="new-password"
          class="mt-1 block w-full"
          type="password"
        />

        <input-error
          :message="form.errors.password_confirmation"
          class="mt-2"
        />
      </div>

      <div class="flex items-center gap-4">
        <primary-button :disabled="form.processing">Save</primary-button>

        <transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
            Saved.
          </p>
        </transition>
      </div>
    </form>
  </section>
</template>
