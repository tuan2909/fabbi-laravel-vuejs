import request from "../utlis/request";

const requestURL = '/heal_patients';
export default {

    /**
     *Get data response.
     *
     * @returns {Promise<AxiosResponse<any>>}
     */
    get(params) {
        return request.get(`${requestURL}`, { params: params });
    },
    /**
     *Get data by id.
     * @param id
     * @returns {Promise<AxiosResponse<any>>}
     */
    edit(id) {
        return request.get(`${requestURL}/${id}`)
    },
}