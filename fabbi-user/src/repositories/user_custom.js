import request from "../utlis/request";

const requestURL = '/users';
export default {

    /**
     *Get data response.
     *
     * @returns {Promise<AxiosResponse<any>>}
     */
    get(params) {
        return request.get(`${requestURL}`, { params: params });
    },

}