<template>
  <b-modal hide-footer :id="id" :title="title">
    <ValidationObserver v-slot="{handleSubmit}">
      <b-form @submit.prevent="handleSubmit(onSubmitForm)">
        <b-form-group
            id="input-group-1"
            label="Patient Isolate: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="patient" rules="required">
            <b-form-select
                v-if="Object.keys(specimen).length>0"
                v-model="specimen.quarantine_id"
                :options="listQuarantines"
                class="mb-3"
                value-field="id"
                text-field="patients.full_name"
            ></b-form-select>
            <p class="text-danger">{{ errors[0] }}</p>
            <span
                v-if="messageErrorResponse.patient"
                class="d-block text-danger my-0">{{ messageErrorResponse.patient[0] }}</span>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
            id="input-group-1"
            label="Date Draw Blood: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="date draw blood" rules="required">
            <DateTimePicker :format="formatTime" width="100%" v-model="specimen.date_draw_blood"></DateTimePicker>
            <p class="text-danger">{{ errors[0] }}</p>
            <span
                v-if="messageErrorResponse.date_draw_blood"
                class="d-block text-danger my-0">{{ messageErrorResponse.date_draw_blood[0] }}</span>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
            id="input-group-1"
            label="Date Test: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="date test" rules="required">
            <DateTimePicker :format="formatTime" width="100%" v-model="specimen.date_test"></DateTimePicker>
            <p class="text-danger">{{ errors[0] }}</p>
            <span
                v-if="messageErrorResponse.date_test"
                class="d-block text-danger my-0">{{ messageErrorResponse.date_test[0] }}</span>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
            id="input-group-1"
            label="Result Test: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="result test" rules="required">
            <b-form-select
                v-model="specimen.result_test"
                :options="resultTest"
                class="mb-3"
                value-field="value"
                text-field="name"
            ></b-form-select>
            <p class="text-danger">{{ errors[0] }}</p>
            <span v-if="messageErrorResponse.result_test"
                  class="d-block text-danger my-0">{{ messageErrorResponse.result_test[0] }}</span>
          </ValidationProvider>
        </b-form-group>
        <div v-if="specimen.result_test===1">
          <b-form-group
              id="input-group-1"
              label="Date Infection: "
              label-for="input-1"
          >
            <ValidationProvider v-slot="{errors}" name="date infection" rules="">
              <DateTimePicker :format="formatTime" width="100%" v-model="specimen.date_infection"></DateTimePicker>
              <p class="text-danger">{{ errors[0] }}</p>
              <span
                  v-if="messageErrorResponse.date_infection"
                  class="d-block text-danger my-0">{{ messageErrorResponse.date_infection[0] }}</span>
            </ValidationProvider>
          </b-form-group>
        </div>
        <div v-else-if="specimen.result_test===0">
          <input type="hidden" v-model="specimen.date_infection =''">
        </div>
        <b-form-group
            id=" input-group-1"
            label="Address: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="address" rules="required">
            <b-form-input
                v-model.lazy="specimen.address"
                id="input-1"
                type="text"
                placeholder="Enter address"
            ></b-form-input>
            <p class="text-danger">{{ errors[0] }}</p>
            <span
                v-if="messageErrorResponse.address"
                class="d-block text-danger my-0">{{ messageErrorResponse.address[0] }}</span>
          </ValidationProvider>
        </b-form-group>
        <b-button type="submit" variant="primary">Save</b-button>
      </b-form>
    </ValidationObserver>
  </b-modal>
</template>

<script>
import RepositoryFactory from "../../../repositories/factory";
import DateTimePicker from "vuejs-datetimepicker"
import { FORMAT_TIME } from "../../../constants/index"

const specimens = RepositoryFactory.get('specimen');
export default {
  props: {
    id: String,
    title: String,
    listQuarantines: Array,
    specimen: Object,
  },

  components: {
    DateTimePicker,
  },
  data() {
    return {
      resultTest: [
        { value: 1, name: 'Dương tính' },
        { value: 0, name: 'Âm tính' }
      ],
      formEdit: this.specimen,
      formatTime: FORMAT_TIME,
      todayBtn: true,
      resetBtn: true,
      closeBtn: true,
      lang: 'en',
      messageErrorResponse: {},
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
      await specimens.update(this.specimen, this.specimen.id)
          .then(() => {
            this.messageErrorResponse = {};
            this.$bvModal.hide(this.id);
            this.$emit('UpdateSpecimen');
            this.makeToast('success', this.$t('msgCRUD.msgUpdate.success'));
          }).catch((error) => {
            this.messageErrorResponse = error.response.data.errors;
          });
    }
  }
}
</script>

<style scoped>

</style>