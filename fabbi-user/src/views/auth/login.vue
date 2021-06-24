<template>
  <section class="login-content">
    <div class="container h-100">
      <div class="row align-items-center justify-content-center h-100">
        <div class="col-12">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <h2 class="mb-2">Sign In</h2>
              <p>To Keep connected with us please login with your personal info.</p>
              <b-form @submit.prevent="handleLogin">
                <b-form-group
                    id="input-group-1"
                    label="Email address:"
                    label-for="input-1"
                >
                  <b-form-input
                      id="input-1"
                      v-model="loginForm.email"
                      type="email"
                      placeholder="Enter email"
                      required
                  ></b-form-input>
                </b-form-group>
                <b-form-group
                    id="input-group-2"
                    label="Password:"
                    label-for="input-2"
                >
                  <b-form-input
                      id="input-2"
                      v-model="loginForm.password"
                      type="password"
                      placeholder="Enter password"
                      required
                  ></b-form-input>
                </b-form-group>
                <b-button type="submit" variant="primary">Sign In</b-button>
                <router-link to="/sign-up"></router-link>
              </b-form>
            </div>
            <div class="col-lg-6 mb-lg-0 mb-4 mt-lg-0 mt-4">
              <img
                  src="https://www.ashrae.org/image%20library/main%20nav/technical%20resources/covid_image_one-page-guides-300x600-01.png"
                  class="img-fluid w-80" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
            router.push({ path: this.redirect || '/' })
          }).catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>

<style scoped lang="css">
body {
  background: #B0BEC5 !important;
}
</style>