<template>
<v-app>
  <loading ref="loading"/>
  <sidebar />
  <navbar />
  <v-content>
    <router-view></router-view>
  </v-content>
</v-app>
</template>

<script>
import { mapGetters } from 'vuex'
import Loading from './Loading'
import Navbar from './Navbar'
import Sidebar from './Sidebar'

export default {
  el: '#app',

  components: {
    Loading,
    Navbar,
    Sidebar
  },

  metaInfo () {
    return {
      title: this.appName,
      titleTemplate (value) {
        if (!value || value === this.appName) {
          return value
        } else {
          return `${value} - ${this.appName}`
        }
      }
    }
  },

  computed: mapGetters({
    appName: 'translate/appName'
  }),

  mounted () {
    this.$loading = this.$refs.loading
  },
}
</script>
