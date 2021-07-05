<template>
  <div>
    <LoadingPage :isLoading="isLoading"></LoadingPage>
    <div class="m-3">
      <h2 class="text-center">{{ title_page }}</h2>
    </div>
    <div class="float-right m-3">
      <router-link to="/patients/create" class="btn btn-success">
        Create
        <font-awesome-icon icon="plus"></font-awesome-icon>
      </router-link>
    </div>
    <b-row class="m-0 px-4">
      <b-col cols="4">
        <b-form @submit.prevent="getDataPatient()">
          <b-form-input
              id="input-1"
              type="text"
              v-model="keyword"
              placeholder="Enter name"
              class="my-3"
          ></b-form-input>
        </b-form>
      </b-col>
    </b-row>
    <div class="py-3 px-3" v-if="listPatients.length>0">
      <b-table
          :bordered="bordered"
          class="text-center"
          :striped="striped"
          :hover="hover"
          :fixed="fixed"
          :foot-clone="footClone"
          :no-border-collapse="noBorderCollapse"
          :per-page="perPage"
          :current-page="currentPage"
          :items="listPatients"
          :fields="fields">
        <template #cell(parent)="row">
        <span v-if="row.item.parent_patient !== null">
            {{ row.item.parent_patient.full_name }}
        </span>
          <span v-else>
            {{ $t('patient.noParentName') }}
          </span>
        </template>
        <template #cell(type_patient)="row">
          F{{ row.item.type_patient }}
        </template>
        <template #cell(cities)="row">
          {{ row.item.cities.name }}
        </template>
        <template #cell(created_at)="row">
          {{ formatDate(row.item.created_at) }}
        </template>
        <template #cell(updated_at)="row">
          {{ formatDate(row.item.updated_at) }}
        </template>
        <template #cell(actions)="row">
          <b-dropdown id="dropdown-1" text="Action" class="m-md-2">
            <b-dropdown-item>
              <a href="javascript:;" class="text-primary" v-b-modal="modal.idShow" @click="getPatientById(row.item.id)">
                <font-awesome-icon icon="eye"></font-awesome-icon>
                Show
              </a>
            </b-dropdown-item>
            <b-dropdown-item>
              <router-link :to="{ name: 'patient_edit', params: { id: row.item.id}}"
                           class="text-success">
                <font-awesome-icon
                    icon="edit"></font-awesome-icon>
                Edit
              </router-link>
            </b-dropdown-item>
            <b-dropdown-item>
              <a href="javascript:;" class="text-danger" @click="deletePatient(row.item.id)">
                <font-awesome-icon
                    icon="trash"></font-awesome-icon>
                Delete</a>
            </b-dropdown-item>
          </b-dropdown>
        </template>
      </b-table>
      <div class="float-right">
        <b-pagination
            v-model="currentPage"
            :total-rows="listPatients.length"
            :per-page="perPage"
        ></b-pagination>
      </div>
    </div>
    <div class="py-3 px-5 text-center" v-else>
      <strong class="text-dark">{{ this.messageDataEmpty }}</strong>
    </div>

    <Detail :id="modal.idShow" :title="modal.titleShow" :patient="patient" :heal_patient="healPatient"
            v-if="Object.keys(this.patient).length>0"></Detail>
  </div>

</template>

<script>
import RepositoryFactory from "../../repositories/factory";
import { PAGINATE } from '../../constants/index';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faEye, faTrash, faPlus } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Detail from "./modal/Detail";

library.add(faEdit, faEye, faTrash, faPlus)
const heal_patients = RepositoryFactory.get('heal_patient');
const patients = RepositoryFactory.get('patient');
export default {
  components: {
    PAGINATE,
    Detail,
    'font-awesome-icon': FontAwesomeIcon,
  },
  data() {
    return {
      isLoading: false,
      keyword: '',
      messageEmptySearch: '',
      title_page: "Manage Patients",
      modal: {
        idShow: 'show-patient',
        titleShow: 'Show Detail',
      },
      fields: [
        {
          key: 'id',
          label: "#",
          sortable: true
        },
        {
          key: 'full_name',
          label: 'Full Name',
          sortable: true
        },
        {
          key: 'parent',
          label: 'Parent Patient',
          sortable: true
        },
        {
          key: 'type_patient',
          label: 'Type Patient',
          sortable: true
        },
        {
          key: 'cities',
          label: 'City',
          sortable: true
        },
        {
          key: 'created_at',
          label: 'Created at',
          sortable: true,
        },
        {
          key: 'updated_at',
          label: 'Updated at',
          sortable: true,
        },
        { key: 'actions', label: 'Actions' }
      ],
      listPatients: [],
      patient: {},
      healPatient: {},
      messageDataEmpty: '',
      perPage: PAGINATE.PER_PAGE,
      currentPage: PAGINATE.CURRENT_PAGE,
      bordered: true,
      striped: false,
      hover: true,
      fixed: true,
      footClone: true,
      noBorderCollapse: true,
    }
  },
  mounted() {
    this.handleRouter();
    this.getDataPatient();
  },
  watch: {
    '$route.query': function () {
      this.handleRouter()
    },
  },
  methods: {
    formatDate(date) {
      return this.$date(date).format('DD/MM/YYYY HH:mm')
    },
    handleRouter() {
      const keyword = this.$route.query.keyword
      if (keyword !== undefined) {
        this.keyword = this.$route.query.keyword
      }
    },
    makeToast(variant = null, message) {
      this.$bvToast.toast(message, {
        variant: variant,
        solid: true
      })
    },
    getPatientById: async function (id) {
      await patients.edit(id).then((response) => {
        this.patient = response.data;
        if (response.data) {
          this.getHealPatientById(id);
        }
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      });
    },
    getHealPatientById: async function (id) {
      await heal_patients.edit(id).then((response) => {
        this.healPatient = response.data;
      }).catch(() => {
      })
    },
    getDataPatient: async function () {
      this.isLoading = true;
      await patients.get({ keyword: this.keyword.trim() }).then((response) => {
        this.listPatients = response.data;
        this.listPatients.length < 1 ? this.messageDataEmpty = this.$t('dataEmpty') : this.messageDataEmpty = '';
        if (this.keyword !== '') {
          this.$router
              .push({ path: '/patients', query: { keyword: this.keyword.trim() }, }).catch(() => {
          });
        } else {
          this.$router.push({ path: '/patients' }).catch(() => {
          });
        }
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      }).finally(() => {
        this.isLoading = false
      });
    },
    deletePatient: async function (id) {
      if (confirm(this.$t('msgCRUD.msgDelete.confirm'))) {
        this.isLoading = true
        await patients.delete(id).then(() => {
          this.getDataPatient();
          this.makeToast('success', this.$t('msgCRUD.msgDelete.success'));
        }).catch(() => {
          this.makeToast('danger', this.$t('msgCRUD.msgDelete.fail'));
        }).finally(() => {
          this.isLoading = false;
        })
      }
    }
  }
}
</script>

<style scoped>

</style>