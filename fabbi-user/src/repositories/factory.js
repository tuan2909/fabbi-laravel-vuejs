import AuthRepository from "./auth"
import CityRepository from "./city"
import TypePatientRepository from "./type_patient"

const repositories = {
    auth: AuthRepository,
    city: CityRepository,
    type_patient: TypePatientRepository,
}
export default {
    get: (name) => repositories[name]
}