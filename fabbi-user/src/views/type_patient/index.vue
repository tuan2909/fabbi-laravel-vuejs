<template>
  <div>
    <div class="m-3">
      <h2 class="text-center">{{ title_page }}</h2>
    </div>
    <div class="float-right m-3">
      <b-button v-b-modal="modal.idCreate" class="btn btn-success">Create</b-button>
    </div>
    <b-row class="m-0 px-4">
      <b-col cols="4">
        <b-form @submit.prevent="getDataTypePatient">
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
    <div class="py-3 px-5" v-if="listTypePatients.length>0">
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
          :items="listTypePatients"
          :fields="fields">
        <template #cell(actions)="row">
          <b-button v-b-modal="modal.idEdit" variant="success" @click="getTypePatientById(row.item.id)" class="mx-3">
            Edit
          </b-button>
          <a href="javascript:;" @click="deleteCity(row.item.id)" class="btn btn-danger">Delete</a>
        </template>
        <template #cell(actions)="row">
          <b-button v-b-modal="modal.idEdit" variant="success" @click="getTypePatientById(row.item.id)" class="mx-3">
            Edit
          </b-button>
          <a href="javascript:;" @click.prevent="deleteCity(row.item.id)" class="btn btn-danger">Delete</a>
        </template>
      </b-table>
      <div class="float-right">
        <b-pagination
            v-model="currentPage"
            :total-rows="listTypePatients.length"
            :per-page="perPage"
        ></b-pagination>
      </div>
    </div>
    <div class="py-3 px-5 text-center" v-else>
      <strong class="text-dark">{{ this.messageCityEmpty }}</strong>
    </div>
    <Create
        :id="modal.idCreate"
        :title="modal.titleCreate"
        v-on:CreateTypePatient="updateListTypePatient">
    </Create>
    <Edit
        :id="modal.idEdit"
        :title="modal.titleEdit"
        v-on:UpdateTypePatient="updateListTypePatient"
        :type_patient="typePatient"
    ></Edit>
  </div>

</template>

<script>
import RepositoryFactory from "../../repositories/factory";
import { PAGINATE } from '../../constants/index';
import Create from "./modal/Create";
import Edit from "./modal/Edit";

const type_patients = RepositoryFactory.get('type_patient');
export default {
  components: {
    PAGINATE,
    Create,
    Edit,
  },
  data() {
    return {
      keyword: '',
      messageEmptySearch: '',
      title_page: "Manage Type Patients",
      fields: [
        {
          key: 'id',
          label: "#",
          sortable: true
        },
        {
          key: 'name',
          label: 'Name',
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
      modal: {
        idCreate: 'create-modal',
        titleCreate: 'Create Type Patient',
        idEdit: 'edit-modal',
        titleEdit: 'Edit Type Patient',
      },
      listTypePatients: [],
      typePatient: {},
      messageCityEmpty: '',
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
    this.getDataTypePatient();
  },
  watch: {
    '$route.query': function () {
      this.handleRouter()
    },
  },
  methods: {
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
    updateListTypePatient() {
      this.getDataTypePatient();
    },
    // Get data type patient and search (if has) keyword
    getDataTypePatient: async function () {
      await type_patients.get({ keyword: this.keyword.trim() }).then((response) => {
        this.listTypePatients = response.data;
        this.listTypePatients.length < 1 ? this.messageCityEmpty = this.$t('dataEmpty') : this.messageCityEmpty = '';
        if (this.keyword !== '') {
          this.$router
              .push({ path: '/type_patients', query: { keyword: this.keyword.trim() }, }).catch(() => {
          });
        } else {
          this.$router.push({ path: '/type_patients' }).catch(() => {
          });
        }
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      })
    },
    //Get type patient by id
    getTypePatientById: async function (id) {
      await type_patients.edit(id).then((response) => {
        this.typePatient = response.data;
      }).catch(() => {
        this.makeToast('danger', this.$t('api.loadingFail'));
      });
    },
    // Delete type patient (hard)
    deleteCity: async function (id) {
      if (confirm(this.$t('msgCRUD.msgDelete.confirm'))) {
        await type_patients.delete(id).then(() => {
              this.makeToast('success', this.$t('msgCRUD.msgDelete.success'));
              this.getDataTypePatient();
            }
        ).catch(() => {
          this.makeToast('danger', this.$t('msgCRUD.msgDelete.fail'));
        })
      }
    }
  }
}
</script>

<style scoped>

</style>