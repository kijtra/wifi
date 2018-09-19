
// state
export const state = {
  ...window.config.translate
}

// getters
export const getters = {
  appName: state => window.config.appName,
}
