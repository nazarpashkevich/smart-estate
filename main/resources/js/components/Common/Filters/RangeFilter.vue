<script lang="ts">
import { defineComponent } from 'vue'
import SelectInput from "@/components/SelectInput.vue";

export default defineComponent({
    name: "RangeFilter",
    components: { SelectInput },
    emits: ['update:from', 'update:to'],
    props: {
        min: {
            type: Number,
            default: 1,
        },
        max: {
            type: Number,
            default: 100000,
        },
        step: {
            type: Number,
            default: 25000,
        },
        path: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        from: {
            required: true,
        },
        to: {
            required: true,
        }
    },
    setup(props) {
        const countOptions = Math.ceil((props.max - props.min) / props.step) + 1;

        const options = Array.from(Array(countOptions).keys()).map((value: number) => {
                let item = props.step * value;
                return { key: item, value: item }
            }
        );

        return { options };
    }
})
</script>

<template>
    <label class="mb-2 text-sm text-gray-600" for="">{{ title }}</label>
    <div class="flex gap-6 w-full">
        <select-input
            :model-value="from"
            :options="options"
            :with-empty="true"
            class="flex-1"
            @update:model-value="(e) => this.$emit('update:from', e)"
        />
        <span class="my-auto">-></span>
        <select-input
            :model-value="to"
            :options="options.map(a => {return {...a}})"
            :with-empty="true"
            class="flex-1"
            @update:model-value="(e) => this.$emit('update:to', e)"
        />
    </div>
</template>
