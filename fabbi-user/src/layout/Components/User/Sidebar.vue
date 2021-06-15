<template>
  <div class="iq-sidebar  sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
      <a href="" class="header-logo">
        <img src="" class="img-fluid rounded-normal light-logo"
             alt="logo">
        <img src=""
             class="img-fluid rounded-normal darkmode-logo" alt="logo">
      </a>
      <div class="iq-menu-bt-sidebar">
        <i class="las la-bars wrapper-menu"></i>
      </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
      <nav class="iq-sidebar-menu">
        <ul id="iq-sidebar-toggle" class="iq-menu">
          <li class=" ">
            <router-link to="/">Home</router-link>
          </li>
          <li class=" ">
            <router-link to="/about">About</router-link>
          </li>
        </ul>
      </nav>

      <div class="p-3"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Sidebar"
}
</script>

<style scoped>

</style>