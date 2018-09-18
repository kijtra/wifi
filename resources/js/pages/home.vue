<template>
<div>
    map
</div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

  metaInfo () {
    const appName = this.$t('app_name')

    return {
      title: appName,
    }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
