<template>
  <div class="row align-items-center m-4 p-4">
    <div class="col-lg-12">
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
      </b-form>
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