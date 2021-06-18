<template>
  <div class="container bg-light p-3">
    <div class="my-3">
      <h2>{{ title_page }}</h2>
    </div>
    <b-alert
        :show="dismissCountDown"
        dismissible
        :variant="variant"
        @dismissed="dismissCountDown=0"
        @dismiss-count-down="countDownChanged"
    >
      <p>Update success page will return after {{ this.dismissCountDown }} second...</p>
      <b-progress
          :variant="variant"
          :max="dismissSecs"
          :value="dismissCountDown"
          height="4px"
      ></b-progress>
    </b-alert>
    <div class="p-3">
      <ValidationObserver v-slot="{handleSubmit}">
        <b-form @submit.prevent="handleSubmit(updateDataCity)">
          <b-form-group
              id="input-group-1"
              label="Name:"
              label-for="input-1"
          >
            <ValidationProvider v-slot="{errors}" name="name" rules="required|min:5|max:30">
              <b-form-input
                  v-model.lazy="formEdit.name"
                  id="input-1"
                  type="text"
                  placeholder="Enter name"
              ></b-form-input>
              <p class="text-danger">{{ errors[0] }}</p>
              <span
                  v-if="messageErrorResponse.name"
                  class="d-block text-danger my-0">{{ messageErrorResponse.name[0] }}</span>
            </ValidationProvider>
          </b-form-group>
          <b-button type="submit" variant="primary">Save</b-button>
        </b-form>
      </ValidationObserver>
    </div>
  </div>
</template>

<script>
import router from "../../router";
import RepositoryFactory from "../../repositories/factory";

const cities = RepositoryFactory.get('city');
export default {
  data() {
    return {
      variant: '',
      dismissSecs: 5,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      title_page: 'Edit City',
      formEdit: {},
      messageErrorResponse: {},
    }
  },
  created() {
    this.getDataCityById();
  },
  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert(variant) {
      this.dismissCountDown = this.dismissSecs;
      this.variant = variant;
    },
    getDataCityById: async function () {
      const id = this.$route.params.id;
      await cities.edit(id).then((response) => {
        this.formEdit = response.data;
      })
    },
    updateDataCity: async function () {
      const id = this.$route.params.id;
      await cities.update(this.formEdit, id).then(() => {
            this.showAlert('success');
            setTimeout(() => {
              router.push({ path: '/cities' });
            }, 5000);
          }
      ).catch((error) => {
        this.messageErrorResponse = error.response.data.errors;
      });
    },
  }
}
</script>

<style scoped>

</style>