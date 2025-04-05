<script lang="ts">
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'MapInput',
  computed: {},
  data: () => ({
    map: null as null | L.Map,
    marker: null as null | L.Marker,
  }),
  props: {
    lat: {
      type: Number,
      default: null,
    },
    lng: {
      type: Number,
      default: null,
    },
  },
  emits: ['update:lat', 'update:lng'],
  methods: {
    onMapClick(e: { latlng: L.LatLng }) {
      const coords = e.latlng;
      this.$emit('update:lat', coords.lat);
      this.$emit('update:lng', coords.lng);
      if (this.marker) {
        this.marker.setLatLng(coords);
        return;
      }

      if (this.map) {
        this.marker ??= L.marker(coords).addTo(this.map as L.Map);
      }
    },
  },
  mounted() {
    const mapCenter = { lat: 51.496091, lng: -0.137535 };

    if (this.lat && this.lng) {
      mapCenter.lat = this.lat;
      mapCenter.lng = this.lng;
    }

    if (this.map) {
      this.map = L.map('map').setView(mapCenter, 6);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution:
          '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      }).addTo(this.map as L.Map);

      this.map.on('click', this.onMapClick);

      if (this.lat && this.lng) {
        // add mark if it is editing
        this.onMapClick({ latlng: L.latLng(this.lat, this.lng) });
      }
    }
  },
});
</script>
<template>
  <div class="">
    <div id="map" class="h-96"></div>
  </div>
</template>
