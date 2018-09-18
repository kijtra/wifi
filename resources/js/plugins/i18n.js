import Vue from 'vue'
import store from '~/store'
import VueI18n from 'vue-i18n'

import enLocale from 'element-ui/lib/locale/lang/en'
import jaLocale from 'element-ui/lib/locale/lang/ja'

Vue.use(VueI18n)

const uiMessages = {
  en: {
    ...enLocale
  },
  ja: {
    ...jaLocale
  }
}

const i18n = new VueI18n({
  locale: 'en',
  messages: {}
})

/**
 * @param {String} locale
 */
export async function loadMessages (locale) {
  if (Object.keys(i18n.getLocaleMessage(locale)).length === 0) {
    const messages = await import(/* webpackChunkName: "lang-[request]" */ `~/lang/${locale}`)
    if (uiMessages[locale]) {
      i18n.setLocaleMessage(locale, {
        ...uiMessages[locale],
        ...messages
      })
    } else {
      i18n.setLocaleMessage(locale, messages)
    }
  }

  if (i18n.locale !== locale) {
    i18n.locale = locale
  }
}

;(async function () {
  await loadMessages(store.getters['lang/locale'])
})()

export default i18n
