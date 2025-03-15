<script lang="ts">
import DangerButton from '@/components/DangerButton.vue';
import SuccessIcon from '@/components/Icons/SuccessIcon.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import Modal from '@/components/Modal.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import SecondaryButton from '@/components/SecondaryButton.vue';
import TextArea from '@/components/TextArea.vue';
import TextInput from '@/components/TextInput.vue';
import { EstateItem } from '@/contracts/estate-item';
import { useForm, usePage } from '@inertiajs/vue3';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'BuyForm',
  components: {
    SuccessIcon,
    PrimaryButton,
    TextArea,
    InputError,
    InputLabel,
    DangerButton,
    SecondaryButton,
    TextInput,
    Modal,
  },
  data: () => ({
    submitted: false,
  }),
  props: {
    item: Object as EstateItem,
  },
  methods: {
    submit() {
      this.form.post(route('personal.application.store'), {
        onSuccess: () => (this.submitted = true),
        preserveScroll: true,
      });
    },
  },
  setup(props) {
    const user = usePage().props.auth.user;

    const form = useForm({
      name: user.name,
      phone: '',
      suggestedPrice: props.item.price.value,
      estateItemId: props.item.id,
    });

    return { form };
  },
});
</script>

<template>
  <modal :show="true" @close="$emit('close')">
    <div class="p-6">
      <h2 class="text-lg font-medium text-gray-900 mb-6">
        Buying estate application form
      </h2>
      <div v-if="submitted" class="flex px-12 py-8">
        <div class="m-auto">
          <success-icon />
          <p class="text-center text-xl text-gray-700 mt-6 transition">
            Gotcha!
          </p>
        </div>
      </div>
      <div v-else class="flex flex-col gap-6">
        <div>
          <input-label for="name" value="Your name" />
          <text-input
            v-model="form.name"
            autocomplete="name"
            autofocus
            class="mt-1 block w-full"
            required
            type="text"
          />
          <input-error :message="form.errors.name" class="mt-2" />
        </div>
        <div>
          <input-label for="phone" value="Your phone" />
          <text-input
            v-model="form.phone"
            autocomplete="phone"
            autofocus
            class="mt-1 block w-full"
            required
            type="tel"
          />
          <input-error :message="form.errors.phone" class="mt-2" />
        </div>
        <div class="mb-4">
          <input-label for="suggested_price" value="Your suggested price" />
          <text-input
            v-model="form.suggestedPrice"
            autocomplete="suggested_price"
            autofocus
            class="mt-1 block w-full"
            required
            type="number"
          />
          <input-error :message="form.errors.suggestedPrice" class="mt-2" />
        </div>
        <div class="flex">
          <primary-button class="ml-auto" v-on:click="submit"
            >Submit</primary-button
          >
        </div>
      </div>
    </div>
  </modal>
</template>
