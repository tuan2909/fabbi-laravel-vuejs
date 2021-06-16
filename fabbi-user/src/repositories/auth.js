import request from "../utlis/request";

export default {
    /**
     * @param payload
     *
     * @returns {Promise<AxiosResponse<any>>}
     */
    async login(payload) {
        return await request.post('/auth/login', payload);
    },
    /**
     *
     * @returns {Promise<AxiosResponse<any>>}
     */
    async logout() {
        return await request.post('/logout')
    },
}
