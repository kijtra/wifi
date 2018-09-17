<template>
  <vs-sidebar
    parent="body"
    default-index="1"
    color="primary"
    class="sidebarx"
    spacer
    v-model="$store.state.layout.sidebarActive">

      <div class="header-sidebar" slot="header">
        <vs-avatar  size="70px" src="https://randomuser.me/api/portraits/men/85.jpg"/>

        <h4>
          My Name
          <vs-button vs-color="primary" vs-icon="more_horiz" vs-type="flat"></vs-button>
        </h4>

      </div>

      <vs-sidebar-item index="1" icon="question_answer">
        Dashboard
      </vs-sidebar-item>

      <vs-sidebar-item index="2" icon="gavel">
        History
      </vs-sidebar-item>

      <vs-divider icon="person" position="left">
        User
      </vs-divider>

      <vs-sidebar-item index="3" icon="verified_user">
        Configurations
      </vs-sidebar-item>
      <vs-sidebar-item index="4" icon="account_box">
        Perfile
      </vs-sidebar-item>
      <vs-sidebar-item index="5" >
        Card
      </vs-sidebar-item>
      </vs-sidebar>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
  computed: mapGetters({
    user: 'auth/user',
    sidebarActive: 'layout/sidebarActive',
  }),
}
</script>
