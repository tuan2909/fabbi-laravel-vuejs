import AuthRepository from "./auth"
import CityRepository from "./city"

const repositories = {
    auth: AuthRepository,
    city: CityRepository,
}
export default {
    get: (name) => repositories[name]
}