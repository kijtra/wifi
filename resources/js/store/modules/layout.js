import * as types from '../mutation-types'

// state
export const state = {
  sidebarActive: false,
}

// getters
export const getters = {
  sidebarActive: state => state.sidebarActive,
}

// mutations
export const mutations = {
  [types.SIDEBAR_TOGGLE] (state) {
    state.sidebarActive = !state.sidebarActive
  },
}

// actions
export const actions = {
  sidebarToggle ({ commit }) {
    commit(types.SIDEBAR_TOGGLE)
  },
}
