import * as types from '../mutation-types'
import Cookies from 'js-cookie'
import i18n from '~/plugins/i18n'

const { locale, locales } = window.config

// state
export const state = {
  locale: locale,
  locales: locales,
}

// getters
export const getters = {
  locale: state => state.locale,
  locales: state => state.locales,
}

// mutations
export const mutations = {
}

// actions
export const actions = {
}
