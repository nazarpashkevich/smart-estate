<script lang="ts">
import { defineComponent } from 'vue'
import InputError from "@/components/InputError.vue";
import TextInput from "@/components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/components/PrimaryButton.vue";
import InputLabel from "@/components/InputLabel.vue";
import { EstateItem } from "@/contracts/estate-item";
import ImageInput from "@/components/ImageInput.vue";
import TextArea from "@/components/TextArea.vue";
import Checkbox from "@/components/Checkbox.vue";
import { EstateItemType } from "@/enums/estate-item";
import SelectInput from "@/components/SelectInput.vue";
import MapInput from "@/components/MapInput.vue";

export default defineComponent({
    name: "EstateItemForm",
    components: {
        MapInput,
        SelectInput,
        Checkbox,
        TextArea,
        ImageInput,
        InputLabel,
        PrimaryButton,
        Link,
        TextInput,
        InputError
    },
    props: {
        item: {
            type: null | Object as EstateItem,
            default: null
        }
    },
    methods: {
        save(e) {
            console.log(this.form);
        }
    },
    setup(props) {
        const user = usePage().props.auth.user;

        const form = useForm({
            preview: props.item?.preview ?? '',
            description: props.item?.description ?? '',
            rooms: props.item?.rooms ?? 1,
            floor: props.item?.floor ?? 1,
            type: props.item?.type ?? EstateItemType.Apartment,
            yearOfBuild: props.item?.yearOfBuild,
            square: props.item?.square ?? 0,
            bedrooms: props.item?.bedrooms ?? 1,
            hasParking: props.item?.hasParking ?? false,
            lat: props.item?.lat ?? null,
            lng: props.item?.lng ?? null,
            price: props.item?.price ?? null,
            features: props.item?.features ?? [],
        });

        const types = Object.keys(EstateItemType).map((value: string) => ({ key: EstateItemType[value], value }));

        // create array from 1 to n
        const maxRooms = 6;
        const rooms = Array.from(Array(maxRooms).keys()).map((value: number) => {
                let item = value + 1;
                if (item === maxRooms) {
                    item += '+';
                }
                return { key: item, value: item }
            }
        );

        // create array from 1 to n
        const maxBedrooms = 4;
        const bedrooms = Array.from(Array(maxBedrooms).keys()).map((value: number) => {
                let item = value + 1;
                if (item === maxRooms) {
                    item += '+';
                }
                return { key: item, value: item }
            }
        );

        // create array from 1 to n
        const maxYear = 1960;
        const countYearOptions = Math.ceil((new Date().getFullYear() - maxYear) / 10);
        const yearsOfBuild = Array.from(Array(countYearOptions).keys()).map((value: number) => {
                let item = maxYear + 10 * value;

                return { key: item, value: `${item}'s` }
            }
        );

        return {
            form,
            user,
            types,
            rooms,
            bedrooms,
            yearsOfBuild
        };
    }
})
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ item ? 'Edit' : 'Add' }} Estate item
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form class="mt-6 space-y-6" @submit.prevent="save">
            <div>
                <input-label for="preview" value="Preview"/>
                <image-input
                    id="preview"
                    :model="form.preview"
                    class="mt-1 block w-full"
                    required
                />
                <input-error :message="form.errors.preview" class="mt-2"/>
            </div>

            <div>
                <input-label for="description" value="Description"/>
                <text-area
                    id="description"
                    v-model="form.description"
                    autocomplete="Description about your property"
                    autofocus
                    class="mt-1 block w-full"
                    required
                />
                <input-error :message="form.errors.description" class="mt-2"/>
            </div>

            <div class="flex gap-8">
                <div class="flex-1">
                    <input-label for="type" value="Type"/>
                    <select-input
                        id="type"
                        v-model="form.type"
                        :options="types"
                        autocomplete="type"
                        class="mt-1"
                    />
                    <input-error :message="form.errors.type" class="mt-2"/>
                </div>
                <div class="flex-1">
                    <input-label for="rooms" value="Rooms"/>
                    <select-input
                        id="rooms"
                        v-model="form.rooms"
                        :options="rooms"
                        class="mt-1"
                    />
                    <input-error :message="form.errors.rooms" class="mt-2"/>
                </div>

                <div class="flex-1">
                    <input-label for="square" value="Square (m2)"/>
                    <text-input
                        id="square"
                        v-model.number="form.square"
                        autocomplete="square"
                        autofocus
                        class="mt-1 block w-full"
                        required
                        type="number"
                    />
                    <input-error :message="form.errors.square" class="mt-2"/>
                </div>

            </div>

            <div class="flex gap-8">
                <div class="flex-1">
                    <input-label for="bedrooms" value="Count of bedrooms"/>
                    <select-input
                        id="bedrooms"
                        v-model="form.bedrooms"
                        :options="bedrooms"
                        class="mt-1"
                    />
                    <input-error :message="form.errors.bedrooms" class="mt-2"/>
                </div>
                <div class="flex-1">
                    <!-- @todo To select -->
                    <input-label for="yearOfBuild" value="Year of building"/>
                    <select-input
                        id="yearOfBuild"
                        v-model="form.yearOfBuild"
                        :options="yearsOfBuild"
                        class="mt-1"
                    />
                    <input-error :message="form.errors.yearOfBuild" class="mt-2"/>
                </div>
                <div class="flex-1">
                    <input-label for="floor" value="Floor"/>
                    <text-input
                        id="floor"
                        v-model.number="form.floor"
                        autocomplete="floor"
                        autofocus
                        class="mt-1 block w-full"
                        required
                        type="number"
                    />
                    <input-error :message="form.errors.floor" class="mt-2"/>
                </div>
            </div>

            <div>
                <div class="block mt-4">
                    <label class="flex items-center">
                        <checkbox v-model:checked="form.hasParking" name="hasParking"/>
                        <span class="ms-2 text-sm text-gray-600">Has parking</span>
                    </label>
                </div>
                <input-error :message="form.errors.hasParking" class="mt-2"/>
            </div>

            <div>
                <map-input
                    :lat="form.lat"
                    :lng="form.lng"
                    @update:lat="(lat) => form.lat = lat"
                    @update:lng="(lng) => form.lng = lng"
                />
            </div>

            <div>
                <input-label for="price" value="Price"/>
                <text-input
                    id="price"
                    v-model.number="form.price"
                    autocomplete="price"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="number"
                />
                <input-error :message="form.errors.price" class="mt-2"/>
            </div>

            <div>List of features @todo</div>

            <div class="flex items-center gap-4">
                <primary-button :disabled="form.processing">Save</primary-button>
                <transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </transition>
            </div>
        </form>
    </section>
</template>
