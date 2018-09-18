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
    const appName = this.$t('app_name')

    return {
      title: appName,
      titleTemplate (value) {
        if (value === appName) {
          return value
        } else {
          return `%s - ${appName}`
        }
      }
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },
}
</script>
