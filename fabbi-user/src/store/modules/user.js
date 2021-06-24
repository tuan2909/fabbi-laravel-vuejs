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
};

const authService = RepositoryFactory.get("auth");

const actions = {
    signup({ commit }, userInfo) {
        console.log(userInfo)
        const data = {
            name: userInfo.name,
            email: userInfo.email,
            password: userInfo.password,
            password_confirmation: userInfo.password_confirmation,
            role: userInfo.role,
            status: userInfo.status
        }
        return new Promise((resolve, reject) => {
            authService.signup(data).then(() => {
                resolve();
            }).catch((error) => {
                reject(error);
            });
        });
    },
    login({ commit }, userInfo) {
        const data = { email: userInfo.email, password: userInfo.password }
        return new Promise((resolve, reject) => {
            authService
                .login(data)
                .then((response) => {
                    const { token } = response;
                    commit('SET_TOKEN', token);
                    setToken(token);
                    resolve();
                })
                .catch((error) => {
                    reject(error);
                })
        })
    },
    logout({ commit }) {
        return new Promise((resolve, reject) => {
            authService
                .logout()
                .then(() => {
                    commit('SET_TOKEN', '');
                    removeToken();
                    resolve();
                })
                .catch((error) => {
                    reject(error);
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
