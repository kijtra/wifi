<template>
<v-navigation-drawer
  app
  v-model="drawer"
  fixed
  clipped
>
  <v-toolbar flat dense>
    <v-toolbar-title>Menu</v-toolbar-title>
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
        {{ $t('home') }}
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

      items: [
        { icon: 'home', text: this.$t('Home') },
        // { icon: 'touch_app', text: 'Reminders' },
        // { divider: true },
        // { heading: 'Labels' },
        // { icon: 'add', text: 'Create new label' },
        // { divider: true },
        // { icon: 'archive', text: 'Archive' },
        // { icon: 'delete', text: 'Trash' },
        // { divider: true },
        // { icon: 'settings', text: 'Settings' },
        // { icon: 'chat_bubble', text: 'Trash' },
        // { icon: 'help', text: 'Help' },
        // { icon: 'phonelink', text: 'App downloads' },
        // { icon: 'keyboard', text: 'Keyboard shortcuts' }
      ]
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
