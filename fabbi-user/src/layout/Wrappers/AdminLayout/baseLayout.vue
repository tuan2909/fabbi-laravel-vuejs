<template>
  <div class="wrapper">
    <Sidebar/>

    <Navbar/>

    <div class="content-page">
      <div class="container-fluid">
        <slot/>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from "../../Components/User/Sidebar";
import Navbar from "../../Components/User/Navbar";

export default {
  components: {Navbar, Sidebar}
};
</script>

<style scoped></style>