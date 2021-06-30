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
        <b-form @submit.prevent="getListSpecimens()">
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
    <div class="py-3 px-3" v-if="listSpecimens.length>0">
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
          :items="listSpecimens"
          :fields="fields">
        <template #cell(patients)="row">
          <router-link :to="{ name: 'patient_edit', params: { id: row.item.patient_id}}">
            {{ row.item.patient_name }}
          </router-link>
        </template>
        <template #cell(date_infection)="row">
          {{ formatDate(row.item.date_infection) }}
        </template>
        <template #cell(date_draw_blood)="row">
          {{ formatDate(row.item.date_draw_blood) }}
        </template>
        <template #cell(date_test)="row">
          {{ formatDate(row.item.date_test) }}
        </template>
        <template #cell(result_test)="row">
          <span v-if="row.item.result_test === isInfection" class="text-success"> {{
              $t('specimen.resultTest.negative')
            }}</span>
          <span v-else class="text-danger">{{ $t('specimen.resultTest.positive') }}</span>
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
              <span v-b-modal="modal.idEdit" class="text-primary" @click="getSpecimenBy(row.item.id)">
                <font-awesome-icon icon="edit"></font-awesome-icon>
                Edit
              </span>
            </b-dropdown-item>
            <b-dropdown-item>
              <a href="javascript:;" class="text-danger" @click="deleteSpecimen(row.item.id)">
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
            :total-rows="listSpecimens.length"
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
        :listQuarantines="listQuarantines"
        v-on:CreateSpecimen="updateListSpecimen">
    </Create>
    <Edit
        :id="modal.idEdit"
        :title="modal.titleEdit"
        v-on:UpdateSpecimen="updateListSpecimen"
        :listQuarantines="listQuarantines"
        :specimen="specimen"
    ></Edit>
  </div>

</template>

<script>
import RepositoryFactory from "../../repositories/factory";
import { FORMAT_TIME, PAGINATE } from '../../constants/index';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faEye, faTrash, faPlus } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Create from "./modal/Create";
import Edit from "./modal/Edit";

library.add(faEdit, faEye, faTrash, faPlus)
const specimens = RepositoryFactory.get('specimen');
const quarantines = RepositoryFactory.get('quarantine');
export default {
  components: {
    PAGINATE,
    Create,
    Edit,
    'font-awesome-icon': FontAwesomeIcon,
  },
  data() {
    return {
      listQuarantines: [],
      specimen: {},
      modal: {
        idCreate: 'create-modal',
        titleCreate: 'Create Specimen',
        idEdit: 'edit-modal',
        titleEdit: 'Edit Specimen',
      },
      isInfection: 0,
      isLoading: false,
      keyword: '',
      messageEmptySearch: '',
      title_page: "Manage Specimens",
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
          key: 'date_infection',
          label: 'Date Infection',
          sortable: true
        },
        {
          key: 'date_draw_blood',
          label: 'DDB',
          sortable: true
        },
        {
          key: 'date_test',
          label: 'Date Test',
          sortable: true
        },
        {
          key: 'result_test',
          label: 'Result Test',
          sortable: true
        },
        {
          key: 'address',
          label: 'Address',
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
      listSpecimens: [],
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
    this.getListSpecimens();
    this.getListQuarantines();
  },
  watch: {
    '$route.query': function () {
      this.handleRouter()
    },
  },
  methods: {
    getListQuarantines: async function () {
      await quarantines.get().then((response) => {
        console.log(response.data);
        this.listQuarantines = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('patient.msgLoadDataFail'));
      });
    },
    updateListSpecimen() {
      this.getListSpecimens();
    },
    getListSpecimens: async function () {
      this.isLoading = true;
      await specimens.get({ keyword: this.keyword.trim() }).then((response) => {
        this.listSpecimens = response.data;
        this.listSpecimens.length < 1 ? this.messageCityEmpty = this.$t('dataEmpty') : this.messageCityEmpty = '';
        if (this.keyword !== '') {
          this.$router
              .push({ path: '/specimens', query: { keyword: this.keyword.trim() }, }).catch(() => {
          });
        } else {
          this.$router.push({ path: '/specimens' }).catch(() => {
          });
        }
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      }).finally(() => {
        this.isLoading = false;
      })
    },
    getSpecimenBy: async function (id) {
      await specimens.edit(id).then((response) => {
        this.specimen = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      })
    },
    formatDate(date) {
      return date ? this.$date(date).format(FORMAT_TIME) : 'No Date'
    },
    handleRouter() {
      const keyword = this.$route.query.keyword;
      if (keyword !== undefined) {
        this.keyword = this.$route.query.keyword;
      }
    },
    makeToast(variant = null, message) {
      this.$bvToast.toast(message, {
        variant: variant,
        solid: true
      })
    },
    deleteSpecimen: async function (id) {
      if (confirm(this.$t('msgCRUD.msgDelete.confirm'))) {
        this.isLoading = true;
        await specimens.delete(id).then(() => {
          this.getListSpecimens();
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