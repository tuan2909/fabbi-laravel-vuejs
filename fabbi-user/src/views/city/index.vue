<template>
  <div>
    <div class="m-3">
      <h2 class="text-center">{{ title_page }}</h2>
    </div>
    <div class="float-right m-3">
      <router-link to="/cities/create" class="btn btn-success">Create</router-link>
    </div>
    <div v-if="listCities.length>0">
      <b-table
          class="text-center"
          striped
          hover
          :per-page="perPage"
          :current-page="currentPage"
          :items="listCities"
          :fields="fields">
        <template #cell(actions)="row">
          <router-link :to="{ name: 'city_edit', params: { id: row.item.id}}" class="btn btn-primary mx-3">Edit
          </router-link>

          <a href="javascript:;" @click="deleteCity(row.item.id)" class="btn btn-danger">Delete</a>
        </template>
      </b-table>
      <div class="float-right">
        <b-pagination
            v-model="currentPage"
            :total-rows="listCities.length"
            :per-page="perPage"
        ></b-pagination>
      </div>
    </div>
  </div>
</template>

<script>
import RepositoryFactory from "../../repositories/factory";
import { PAGINATE } from '../../constants/index'

const cities = RepositoryFactory.get('city');
export default {
  components: {
    PAGINATE
  },
  data() {
    return {
      title_page: "Manage Cities",
      messageCityEmpty: '',
      listCities: [],
      perPage: PAGINATE.PER_PAGE,
      currentPage: PAGINATE.CURRENT_PAGE,
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
    }
  },
  mounted() {
    this.getDataCities();
  },
  methods: {
    // Get data cities
    getDataCities: async function () {
      await cities.get().then((response) => {
        this.listCities = response.data;
      })
    },
    // Delete cities (hard)
    deleteCity: async function (id) {
      if (confirm('Are you sure want to deleted !')) {
        await cities.delete(id).then(this.getDataCities()
        ).catch(() => {
        })
      }
    }
  }
}
</script>

<style scoped>

</style>