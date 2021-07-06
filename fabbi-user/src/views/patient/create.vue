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
                <ValidationProvider v-slot="{errors}" name="full name" rules="required|min:3|max:30">
                  <b-form-input
                      v-model="formCreate.full_name"
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
                <ValidationProvider v-slot="{errors}" name="type patient" rules="required">
                  <b-form-select
                      v-model="formCreate.type_patient"
                      class="mb-3"
                      @change="getListParentPatient(formCreate.type_patient)"
                  >
                    <b-form-select-option v-for="parent in typePatients"
                                          :value="parent.value">
                      {{ parent.name }}
                    </b-form-select-option>
                  </b-form-select>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.type_patient"
                      class="d-block text-danger my-0">{{ messageErrorResponse.type_patient[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </b-col>
            <b-col v-if="listParentPatient.length>0">
              <b-form-group
                  id="input-group-1"
                  label="Parent Patient: "
                  label-for="input-1"
              >
                <ValidationProvider v-slot="{errors}" name="parent patient" rules="required">
                  <b-form-select
                      v-model="formCreate.parent_id"
                      :options="listParentPatient"
                      class="mb-3"
                      value-field="id"
                      text-field="full_name"
                  ></b-form-select>
                  <p class="text-danger">{{ errors[0] }}</p>
                  <span
                      v-if="messageErrorResponse.user_id"
                      class="d-block text-danger my-0">{{ messageErrorResponse.user_id[0] }}</span>
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
                      v-model="formCreate.gender"
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
                      v-model="formCreate.city_id"
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
                  label="Nation: "
                  label-for="input-2"
              >
                <ValidationProvider v-slot="{errors}" name="nation" rules="required">
                  <b-form-input
                      v-model="formCreate.nation"
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
                      v-model="formCreate.year_birth"
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
                      v-model="formCreate.citizen_identify"
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
                      v-model="formCreate.address"
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
                      v-model="formCreate.number"
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
                      v-model="formCreate.email"
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
                      v-model="formCreate.address_start"
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
                      v-model="formCreate.address_end"
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
                  <b-form-checkbox v-model="formCreate.fever" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.fever')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="formCreate.cough" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.cough')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="formCreate.difficulty_breathing" :value="checked"
                                   :unchecked-value="unchecked" switch
                                   size="lg">
                    {{ $t('healPatient.difficultyBreathing') }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="formCreate.sore_throat" :value="checked" :unchecked-value="unchecked" switch
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
                  <b-form-checkbox v-model="formCreate.vomiting" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.vomiting')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="formCreate.rash" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.rash')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="formCreate.diarrhea" :value="checked" :unchecked-value="unchecked" switch
                                   size="lg">{{
                      $t('healPatient.diarrhea')
                    }}
                  </b-form-checkbox>
                </b-col>
                <b-col>
                  <b-form-checkbox v-model="formCreate.skin_haemorrhage" :value="checked" :unchecked-value="unchecked"
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
              <ckeditor v-model="formCreate.other"></ckeditor>
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
      typePatients: TYPE_PATIENT,
      listParentPatient: [],
      listCities: [],
      isLoading: false,
      title_page: 'Create Patient',
      formCreate: {
        full_name: '',
        parent_id: '',
        type_patient: '',
        city_id: '',
        citizen_identify: '',
        gender: 0,
        nation: '',
        year_birth: '',
        address: '',
        number: '',
        email: '',
        address_start: '',
        address_end: '',
        fever: 0,
        cough: 0,
        difficulty_breathing: 0,
        sore_throat: 0,
        vomiting: 0,
        diarrhea: 0,
        skin_haemorrhage: 0,
        rash: 0,
        other: '',
      },
      messageErrorResponse: {},
    }
  },
  created() {
    this.getCities()
  },
  methods: {
    getListParentPatient: async function (value) {
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
    getCities: async function () {
      await cities.get().then((response) => {
        this.listCities = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('city.loadDataFail'));
      })
    },
    onSubmitForm: async function () {
      this.isLoading = true;
      if (this.formCreate.type_patient === 0) {
        this.formCreate.parent_id = '';
      }
      await patients.create(this.formCreate).then(() => {
        this.makeToast('success', this.$t('msgCRUD.msgCreate.success'))
        router.push({ path: '/patients' })
      }).catch((error) => {
        this.makeToast('danger', this.$t('msgCRUD.msgCreate.fail'))
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