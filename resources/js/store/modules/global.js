import Cookies from 'js-cookie'
import * as types from '../mutation-types'

const { appName, locale, locales } = window.config

// state
export const state = {
  locale: Cookies.get('locale') || locale,
  locales: locales,
  appName: appName['en'],
}

// getters
export const getters = {
  locale: state => state.locale,
  locales: state => state.locales,
  appName: state => (appName[state.locale] ? appName[state.locale] : appName['en']),
}

// mutations
export const mutations = {
  [types.SET_APP_NAME] (state, { locale }) {
    state.appName = appName[locale]
  },

  [types.SET_LOCALE] (state, { locale }) {
    state.locale = locale
  }
}

// actions
export const actions = {
  setLocale ({ commit }, { locale }) {
    commit(types.SET_LOCALE, { locale })

    if (appName[locale]) {
      commit(types.SET_APP_NAME, { locale })
    }

    Cookies.set('locale', locale, { expires: 365 })
  }
}
