<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  password: '',
});

const submit = () => {
  form.post(route('password.confirm'), {
    onFinish: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Confirm Password" />

    <div class="mb-4 text-sm text-gray-600">
      This is a secure area of the application. Please confirm your password
      before continuing.
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="password" value="Password" />
        <TextInput
          id="password"
          v-model="form.password"
          autocomplete="current-password"
          autofocus
          class="mt-1 block w-full"
          required
          type="password"
        />
        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <div class="flex justify-end mt-4">
        <PrimaryButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          class="ms-4"
        >
          Confirm
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
