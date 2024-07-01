<script lang="ts">
import { defineComponent } from 'vue';
import "leaflet/dist/leaflet.css"
import * as L from 'leaflet';

export default defineComponent({
    name: 'MapSection',
    computed: {},
    data: () => ({
        map: null,
    }),
    props: {
        lat: {
            type: Number,
            required: true
        },
        lng: {
            type: Number,
            required: true
        },
        zoom: {
            type: Number,
            default: 6
        },
    },
    mounted() {
        this.map = L.map('map').setView([this.lat, this.lng], this.zoom);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(this.map);

        L.marker([this.lat, this.lng]).addTo(this.map);
    },

});
</script>
<template>
    <div class="">
        <div id="map" class="h-96"></div>

    </div>
</template>
