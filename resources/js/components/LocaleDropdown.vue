<template>
  <v-select
    :items="langs"
    v-model="lang"
    :label="$t('message.languages')"
    prepend-icon="translate"
    single-line
    @change="select($event)"
  ></v-select>
</template>

<script>
import { mapGetters } from 'vuex'
import { loadMessages } from '~/plugins/i18n'

export default {
  name: 'locale-dropdown',

  data() {
    return {
      langs: [],
      lang: null
    }
  },

  computed: mapGetters({
    locale: 'global/locale',
    locales: 'global/locales'
  }),

  created() {
    this.lang = this.locale
    Object.values(this.locales).forEach(val => {
      this.langs.push({
        value: val.id,
        text: val.name,
      })
    })
  },

  methods: {
    select(locale) {
      window.location.href = window.config.locales[locale].url
    },
  }
}
</script>
