<script lang="ts">
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'MapSection',
  computed: {},
  props: {
    lat: {
      type: Number,
      required: true,
    },
    lng: {
      type: Number,
      required: true,
    },
    zoom: {
      type: Number,
      default: 6,
    },
  },
  mounted() {
    const map = L.map('map').setView([this.lat, this.lng], this.zoom);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    L.marker([this.lat, this.lng]).addTo(map);
  },
});
</script>
<template>
  <div class="">
    <div id="map" class="h-96"></div>
  </div>
</template>
