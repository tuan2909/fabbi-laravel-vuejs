<template>
  <b-modal :id="id" size="lg" :hide-footer="hideFooter" :scrollable="scrollable" :title="title">
    <b-row>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Full Name: "
            label-for="input-1"
        >
          <b-form-input
              v-model.lazy="this.fullName"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Type Patient: "
            label-for="input-2"
        >
          <b-form-input
              v-model.lazy="this.typePatient"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Parent Patient: "
            label-for="input-1"
        >
          <b-form-input
              v-model="this.parentPatient"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Gender: "
            label-for="input-2"
        >
          <b-form-input
              v-model.lazy="this.gender"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="City Live: "
            label-for="input-1"
        >
          <b-form-input
              v-model.lazy="this.city"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Nation: "
            label-for="input-2"
        >
          <b-form-input
              v-model.lazy="this.nation"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Year Birth: "
            label-for="input-2"
        >
          <b-form-input
              v-model.lazy="this.yearBirth"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Citizen Identify: "
            label-for="input-2"
        >
          <b-form-input
              v-model.lazy="this.citizenIdentify"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Address: "
            label-for="input-1"
        >
          <b-form-input
              v-model.lazy="this.address"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Phone: "
            label-for="input-2"
        >
          <b-form-input
              v-model.lazy="this.number"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Email: "
            label-for="input-2"
        >
          <b-form-input
              v-model.lazy="this.email"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Address Start: "
            label-for="input-1"
        >
          <b-form-input
              v-model.lazy="this.addressStart"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col>
        <b-form-group
            id="input-group-1"
            label="Address End: "
            label-for="input-2"
        >
          <b-form-input
              v-model.lazy="this.addressEnd"
              id="input-1"
              type="text"
              placeholder=""
              disabled
          ></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols="12">
        <h6>Health Condition:</h6>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-row>
          <b-col>
            <b-form-group
                id="input-group-1"
                label="Fever"
                title="Fever"
                label-for="input-2"
            >
              <b-form-input
                  v-model.lazy="this.fever"
                  id="input-1"
                  type="text"
                  placeholder=""
                  disabled
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
                id="input-group-1"
                label="Cough"
                title="Cough"
                label-for="input-2"
            >
              <b-form-input
                  v-model.lazy="this.cough"
                  id="input-1"
                  type="text"
                  placeholder=""
                  disabled
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
                id="input-group-1"
                label="DB"
                title="Difficulty Breathing"
                label-for="input-2"
            >
              <b-form-input
                  v-model.lazy="this.difficulty_breathing"
                  id="input-1"
                  type="text"
                  placeholder=""
                  disabled
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
                id="input-group-1"
                label="ST"
                title="Sore Throat"
                label-for="input-2"
            >
              <b-form-input
                  v-model.lazy="this.sore_throat"
                  id="input-1"
                  type="text"
                  placeholder=""
                  disabled
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
      </b-col>
      <b-col>
        <b-row>
          <b-col>
            <b-form-group
                id="input-group-1"
                label="Vomiting"
                title="Vomiting"
                label-for="input-2"
            >
              <b-form-input
                  v-model.lazy="this.vomiting"
                  id="input-1"
                  type="text"
                  placeholder=""
                  disabled
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
                id="input-group-1"
                label="Diarrhea"
                title="Diarrhea"
                label-for="input-2"
            >
              <b-form-input
                  v-model.lazy="this.diarrhea"
                  id="input-1"
                  type="text"
                  placeholder=""
                  disabled
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
                id="input-group-1"
                label="SH"
                title="Skin Haemorrhage"
                label-for="input-2"
            >
              <b-form-input
                  v-model.lazy="this.skin_haemorrhage"
                  id="input-1"
                  type="text"
                  placeholder=""
                  disabled
              ></b-form-input>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
                id="input-group-1"
                label="Rash"
                title="Rash"
                label-for="input-2"
            >
              <b-form-input
                  v-model.lazy="this.rash"
                  id="input-1"
                  type="text"
                  placeholder=""
                  disabled
              ></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <h5>Other</h5>
        <ckeditor v-model="heal_patient.other" :read-only="true"></ckeditor>
      </b-col>
    </b-row>
    <router-link :to="{ name: 'patient_edit', params: { id: this.patient.id}}"
                 class="btn btn-primary my-3">Edit
    </router-link>
  </b-modal>
</template>

<script>
import { GENDER } from "../../../constants";

export default {
  props: {
    id: String,
    title: String,
    patient: Object,
    heal_patient: Object,
  },
  computed: {
    fullName() {
      return this.patient.full_name || '';
    },
    citizenIdentify() {
      return this.patient.citizen_identify || '';
    },
    nation() {
      return this.patient.nation || '';
    },
    gender() {
      return this.patient.gender === 1 ? GENDER.MALE : GENDER.FEMALE
    },
    yearBirth() {
      return this.patient.year_birth || '';
    },
    number() {
      return this.patient.number || '';
    },
    address() {
      return this.patient.address || '';
    },
    email() {
      return this.patient.email || '';
    },
    addressStart() {
      return this.patient.address_start || '';
    },
    addressEnd() {
      return this.patient.address_end || '';
    },
    typePatient() {
      return this.patient.type_patient;
    },
    parentPatient() {
      const parent = this.patient.parent_patient;

      return parent ? this.patient.parent_patient.full_name : this.$t('patient.noParentName');
    },
    city() {
      return this.patient.cities.name || '';
    },
    fever() {
      return this.formatHealth(this.heal_patient.fever) || '';
    },
    cough() {
      return this.formatHealth(this.heal_patient.cough) || '';
    },
    difficulty_breathing() {
      return this.formatHealth(this.heal_patient.difficulty_breathing) || '';
    },
    sore_throat() {
      return this.formatHealth(this.heal_patient.sore_throat) || '';
    },
    vomiting() {
      return this.formatHealth(this.heal_patient.vomiting) || '';
    },
    diarrhea() {
      return this.formatHealth(this.heal_patient.diarrhea) || '';
    },
    skin_haemorrhage() {
      return this.formatHealth(this.heal_patient.skin_haemorrhage) || '';
    },
    rash() {
      return this.formatHealth(this.heal_patient.rash) || '';
    },
    other() {
      return this.formatHealth(this.heal_patient.other) || '';
    },
  },
  data() {
    return {
      checked: 1,
      unchecked: 0,
      hideFooter: true,
      scrollable: true,
    }
  },
  methods: {
    formatHealth(data) {
      return data === 1 ? 'Yes' : 'No'
    }
  }
}
</script>

<style scoped>

</style>