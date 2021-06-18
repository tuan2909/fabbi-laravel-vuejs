import request from "../utlis/request";

const requestURL = '/cities'
export default {

    /**
     *Get data  cities response.
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

    /**
     * Create new data.
     *
     * @param payload
     * @returns {Promise<AxiosResponse<any>>}
     */
    create(payload) {
        return request.post(`${requestURL}`, payload)
    },

    /**
     *Update data dât by id.
     *
     * @param payload
     * @param id
     * @returns {Promise<AxiosResponse<any>>}
     */
    update(payload, id) {
        return request.put(`${requestURL}/${id}`, payload)
    },

    /**
     *Remove data by id.
     *
     * @param id
     * @returns {Promise<AxiosResponse<any>>}
     */
    delete(id) {
        return request.delete(`${requestURL}/${id}`)
    }
}