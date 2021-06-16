import router from "./router/index";
import { getToken } from "./utlis/auth";

const whiteList = [
    '/login'
]

router.beforeEach(async (to, from, next) => {
    const hasToken = getToken();
    if (hasToken) {
        // If is logged in, redirect to the next page
        if (to.path === '/login') {
            next({path: '/'})
        } else {
            next()
        }
    } else {
        // Has no token
        if (whiteList.indexOf(to.path) !== -1) {
            next()
        } else {
            next(`/login?redirect=${to.path}`)
        }
    }
})
router.afterEach(() => {
})