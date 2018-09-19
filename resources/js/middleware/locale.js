import store from '~/store'
import i18n from '~/plugins/i18n'

export default async (to, from, next) => {
  i18n.locale = store.getters['global/locale']
  next()
}
