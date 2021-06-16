import AuthRepository from "./auth"

const repositories = {
    auth: AuthRepository,
}
export default {
    get: (name) => repositories[name]
}