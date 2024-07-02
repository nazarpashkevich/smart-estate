<script lang="ts">
import { defineComponent } from 'vue'
import { EstateApplication } from "@/contracts/estate-application";
import PrimaryButton from "@/components/PrimaryButton.vue";
import DangerButton from "@/components/DangerButton.vue";
import SecondaryButton from "@/components/SecondaryButton.vue";
import { EstateApplicationStatus } from "@/enums/estate-application";
import { useForm } from "@inertiajs/vue3";
import moment from "moment";

export default defineComponent({
    name: "ApplicationList",
    computed: {
        EstateApplicationStatus() {
            return EstateApplicationStatus
        }
    },
    components: { SecondaryButton, DangerButton, PrimaryButton },
    methods: {
        submitApplication(id: number, status: EstateApplicationStatus): void {
            this.form.transform((data) => ({
                ...data,
                status,
                _method: 'put'
            }));

            this.form.post(route('personal.application.update-status', id));
        },
        getStatusClass(status: EstateApplicationStatus): string {
            return status === EstateApplicationStatus.Approved ? 'bg-green-700'
                : status === EstateApplicationStatus.Rejected ? 'bg-red-700' : 'bg-blue-700'
        }
    },
    props: {
        items: {
            type: Array<EstateApplication>,
            required: true
        }
    },
    setup() {
        const form = useForm({
            status: null
        });

        return { form, moment };
    }
})
</script>

<template>


    <div class="relative shadow-md">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-6 pl-24 py-3" scope="col">#</th>
                <th class="px-6 py-3" scope="col">Apartment</th>
                <th class="px-6 py-3" scope="col">Created</th>
                <th class="px-6 py-3" scope="col">Client name</th>
                <th class="px-6 py-3" scope="col">Client phone</th>
                <th class="px-6 py-3" scope="col">Suggested price</th>
                <th class="px-6 py-3" scope="col">Status</th>
                <th class="px-6 pr-24 py-3 text-center" scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="item in items">
                <tr class="bg-white border-b">
                    <th class="px-6 pl-24 py-4 font-medium text-gray-900 whitespace-nowrap" scope="row">{{ item.id }}
                    </th>
                    <td class="px-6 py-4">
                        <Link :href="route('estate.show', item.estateItemId)" class="underline">Apartment</Link>
                    </td>
                    <td class="px-6 py-4">{{ moment(item.createdAt).format('LLL') }}</td>
                    <td class="px-6 py-4">{{ item.name }}</td>
                    <td class="px-6 py-4">{{ item.phone }}</td>
                    <td class="px-6 py-4">{{ item.suggestedPrice?.format }}</td>
                    <td class="px-6 py-4">
                        <span :class="getStatusClass(item.status)"
                              class="border rounded-lg px-3 py-1.5 text-white shadow-md text-sm">
                            {{ item.status }}
                        </span>
                    </td>
                    <td class="px-6 pr-24 py-4 text-right flex w-full space-around gap-4">
                        <template v-if="item.status === EstateApplicationStatus.New">
                            <secondary-button
                                class="mx-auto"
                                v-on:click="submitApplication(item.id, EstateApplicationStatus.Approved)"
                            >
                                Accept
                            </secondary-button>
                            <danger-button
                                class="mx-auto"
                                v-on:click="submitApplication(item.id, EstateApplicationStatus.Rejected)"
                            >
                                Decline
                            </danger-button>
                        </template>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
