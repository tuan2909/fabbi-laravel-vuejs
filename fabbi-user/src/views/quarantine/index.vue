<template>
  <div>
    <LoadingPage :isLoading="isLoading"></LoadingPage>
    <div class="m-3">
      <h2 class="text-center">{{ title_page }}</h2>
    </div>
    <div class="float-right m-3">
      <b-button v-b-modal="modal.idCreate" class="btn btn-success">Create
        <font-awesome-icon icon="plus"></font-awesome-icon>
      </b-button>
    </div>
    <b-row class="m-0 px-4">
      <b-col cols="4">
        <b-form @submit.prevent="getDataQuarantines()">
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
    <div class="py-3 px-3" v-if="listQuarantines.length>0">
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
          :items="listQuarantines"
          :fields="fields">
        <template #cell(patients)="row">
          <router-link :to="{ name: 'patient_edit', params: { id: row.item.id}}">
            {{ row.item.full_name }}
          </router-link>
        </template>
        <template #cell(status)="row">
          <span class="text-warning"
                v-if="row.item.status===quarantine_status.WAITING">{{ $t('quarantine.status.waiting') }}</span>
          <span class="text-danger"
                v-else-if="row.item.status===quarantine_status.DISABLED">{{ $t('quarantine.status.disabled') }}</span>
          <span class="text-success" v-else>{{ $t('quarantine.status.active') }}</span>
        </template>
        <template #cell(created_at)="row">
          {{ formatDate(row.item.created_at) }}
        </template>
        <template #cell(updated_at)="row">
          {{ formatDate(row.item.updated_at) }}
        </template>
        <template #cell(actions)="row">
          <b-dropdown id="dropdown-1" text="Action" class="m-md-2">
            <b-dropdown-item @click="getQuarantineBy(row.item.id)" v-if="row.item.status!==-1">
              <span v-b-modal="modal.idEdit" class="text-primary"><font-awesome-icon icon="edit"></font-awesome-icon>Edit</span>
            </b-dropdown-item>
            <b-dropdown-item>
              <span class="text-danger" @click="deleteQuarantine(row.item.id)">
                <font-awesome-icon
                    icon="trash"></font-awesome-icon>
                Delete</span>
            </b-dropdown-item>
          </b-dropdown>
        </template>
      </b-table>
      <div class="float-right">
        <b-pagination
            v-model="currentPage"
            :total-rows="listQuarantines.length"
            :per-page="perPage"
        ></b-pagination>
      </div>
    </div>
    <div class="py-3 px-5 text-center" v-else>
      <strong class="text-dark">{{ this.messageDataEmpty }}</strong>
    </div>
    <Create
        :id="modal.idCreate"
        :title="modal.titleCreate"
        :list_patient="listPatients"
        v-on:CreateQuarantine="updateQuarantine">
    </Create>
    <Edit
        :id="modal.idEdit"
        :title="modal.titleEdit"
        :list_patient="listPatients"
        v-on:UpdateQuarantine="updateQuarantine"
        :quarantine="quarantine"
    ></Edit>
  </div>

</template>

<script>
import RepositoryFactory from "../../repositories/factory";
import { PAGINATE, QUARANTINE } from '../../constants/index';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faEye, faTrash, faPlus } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Create from "./modal/Create";
import Edit from "./modal/Edit";

library.add(faEdit, faEye, faTrash, faPlus)
const heal_patients = RepositoryFactory.get('heal_patient');
const patients = RepositoryFactory.get('patient');
const quarantines = RepositoryFactory.get('quarantine');
export default {
  components: {
    PAGINATE,
    'font-awesome-icon': FontAwesomeIcon,
    Create,
    Edit,
  },
  data() {
    return {
      isLoading: false,
      keyword: '',
      messageEmptySearch: '',
      title_page: "Manage Quarantines",
      modal: {
        idCreate: 'create-modal',
        titleCreate: 'Create Quarantine',
        idEdit: 'edit-modal',
        titleEdit: 'Edit Quarantine',
      },
      quarantine_status: QUARANTINE,
      fields: [
        {
          key: 'id',
          label: "#",
          sortable: true
        },
        {
          key: 'patients',
          label: 'Patient',
          sortable: true
        },
        {
          key: 'time_start',
          label: 'Time Start',
          sortable: true
        },
        {
          key: 'time_end',
          label: 'Time End',
          sortable: true
        },
        {
          key: 'total',
          label: 'Total Time (days)',
          sortable: true
        },
        {
          key: 'status',
          label: 'Status',
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
      listQuarantines: [],
      quarantine: {},
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
    this.getDataQuarantines();
    this.getListPatients();
  },
  watch: {
    '$route.query': function () {
      this.handleRouter()
    },
  },
  methods: {
    updateQuarantine() {
      this.getDataQuarantines();
      this.getListPatients();
    },
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
    getListPatients: async function () {
      await quarantines.getListPatientNotQuarantine().then((response) => {
        this.listPatients = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      })
    },
    getDataQuarantines: async function () {
      this.isLoading = true;
      await quarantines.get({ keyword: this.keyword.trim() }).then((response) => {
        this.listQuarantines = response.data;
        this.listQuarantines.length < 1 ? this.messageDataEmpty = this.$t('dataEmpty') : this.messageDataEmpty = '';
        if (this.keyword !== '') {
          this.$router
              .push({ path: '/quarantines', query: { keyword: this.keyword.trim() }, }).catch(() => {
          });
        } else {
          this.$router.push({ path: '/quarantines' }).catch(() => {
          });
        }
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      }).finally(() => {
        this.isLoading = false
      });
    },
    getQuarantineBy: async function (id) {
      await quarantines.edit(id).then((response) => {
        this.quarantine = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      })
    },
    deleteQuarantine: async function (id) {
      if (confirm(this.$t('msgCRUD.msgDelete.confirm'))) {
        this.isLoading = true
        await quarantines.delete(id).then(() => {
          this.getDataQuarantines();
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