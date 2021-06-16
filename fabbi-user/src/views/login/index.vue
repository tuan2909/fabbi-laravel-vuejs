<template>
  <div class="row align-items-center">
    <div class="col-lg-6">
      <h2 class="mb-2">Sign In</h2>
      <p>To Keep connected with us please login with your personal info.</p>
      <form @submit.prevent="loginForm">
        <div class="row">
          <div class="col-lg-12">
            <div class="floating-label form-group">
              <input
                  v-model="loginForm.email"
                  class="floating-input form-control"
                  name="email" value="" autocomplete="email"
                  autofocus
                  type="email" placeholder=" ">
              <label>Email</label>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="floating-label form-group">
              <input class="floating-input form-control" name="password" v-model="loginForm.password"
                     type="password"
                     placeholder=" ">
              <label>Password</label>
            </div>
          </div>
        </div>
        <button @click.prevent="handleLogin" type="submit" class="btn btn-primary">Sign In</button>
      </form>
    </div>
    <div class="col-lg-6 mb-lg-0 mb-4 mt-lg-0 mt-4">
      <img src="/images/login/01.png" class="img-fluid w-80" alt="">
    </div>
  </div>
</template>

<script>
import router from "../../router";

export default {
  data: () => ({
    loginForm: {
      email: '',
      password: '',
    },
    redirect: undefined,
    errors: [],
    message: '',
  }),
  methods: {
    handleLogin() {
      this.$store.dispatch('user/login', this.loginForm)
          .then(() => {
            router.push({path: this.redirect || '/'})
          }).catch((error) => {
            console.log(error)
          })
    }
  }
}
</script>

<style scoped>

</style>