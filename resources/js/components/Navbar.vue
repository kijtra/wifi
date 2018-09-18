<template>
<v-toolbar app dense clipped-left flat>
  <v-toolbar-side-icon @click.native="$store.dispatch('layout/sidebarToggle')" />

  <router-link :to="{name:'home'}" class="title">{{$t('app_name')}}</router-link>

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

  data () {
    return {
      items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' }
      ]
    }
  },

  computed: mapGetters({
    user: 'auth/user',
    sidebarActive: 'layout/sidebarActive',
  }),

  watch: {

  },

  created() {
    this.lang = this.locale
  },

  methods: {
    handleSelect(key, keyPath) {
        console.log(key, keyPath);
      },
    setLocale (locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale)

        this.$store.dispatch('lang/setLocale', { locale })
      }
    },

    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
