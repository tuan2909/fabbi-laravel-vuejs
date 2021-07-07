<template>
  <b-modal hide-footer :id="id" :title="title">
    <ValidationObserver v-slot='{handleSubmit}'>
      <b-form @submit.prevent="handleSubmit(onSubmitForm)">
        <b-form-group
            id="input-group-1"
            label="Patient Name: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="patient" rules="required">
            <b-form-select
                v-model="formCreate.patient_id"
                :options="list_patient"
                class=""
                value-field="id"
                text-field="full_name"></b-form-select>
            <p class="text-danger">{{ errors[0] }}</p>
            <span
                v-if="messageErrorResponse.name"
                class="d-block text-danger my-0">{{ messageErrorResponse.name[0] }}</span>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
            id="input-group-1"
            label="Date Start: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="date start" rules="required">
            <b-form-datepicker id="example-datepicker" v-model="formCreate.time_start"
                               class="mb-2"></b-form-datepicker>
            <p class="text-danger">{{ errors[0] }}</p>
            <span
                v-if="messageErrorResponse.time_start"
                class="d-block text-danger my-0">{{ messageErrorResponse.time_start[0] }}</span>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
            id="input-group-1"
            label="Date End: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="date end" rules="required">
            <b-form-datepicker id="example-datepicker1" v-model="formCreate.time_end"
                               class="mb-2"></b-form-datepicker>
            <p class="text-danger">{{ errors[0] }}</p>
            <span
                v-if="messageErrorResponse.time_end"
                class="d-block text-danger my-0">{{ messageErrorResponse.time_end[0] }}</span>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
            id="input-group-1"
            label="Status: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="patient" rules="required">
            <b-form-select
                v-model="formCreate.status"
                :options="statusQuarantines"
                class=""
                value-field="value"
                text-field="name"></b-form-select>
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
import { STATUS_QUARANTINE } from "../../../constants/index"
import { getTotalTime } from "../../../utlis/index"

const quarantines = RepositoryFactory.get('quarantine');
export default {
  props: {
    id: String,
    title: String,
    list_patient: Array,
  },
  data() {
    return {
      messageErrorResponse: {},
      statusQuarantines: STATUS_QUARANTINE,
      formCreate: {
        patient_id: '',
        time_start: '',
        time_end: '',
        status: '',
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
      let total = getTotalTime(this.formCreate.time_start, this.formCreate.time_end);
      let totalTime = {
        'total': total,
      };
      this.formCreate = {
        ...this.formCreate,
        ...totalTime,
      }
      await quarantines.create(this.formCreate).then(() => {
        this.messageErrorResponse = {};
        this.formCreate = {};
        this.$bvModal.hide(this.id);
        this.$emit('CreateQuarantine');
        this.makeToast('success', this.$t('msgCRUD.msgCreate.success'));
      }).catch((error) => {
        this.messageErrorResponse = error.response.data.errors;
      });
    }
  }
}
</script>

<style scoped>

</style>