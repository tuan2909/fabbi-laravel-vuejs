<template>
  <div id="app">
    <component :is="layout">
      <router-view/>
    </component>
  </div>
</template>
<script>
const defaultLayout = "default";
export default {
  computed: {
    layout() {
      return `${this.$route.meta.layout}-layout` || `${defaultLayout} -layout`;
    },
  },
};
</script>
<style>
@import "assets/css/backend.min0ff5.css?v=1.0.2";
@import "assets/vendor/@fortawesome/fontawesome-free/css/all.min.css";
@import "assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css";
@import "assets/vendor/remixicon/fonts/remixicon.css";
</style>
