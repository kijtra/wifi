<template>
  <vs-navbar v-model="activeItem" class="nabarx">
    <vs-button
      vs-type="flat"
      vs-radius="50%"
      vs-icon="menu"
      @click="$store.dispatch('layout/sidebarToggle')"></vs-button>

    <vs-navbar-title>
      Hello world
    </vs-navbar-title>

    <vs-spacer></vs-spacer>

    <vs-dropdown vs-trigger-click>
        <a class="a-icon" href.prevent>
          {{ locales[locale] }}
          <i class="material-icons">
            expand_more
          </i>
        </a>
        <vs-dropdown-menu>
          <vs-dropdown-item
            v-for="(value, key) in locales"
            :key="key"
            @click.prevent="setLocale(key)">
            {{ value }}
          </vs-dropdown-item>
        </vs-dropdown-menu>
      </vs-dropdown>

    <vs-navbar-item index="1">
      <a href="#">{{$t('home')}}</a>
    </vs-navbar-item>
    <vs-navbar-item index="2">
      <a href="#">Update</a>
    </vs-navbar-item>
  </vs-navbar>

  <!-- <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon"/>
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <locale-dropdown/>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark"
               href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
              {{ user.name }}
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
                <fa icon="cog" fixed-width/>
                {{ $t('settings') }}
              </router-link>

              <div class="dropdown-divider"/>
              <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width/>
                {{ $t('logout') }}
              </a>
            </div>
          </li>

          <template v-else>
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                {{ $t('login') }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                {{ $t('register') }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav> -->
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'

export default {
  data () {
    return {
      activeItem: 0,
      appName: window.config.appName
    }
  },

  computed: mapGetters({
    locale: 'lang/locale',
    locales: 'lang/locales',
    user: 'auth/user',
    sidebarActive: 'layout/sidebarActive',
  }),

  methods: {
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
