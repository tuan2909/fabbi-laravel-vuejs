<template>
  <section class="login-content">
    <div class="container h-100">
      <div class="row align-items-center justify-content-center h-100">
        <div class="col-12">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <h2 class="mb-2">Sign Up</h2>
              <ValidationObserver v-slot="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(handleSignUp)">
                  <b-form-group
                      id="input-group-2"
                      label="Name:"
                      label-for="input-2"
                  >
                    <ValidationProvider v-slot="{errors}" name="name" rules="required|max:20">
                      <b-form-input
                          id="input-2"
                          v-model="signupForm.name"
                          type="text"
                          placeholder="Enter name"
                      ></b-form-input>
                      <p class="text-danger">{{ errors[0] }}</p>
                      <span
                          v-if="messageErrorResponse.name"
                          class="d-block text-danger my-0">{{ messageErrorResponse.name[0] }}</span>
                    </ValidationProvider>
                  </b-form-group>
                  <b-form-group
                      id="input-group-1"
                      label="Email address:"
                      label-for="input-1"
                  >
                    <ValidationProvider v-slot="{errors}" name="email" rules="required|email">
                      <b-form-input
                          id="input-1"
                          v-model="signupForm.email"
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
                          v-model="signupForm.password"
                          type="password"
                          placeholder="Enter password"
                      ></b-form-input>
                      <p class="text-danger">{{ errors[0] }}</p>
                      <span
                          v-if="messageErrorResponse.password"
                          class="d-block text-danger my-0">{{ messageErrorResponse.password[0] }}</span>
                    </ValidationProvider>
                  </b-form-group>
                  <b-form-group
                      id="input-group-2"
                      label="Confirm Password:"
                      label-for="input-2"
                  >
                    <ValidationProvider v-slot="{errors}" name="password confirm"
                                        rules="required|confirmed:password">
                      <b-form-input
                          id="input-2"
                          v-model="signupForm.password_confirmation"
                          type="password"
                          placeholder="Enter password confirm"
                      ></b-form-input>
                      <p class="text-danger">{{ errors[0] }}</p>
                      <span
                          v-if="messageErrorResponse.password_confirmation"
                          class="d-block text-danger my-0">{{ messageErrorResponse.password_confirmation[0] }}</span>
                    </ValidationProvider>
                  </b-form-group>
                  <b-button type="submit" variant="primary" class="mr-3">Sign Up</b-button>
                </b-form>
                <span>Have account? Sign in <router-link :to="{path:'/login'}">here.</router-link></span>
              </ValidationObserver>
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

export default {
  data: () => ({
    messageErrorResponse: '',
    signupForm: {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      role: 0,
      status: 1,
    },
    redirect: undefined,
    errors: [],
    message: '',
  }),
  methods: {
    handleSignUp() {
      this.$store.dispatch('user/signup', this.signupForm)
          .then(() => {
            this.$bvToast.toast(this.$t('auth.signup.msgSignupSuccess'), {
              variant: 'success',
              solid: true
            })
          }).catch((error) => {
        this.messageErrorResponse = error.response.data.errors;
      })
    }
  }
}
</script>

<style scoped>

</style>