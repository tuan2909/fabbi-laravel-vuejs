<template>
  <section class="login-content">
    <div class="container h-100">
      <div class="row align-items-center justify-content-center h-100">
        <div class="col-12">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <h2 class="mb-2">Sign In</h2>
              <p>To Keep connected with us please login with your personal info.</p>
              <ValidationObserver v-slot="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(handleLogin)">
                  <b-form-group
                      id="input-group-1"
                      label="Email address:"
                      label-for="input-1"
                  >
                    <ValidationProvider v-slot="{errors}" name="email" rules="required|email">
                      <b-form-input
                          id="input-1"
                          v-model="loginForm.email"
                          type="email"
                          placeholder="Enter email"
                      ></b-form-input>
                      <p class="text-danger">{{ errors[0] }}</p>
                      <span
                          v-if="messageErrorResponse.email"
                          class="d-block text-danger my-0">{{ messageErrorResponse.email[0] }}</span>
                    </ValidationProvider>
                  </b-form-group>
                  <b-form-group
                      id="input-group-2"
                      label="Password:"
                      label-for="input-2"
                  >
                    <ValidationProvider v-slot="{errors}" name="password" rules="required|min:8|max:20">
                      <b-form-input
                          id="input-2"
                          v-model="loginForm.password"
                          type="password"
                          placeholder="Enter password"
                      ></b-form-input>
                      <p class="text-danger">{{ errors[0] }}</p>
                      <span
                          v-if="messageErrorResponse.password"
                          class="d-block text-danger my-0">{{ messageErrorResponse.password[0] }}</span>
                    </ValidationProvider>
                  </b-form-group>
                  <b-button type="submit" variant="primary" class="mr-3">Sign In</b-button>
                </b-form>
              </ValidationObserver>

              <span>Don't have account? Sign up <router-link :to="{path:'/sign-up'}"
                                                             class="">here.</router-link></span>
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
    messageErrorResponse: '',
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
        this.messageErrorResponse = error.response.data.errors;
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