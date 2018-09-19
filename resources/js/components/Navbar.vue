<template>
<v-toolbar app dense clipped-left flat>
  <v-toolbar-side-icon @click.native="$store.dispatch('layout/sidebarToggle')" />

  <router-link :to="{name:'home'}" class="title">{{appName}}</router-link>

  <v-spacer></v-spacer>

  <navbar-user />
</v-toolbar>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'
import NavbarUser from './NavbarUser'

export default {
  components: {
    NavbarUser
  },

  computed: mapGetters({
    appName: 'translate/appName',
    user: 'auth/user',
  }),
}
</script>
