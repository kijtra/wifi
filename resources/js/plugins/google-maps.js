import Vue from 'vue'
import * as VueGoogleMaps from 'vue2-google-maps'
import GmapCustomMarker from 'vue2-gmap-custom-marker'

Vue.use(VueGoogleMaps, {
  load: {
    key: window.config.googleMapsApiKey,
    libraries: 'places',
  },

  //// If you intend to programmatically custom event listener code
  //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
  //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
  //// you might need to turn this on.
  // autobindAllEvents: false,

  //// If you want to manually install components, e.g.
  //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
  //// Vue.component('GmapMarker', GmapMarker)
  //// then disable the following:
  // installComponents: true,
})

Vue.component('gmap-custom-marker', GmapCustomMarker)
