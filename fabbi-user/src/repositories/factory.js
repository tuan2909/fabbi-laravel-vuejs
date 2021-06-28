import AuthRepository from "./auth"
import CityRepository from "./city"
import TypePatientRepository from "./type_patient"
import PatientRepository from "./patient"
import UserRepository from "./user_custom"
import HealPatientRepository from "./heal_patient_custom"

const repositories = {
    auth: AuthRepository,
    city: CityRepository,
    type_patient: TypePatientRepository,
    patient: PatientRepository,
    user: UserRepository,
    heal_patient: HealPatientRepository,
}
export default {
    get: (name) => repositories[name]
}