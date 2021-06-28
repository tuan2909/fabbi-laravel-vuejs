<template>
  <div id="loading" v-if="loadingPage">
    <div id="loading-center">
    </div>
  </div>
</template>

<script>
export default {
  name: "LoadingPage",
  props: {
    isLoading: Boolean,
  },
  computed: {
    loadingPage() {
      return this.isLoading || false;
    }
  }
}
</script>

<style scoped>

</style>