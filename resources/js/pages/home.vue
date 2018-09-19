<template>
<div class="map--wrapper">
  <GmapMap
      :center="defaultPosition"
      :zoom="defaultZoom"
      class="map--canvas"
      ref="map"
    >
    <gmap-custom-marker
      :marker="defaultPosition"
      class="">
      >
        <v-icon>transfer_within_a_station</v-icon>
    </gmap-custom-marker>
  </GmapMap>
</div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

  data() {
    return {
      map: null
    }
  },

  computed: mapGetters({
    defaultPosition: 'map/defaultPosition',
    defaultZoom: 'map/defaultZoom',
    center: 'map/center',
    effectiveBoundsPadding: 'map/effectiveBoundsPadding',
  }),

  mounted () {
    this.$refs.map.$mapPromise.then(map => {
      this.map = map

      const firstIdle = map.addListener('idle', () => {
        this.onLoaded(map)
        google.maps.event.removeListener(firstIdle);
      })

      map.addListener('idle', () => {
        this.onIdle(map)
      })

      map.addListener('zoom_changed', () => {
        this.onZoomChanged(map)
      })

      map.addListener('dragend', () => {
        this.onDragEnd(map)
      })

      this.$helper.onWindowResize(e => {
        google.maps.event.trigger(this.map, 'resize')
        this.onResize(map)
      }, 200)
    })
  },

  methods: {
    onLoaded(map) {
      console.log('onLoaded')

      let w = map.getDiv().offsetWidth
      let h = map.getDiv().offsetHeight
      let bounds2 = this.padBounds(map, {
        top: h/2, left: w/2, right: w/2, bottom: h/2,
      }, '#FF0000')
      console.log(bounds2)
    },

    onIdle(map) {
      console.log('onIdle')

      let bounds = this.padBounds(map, this.effectiveBoundsPadding)
      this.$store.dispatch('map/setEffectiveBounds', bounds)
    },

    onZoomChanged(map) {
      console.log('onZoomChanged')


    },

    onDragEnd(map) {
      console.log('onDragEnd')

      let bounds = this.padBounds(map, this.effectiveBoundsPadding, '#666')
      this.$store.dispatch('map/setEffectiveBounds', bounds)
    },

    onResize(map) {
      console.log('onResize')
    },

    padBounds(map, padding, debugColor) {
      let bounds = map.getBounds();
      let scale = Math.pow(2, map.getZoom());
      let proj = map.getProjection();
      if (!proj) {
        return bounds;
      }

      if ('number' === typeof padding) {
        padding = {top: padding, left: padding, right: padding, bottom: padding}
      }

      let sw = proj.fromLatLngToPoint(bounds.getSouthWest());
      let ne = proj.fromLatLngToPoint(bounds.getNorthEast());
      sw = new google.maps.Point(
        ((sw.x * scale) + padding.left) / scale,
        ((sw.y * scale) - padding.bottom) / scale
      );
      ne = new google.maps.Point(
        ((ne.x * scale) - padding.right) / scale,
        ((ne.y * scale) + padding.top) / scale
      );
      var rect = new google.maps.LatLngBounds(
        proj.fromPointToLatLng(sw),
        proj.fromPointToLatLng(ne)
      );

      // // Debug: show rectangle
      if (debugColor) {
        if (!this.__gmapPadBoundsDebug) {
          this.__gmapPadBoundsDebug = {};
        }
        if (this.__gmapPadBoundsDebug[debugColor]) {
          this.__gmapPadBoundsDebug[debugColor].setMap(null);
        }
        this.__gmapPadBoundsDebug[debugColor] = new google.maps.Rectangle({
          bounds: rect,
          map: map,
          strokeOpacity: 0.3,
          strokeWeight: 1,
          fillOpacity: 0.1,
          fillColor: debugColor,
        });
      }

      return rect;
    }
  }
}
</script>
