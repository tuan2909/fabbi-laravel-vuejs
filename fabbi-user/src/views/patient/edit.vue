<template>
  <div class=" bg-light p-3">
    <LoadingPage :isLoading="isLoading"></LoadingPage>
    <div class="my-3">
      <h2>{{ title_page }}</h2>
    </div>
    <div class="p-3">
      <ValidationObserver v-slot="{handleSubmit}">
        <b-form @submit.prevent="handleSubmit(onSubmitForm)">
          <b-row>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Full Name: "
                  label-for="input-1"
              >
                <ValidationProvider v-slot="{errors}" name="full_name" rules="required|min:3|max:30">
                  <b-form-input
                      v-model="formEdit.full_name"
                      id="input-1"
                      type="text"
                      :placeholder="$t('patient.placeholder.fullName')"
                  ></b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.full_name"
                      class="d-block text-danger my-0">{{ messageErrorResponse.full_name[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Type Patient: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="Type Patient" rules="required">
                  <b-form-select
                      v-if="Object.keys(formEdit).length > 0"
                      v-model="formEdit.type_patient"
                      :options="typePatients"
                      class="mb-3"
                      value-field="value"
                      text-field="name"
                      @change="getListParentPatient(formEdit.type_patient)"
                  ></b-form-select>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.type_id"
                      class="d-block text-danger my-0">{{ messageErrorResponse.type_id[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col v-if="listParentPatient.length>0 ">
              <b-form-group
                  id="input-group-1"
                  label="Parent Patient: "
                  label-for="input-1"
              >
                <ValidationProvider v-slot="{errors}" name="parent patient" rules="required">
                  <b-form-select
                      v-if="Object.keys(formEdit).length > 0|| formEdit.parent_patient !==null"
                      v-model="formEdit.parent_patient.id"
                      :options="listParentPatient"
                      class="mb-3"
                      value-field="id"
                      text-field="full_name"
                  ></b-form-select>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.parent_id"
                      class="d-block text-danger my-0">{{ messageErrorResponse.parent_id[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Gender: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="gender" rules="required">
                  <b-form-select
                      v-model="formEdit.gender"
                      :options="genders"
                      class="mb-3"
                      value-field="value"
                      text-field="name"
                  ></b-form-select>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.gender"
                      class="d-block text-danger my-0">{{ messageErrorResponse.gender[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="City Live: "
                  label-for="input-1"
              >
                <ValidationProvider v-slot="{errors}" name="city" rules="required">
                  <b-form-select
                      v-if="Object.keys(formEdit).length > 0"
                      v-model="formEdit.cities.id"
                      :options="listCities"
                      class="mb-3"
                      value-field="id"
                      text-field="name"
                  ></b-form-select>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.gender"
                      class="d-block text-danger my-0">{{ messageErrorResponse.gender[0] }}</span>
                </ValidationProvider>
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
                <ValidationProvider v-slot="{errors}" name="city" rules="required">
                  <b-form-select
                      v-if="Object.keys(formEdit).length > 0"
                      v-model="formEdit.cities.id"
                      :options="listCities"
                      class="mb-3"
                      value-field="id"
                      text-field="name"
                  ></b-form-select>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.gender"
                      class="d-block text-danger my-0">{{ messageErrorResponse.gender[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Nation: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="nation" rules="required">
                  <b-form-input
                      v-model="formEdit.nation"
                      id="input-1"
                      type="text"
                      :placeholder="$t('patient.placeholder.nation')"
                  ></b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.nation"
                      class="d-block text-danger my-0">{{ messageErrorResponse.nation[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Year of Birth: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="year of births" rules="required|numeric|min:4|max:4">
                  <b-form-input
                      v-model="formEdit.year_birth"
                      id="input-1"
                      type="text"
                      :placeholder="$t('patient.placeholder.yearBirth')"
                  ></b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.year_birth"
                      class="d-block text-danger my-0">{{ messageErrorResponse.year_birth[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Citizen Identify: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="citizen identify" rules="required|numeric|min:10|max:12">
                  <b-form-input
                      v-model="formEdit.citizen_identify"
                      id="input-1"
                      type="text"
                      :placeholder="$t('patient.placeholder.addressEnd')">
                  </b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.citizen_identify"
                      class="d-block text-danger my-0">{{ messageErrorResponse.citizen_identify[0] }}</span>
                </ValidationProvider>
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
                <ValidationProvider v-slot="{errors}" name="address" rules="required">
                  <b-form-input
                      v-model="formEdit.address"
                      id="input-1"
                      type="text"
                      :placeholder="$t('patient.placeholder.address')"
                  ></b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.address"
                      class="d-block text-danger my-0">{{ messageErrorResponse.address[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Phone: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="phone" rules="required|min:10|max:12|numeric">
                  <b-form-input
                      v-model="formEdit.number"
                      id="input-1"
                      type="text"
                      placeholder=""
                      :placeholder="$t('patient.placeholder.phone')"
                  ></b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.number"
                      class="d-block text-danger my-0">{{ messageErrorResponse.number[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Email: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="email" rules="required|email">
                  <b-form-input
                      v-model="formEdit.email"
                      id="input-1"
                      type="text"
                      :placeholder="$t('patient.placeholder.email')"
                  ></b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.email"
                      class="d-block text-danger my-0">{{ messageErrorResponse.email[0] }}</span>
                </ValidationProvider>
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
                <ValidationProvider v-slot="{errors}" name="address start" rules="required">
                  <b-form-input
                      v-model="formEdit.address_start"
                      id="input-1"
                      type="text"
                      :placeholder="$t('patient.placeholder.addressStart')"
                  ></b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.address_start"
                      class="d-block text-danger my-0">{{ messageErrorResponse.address_start[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                  id="input-group-1"
                  label="Address End: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="address end" rules="required">
                  <b-form-input
                      v-model="formEdit.address_end"
                      id="input-1"
                      type="text"
                      :placeholder="$t('patient.placeholder.addressEnd')">
                  </b-form-input>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.address_end"
                      class="d-block text-danger my-0">{{ messageErrorResponse.address_end[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>

          </b-row>
          <b-row>
            <b-col cols="12">
              <h5>Health Condition:</h5>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <b-row>
                <b-col>
                  <b-form-checkbox v-model="healPatient.fever" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.fever')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="healPatient.cough" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.cough')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="healPatient.difficulty_breathing" :value="checked"
                                   :unchecked-value="unchecked" switch
                                   size="lg">
                    {{ $t('healPatient.difficultyBreathing') }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="healPatient.sore_throat" :value="checked" :unchecked-value="unchecked"
                                   switch
                                   size="lg">{{
                      $t('healPatient.soreThroat')
                    }}
                  </b-form-checkbox>
                </b-col>
              </b-row>
            </b-col>
            <b-col>
              <b-row>
                <b-col>
                  <b-form-checkbox v-model="healPatient.vomiting" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.vomiting')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="healPatient.rash" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.rash')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="healPatient.diarrhea" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.diarrhea')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="healPatient.skin_haemorrhage" :value="checked" :unchecked-value="unchecked"
                                   switch size="lg">
                    {{ $t('healPatient.skinHaemorrhage') }}
                  </b-form-checkbox>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <h5>Other</h5>
              <ckeditor v-model="healPatient.other"></ckeditor>
            </b-col>
          </b-row>
          <b-button type="submit" variant="primary" class="my-2">Save</b-button>
        </b-form>
      </ValidationObserver>
    </div>
  </div>
</template>

<script>
import RepositoryFactory from "../../repositories/factory";
import { GENDER, TYPE_PATIENT } from "../../constants/index"
import patient from "../../repositories/patient";
import router from "../../router";

const heal_patients = RepositoryFactory.get('heal_patient')
const patients = RepositoryFactory.get('patient');
const users = RepositoryFactory.get('user');
const type_patients = RepositoryFactory.get('type_patient');
const cities = RepositoryFactory.get('city');
export default {
  data() {
    return {
      checked: 1,
      unchecked: 0,
      genders: [
        { value: 0, name: GENDER.FEMALE },
        { value: 1, name: GENDER.MALE },
      ],
      healPatient: {},
      typePatients: TYPE_PATIENT,
      listParentPatient: [],
      listCities: [],
      isLoading: false,
      title_page: 'Edit Patient',
      formEdit: {},
      messageErrorResponse: {},
    }
  },
  created() {
    this.getPatient();
    this.getHealthPatient();
    this.getCities()
  },
  methods: {
    getListParentPatient: async function (value) {
      if (this.formEdit.parent_patient === null) {
        this.formEdit.parent_patient = [];
      }
      this.isLoading = true
      await patient.getParentPatientType(value).then((response) => {
        this.listParentPatient = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      }).finally(() => {
        this.isLoading = false;
      })
    },
    makeToast(variant = null, message) {
      this.$bvToast.toast(message, {
        variant: variant,
        solid: true
      })
    },
    getTypePatients: async function () {
      await type_patients.get().then((response) => {
        this.typePatients = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('typePatient.loadDataFail'));
      })
    },
    getCities: async function () {
      await cities.get().then((response) => {
        this.listCities = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('city.loadDataFail'));
      })
    },
    getHealthPatient: async function () {
      const id = this.$route.params.id;
      await heal_patients.edit(id).then((response) => {
        this.healPatient = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      })
    },
    getPatient: async function () {
      const id = this.$route.params.id;
      await patient.edit(id).then((response) => {
        this.formEdit = response.data;
        console.log(response.data)
        this.getListParentPatient(response.data.type_patient);
      }).catch(() => {
        this.makeToast('danger', this.$t('city.loadDataFail'));
      })
    },
    onSubmitForm: async function () {
      this.isLoading = true;
      const id = this.$route.params.id;
      let data = {
        'parent_id': this.formEdit.parent_patient.id,
      }
      this.formEdit.type_patient === 0 ? data.parent_id = '' : data
      this.formEdit = {
        ...this.formEdit,
        ...data,
        ...this.healPatient
      }
      console.log(this.formEdit);
      await patients.update(this.formEdit, id).then(() => {
        this.makeToast('success', this.$t('msgCRUD.msgUpdate.success'));
        router.push({ path: '/patients' })
      }).catch((error) => {
        this.makeToast('danger', this.$t('msgCRUD.msgUpdate.fail'));
        this.messageErrorResponse = error.response.data.errors;
      }).finally(() => {
        this.isLoading = false;
      });
    },
  }
}
</script>

<style scoped>

</style>