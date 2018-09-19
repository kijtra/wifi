<template>
<div>
    map
    {{$t('message.home')}}
</div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>
