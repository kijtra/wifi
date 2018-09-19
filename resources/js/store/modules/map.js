import * as types from '../mutation-types'

// state
export const state = {
  defaultPosition: {
    lat: window.config.mapDefaultPosition.lat,
    lng: window.config.mapDefaultPosition.lon
  },
  defaultZoom: 15,
  center: null,
  effectiveBoundsPadding: 20,
  effectiveBounds: null,
}

// getters
export const getters = {
  defaultPosition: state => state.defaultPosition,
  defaultZoom: state => state.defaultZoom,
  center: state => state.center,
  effectiveBoundsPadding: state => state.effectiveBoundsPadding,
  effectiveBounds: state => state.effectiveBounds,
}

// mutations
export const mutations = {
  [types.SET_MAP_CENTER] (state, { center }) {
    state.center = center
  },

  [types.SET_MAP_EFFECTIVE_BOUNDS] (state, { bounds }) {
    state.effectiveBounds = bounds
  },
}

// actions
export const actions = {
  setCenter ({ commit }, { center }) {
    commit(types.SET_MAP_CENTER, { center })
  },

  setEffectiveBounds ({ commit }, { bounds }) {
    commit(types.SET_MAP_EFFECTIVE_BOUNDS, { bounds })
  },
}
