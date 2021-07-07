<template>
  <b-modal hide-footer :id="id" :title="title">
    <h5 class="text-danger text-center" v-if="messageErrorResponse.length>0"> {{ messageErrorResponse }}</h5>
    <ValidationObserver v-slot='{handleSubmit}'>
      <b-form @submit.prevent="handleSubmit(onSubmitForm)">
        <b-form-group
            id="input-group-1"
            label="Patient Name: "
            label-for="input-1"
        >
          <ValidationProvider v-slot="{errors}" name="patient" rules="required">
            <b-form-input
                v-if="Object.keys(quarantine).length>0"
                v-model="quarantine.patients.full_name"
                id="input-1"
                type="text"
                disabled
                :placeholder="$t('patient.placeholder.addressEnd')">
            </b-form-input>
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
            <b-form-datepicker
                v-if="Object.keys(quarantine).length>0"
                id="example-datepicker" v-model="quarantine.time_start"
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
            <b-form-datepicker
                v-if="Object.keys(quarantine).length>0"
                id="example-datepicker1" v-model="quarantine.time_end"
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
                v-if="Object.keys(quarantine).length>0"
                v-model="quarantine.status"
                :options="statusQuarantines"
                class=""
                value-field="value"
                text-field="name">
              <b-form-select-option :value="-1">Disabled</b-form-select-option>
            </b-form-select>
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
    quarantine: Object,
  },
  computed: {
    patientName() {
      return this.quarantine.patients.full_name;
    },
  },
  data() {
    return {
      messageErrorResponse: {},
      statusQuarantines: STATUS_QUARANTINE,
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
      let total = getTotalTime(this.quarantine.time_start, this.quarantine.time_end);
      let data = {
        'id': this.quarantine.id,
        'total': total,
        'patient_id': this.quarantine.patients.id,
      };
      this.quarantine = {
        ...this.quarantine,
        ...data,
      }
      await quarantines.update(this.quarantine, this.quarantine.id).then(() => {
        this.messageErrorResponse = {};
        this.quarantine = {};
        this.$bvModal.hide(this.id);
        this.$emit('UpdateQuarantine');
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