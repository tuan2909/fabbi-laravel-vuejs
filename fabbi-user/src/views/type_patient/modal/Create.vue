<template>
  <b-modal hide-footer :id="id" :title="title">
    <ValidationObserver v-slot="{handleSubmit}">
      <b-form @submit.prevent="handleSubmit(onSubmitForm)">
        <b-form-group
            id="input-group-1"
            label="Name: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="name" rules="required|max:30">
            <b-form-input
                v-model="formCreate.name"
                id="input-1"
                type="text"
                placeholder="Enter type"
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
  </b-modal>
</template>

<script>
import RepositoryFactory from "../../../repositories/factory";

const type_patients = RepositoryFactory.get('type_patient');
export default {
  props: {
    id: String,
    title: String,
  },
  data() {
    return {
      messageErrorResponse: {},
      formCreate: {
        name: '',
      },
    };
  },
  methods: {
    makeToast(variant = null, message) {
      this.$bvToast.toast(message, {
        variant: variant,
        solid: true
      })
    },
    onSubmitForm: async function () {
      await type_patients.create(this.formCreate)
          .then(() => {
            this.messageErrorResponse = {};
            this.formCreate = {};
            this.$bvModal.hide(this.id);
            this.$emit('CreateTypePatient');
            this.makeToast('success', this.$t('msgCRUD.msgCreate.success'));
          }).catch((error) => {
            console.log(error);
            // this.messageErrorResponse = error.response.data.errors;
          })
    }
  }
}
</script>

<style scoped>

</style>