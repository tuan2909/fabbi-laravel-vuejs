<template>
  <div class="iq-sidebar sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between text-center">
      <router-link to="/" class="header-logo">
        <h5 class="">COVID MANAGE</h5>
      </router-link>
      <!--        <img src="" class="img-fluid rounded-normal light-logo"-->
      <!--             alt="logo">-->
      <!--        <img src=""-->
      <!--             class="img-fluid rounded-normal darkmode-logo" alt="logo">-->
      <div class="iq-menu-bt-sidebar">
        <i class="las la-bars wrapper-menu"></i>
      </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
      <nav class="iq-sidebar-menu">
        <ul id="iq-sidebar-toggle" class="iq-menu">
          <li class="">
            <router-link to="/">Home</router-link>
          </li>
          <li class="">
            <router-link to="/cities">Manage Cities</router-link>
          </li>
          <li class="">
            <router-link to="/type_patients">Manage Type Patient</router-link>
          </li>
          <li class=" ">
            <a href="javascript:;" @click="logout">Logout</a>
          </li>
        </ul>
      </nav>
      <div class="p-3"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Sidebar",
  methods: {
    async logout() {
      await this.$store.dispatch('user/logout')
      await this.$router.push(`/login`)
    }
  }
}
</script>

<style scoped>

</style>