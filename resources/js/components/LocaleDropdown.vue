<template>
  <v-select
    :items="langs"
    v-model="lang"
    :label="$t('Language')"
    prepend-icon="translate"
    single-line
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
    locale: 'lang/locale',
    locales: 'lang/locales'
  }),

  watch: {
    lang(to, from) {
      if (from && to) {
        this.setLocale(to)
      }
    }
  },

  created() {
    this.lang = this.locale
    Object.keys(this.locales).forEach(key => {
      this.langs.push({
        value: key,
        text: this.locales[key],
      })
    })
    console.log(this.langs,this.locales);
  },

  methods: {
    setLocale (locale) {
      if (this.$i18n.locale !== locale) {
        loadMessages(locale)

        this.$store.dispatch('lang/setLocale', { locale })
      }
    }
  }
}
</script>
