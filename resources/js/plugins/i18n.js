import Vue from 'vue'
import store from '~/store'
import VueI18n from 'vue-i18n'
import Messages from '../vue-i18n-locales.generated'

Vue.use(VueI18n)

const i18n = new VueI18n({
  locale: 'ja',
  fallbackLocale: 'en',
  messages: Messages
})

export default i18n
