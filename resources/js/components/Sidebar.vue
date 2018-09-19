<template>
<v-navigation-drawer
  app
  v-model="drawer"
  fixed
  clipped
>
  <v-toolbar flat dense>
    <v-toolbar-title>{{ $t('message.menu') }}</v-toolbar-title>
    <v-spacer />
    <v-btn flat icon ml-auto @click.native="$store.dispatch('layout/sidebarToggle')"><v-icon>clear</v-icon></v-btn>
  </v-toolbar>

  <v-list dense>

    <v-list-tile>
      <v-list-tile-content>
        <locale-dropdown />
      </v-list-tile-content>
    </v-list-tile>

    <v-divider dark class="my-3" />

    <v-list-tile :to="{name:'home'}" light exact>
      <v-list-tile-action>
        <v-icon>home</v-icon>
      </v-list-tile-action>
      <v-list-tile-content>
        {{ $t('message.home') }}
      </v-list-tile-content>
    </v-list-tile>
  </v-list>
</v-navigation-drawer>
</template>
<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data () {
    return {
      drawer: false,
    }
  },

  computed: mapGetters({
    user: 'auth/user',
    sidebarActive: 'layout/sidebarActive',
  }),

  watch: {
    sidebarActive(to) {
      this.drawer = to
    }
  },
}
</script>
