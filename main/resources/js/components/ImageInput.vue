<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
    name: 'ImageInput',
    props: {
        modelValue: {}
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
        const file = ref<File | null>(null);
        const imageUrl = ref<string | null>(null);

        if (props.modelValue) {
            imageUrl.value = props.modelValue;
        }
        const handleFileUpload = (event: Event) => {
            const target = event.target as HTMLInputElement;
            if (target.files && target.files.length > 0) {
                file.value = target.files[0];
                imageUrl.value = URL.createObjectURL(file.value);
                emit('update:modelValue', file.value);
            }
        };

        return {
            file,
            imageUrl,
            handleFileUpload
        };
    }
});
</script>

<template>
    <div class="flex items-center justify-center w-full">
        <label class="flex flex-col items-center justify-center w-full h-92 border-2 border-gray-300
        border-dashed rounded-lg cursor-pointer bg-gray-5 hover:bg-gray-100">
            <div v-if="!imageUrl" class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg aria-hidden="true" class="w-8 h-8 mb-4 text-gray-500"
                     fill="none" viewBox="0 0 20 16" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                    upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
            </div>
            <img v-else :src="imageUrl" alt="Uploaded Image" class="object-cover w-full h-full"/>
            <input id="dropzone-file" class="hidden" type="file" @change="handleFileUpload"/>
        </label>
    </div>
</template>
