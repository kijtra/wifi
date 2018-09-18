import Vue from 'vue'
import store from '~/store'
import VueI18n from 'vue-i18n'
import Messages from '../vue-i18n-locales.generated'

Vue.use(VueI18n)

const _messages = {
  en: {
    message: {
      home: 'hello world'
    }
  },
  ja: {
    message: {
      home: 'こんにちは、世界'
    }
  }
}

const i18n = new VueI18n({
  locale: 'ja',
  _messages
})

// Object.keys(Messages).forEach(lang => {
//   Vue.i18n.add(lang, Messages[lang]);
// })

/**
 * @param {String} locale
 */
export async function loadMessages (locale) {
  // if (Messages[locale]) {
  //   i18n.setLocaleMessage(locale, Messages[locale])
  // } else {
  //   i18n.setLocaleMessage(locale, Messages['en'])
  // }

  // if (i18n.locale !== locale) {
  //   i18n.locale = locale
  // }
}

;(async function () {
  await loadMessages(store.getters['lang/locale'])
})()

export default i18n
