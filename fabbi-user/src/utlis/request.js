import axios from "axios"
import store from "../store"
import { getToken, removeToken } from "./auth";

const service = axios.create({
    baseURL: `http://localhost:8080/api/`, //url= base url + request url
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
    timeout: 10000, //request timeout
})

service.interceptors.request.use(
    (config) => {
        if (store.getters.token) {
            config.headers.Authorization = `Bearer ${getToken()}`
        }

        return config
    },
    (error) => {
        console.log(error)
        return Promise.reject(error)
    },)

service.interceptors.response.use(
    (response) => {
        return response.data
    },
    (error) => {
        console.log(error)
        const {status} = error.response
        if (status === 401) {
            removeToken();
            window.location = '/login'
            return false
        }
        // Handle 401
        // Handle 403
        // Handle 500 ERR999
        // Handle 503
        console.log('err' + error) // for debug
        throw error
        // return Promise.reject(error)
    },
)

export default service