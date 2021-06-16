import { getToken, setToken, removeToken } from "../../utlis/auth";
import RepositoryFactory from "../../repositories/factory";

const state = {
    token: getToken(),
    info: {
        id: "",
        name: "",
        email: "",
        status: "",
        role: 0,
    },
};

const mutations = {
    SET_TOKEN: (state, token) => {
        state.token = token;
    },
    SET_INFO: (state, info) => {
        state.info = info;
    },
};

const authService = RepositoryFactory.get("auth");

const actions = {
    login({commit}, userInfo) {
        const data = {email: userInfo.email, password: userInfo.password}
        return new Promise((resolve, reject) => {
            axios.post('http://localhost:8080/api/auth/login', data).then((response) => {
                const {data} = response
                commit('SET_TOKEN', data.token)
                setToken(data.token)
                resolve()
            }).catch((error) => {
                reject(error)
            })
            // authService
            //     .login(data)
            //     .then((response) => {
            //         const {data} = response
            //         commit('SET_TOKEN', data.access_token)
            //         commit('SET_INFO', data.Customer)
            //         setToken(data.access_token)
            //         resolve()
            //     })
            //     .catch((error) => {
            //         reject(error)
            //     })
        })
    },
    logout({commit}) {
        return new Promise((resolve, reject) => {
            const authService = RepositoryFactory.get('auth')
            authService
                .logOut()
                .then(() => {
                    commit('SET_TOKEN', '')
                    removeToken()
                    resolve()
                })
                .catch((error) => {
                    reject(error)
                })
        })
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};
