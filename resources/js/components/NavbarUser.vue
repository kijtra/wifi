<template>
<v-menu
  v-model="menu"
  :close-on-content-click="false"
  offset-x
>
  <v-btn slot="activator" icon>
    <v-avatar v-if="user" size="36px">
      <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John">
    </v-avatar>
    <v-icon v-else>account_circle</v-icon>
  </v-btn>

  <v-card>
    <v-list>
      <v-list-tile avatar>
        <v-list-tile-avatar>
          <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John">
        </v-list-tile-avatar>

        <v-list-tile-content>
          <v-list-tile-title>John Leider</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>

    <v-divider></v-divider>

    <v-list>
      <v-list-tile avatar @click="logout()">
        <v-list-tile-avatar>
          <v-icon>exit_to_app</v-icon>
        </v-list-tile-avatar>
        <v-list-tile-content>
          {{ $t('message.logout') }}
        </v-list-tile-content>
      </v-list-tile>
    </v-list>

    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn flat icon @click="menu=false"><v-icon>cancel</v-icon></v-btn>
    </v-card-actions>
  </v-card>
</v-menu>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
  name: 'navbar-user',

  data() {
    return {
      menu: false,
    }
  },

  computed: mapGetters({
    user: 'auth/user',
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>
