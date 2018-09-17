<template>
  <div id="app">
    <loading ref="loading"/>


    <navbar></navbar>
    <sidebar></sidebar>

      <div class="footer-sidebar" slot="footer">
        <vs-button vs-icon="reply" vs-color="danger" vs-type="flat">log out</vs-button>
        <vs-button vs-icon="settings" vs-color="primary" vs-type="border"></vs-button>
      </div>

    </vs-sidebar>

    <transition name="page" mode="out-in">
      <slot>
        <router-view/>
      </slot>
    </transition>
  </div>
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
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },
}
</script>
