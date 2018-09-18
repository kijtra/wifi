<template>
<div>
    map
    {{$t('message.home')}}
</div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

  metaInfo () {
    return {
      title: this.$t('message.home'),
    }
  },

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
