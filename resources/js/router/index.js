import {createWebHistory, createRouter} from 'vue-router'
import store from '../store'

//Components
import LandingPage from '../components/Public/LandingPage'
import HomeIndex from '../components/Public/Home/Index'
import GalleryIndex from '../components/Public/Gallery/Index'
import GalleryShow from '../components/Public/Gallery/Show'

import Login from '../components/Auth/Login'

import AdminPage from '../components/Admin/AdminPage'
import DashboardIndex from '../components/Admin/Dashboard/Index'
import AdminGalleryIndex from '../components/Admin/Gallery/Index'
import AdminGalleryEdit from '../components/Admin/Gallery/Edit'
import AdminGalleryCreate from '../components/Admin/Gallery/Create'

//Routes
const routes = [
    {
        path: '/',
        component: LandingPage,
        children: [
            {
                path: '',
                name: 'homeIndex',
                component: HomeIndex
            },
            {
                path: 'galleries',
                name: 'galleriesIndex',
                component: GalleryIndex
            },
            {
                path: 'galleries/:slug',
                name: 'galleriesShow',
                component: GalleryShow
            }
        ]
    },
    {
        path: '/login',
        name: 'authLogin',
        component: Login,
        meta: {
            guest: true
        }
    },
    {
        path: '/admin',
        component: AdminPage,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '',
                name: 'dashboardIndex',
                component: DashboardIndex,
            },
            {
                path: 'galleries',
                name: 'adminGalleryIndex',
                component: AdminGalleryIndex,
            },
            {
                path: 'galleries/create',
                name: 'adminGalleryCreate',
                component: AdminGalleryCreate,
            },
            {
                path: 'galleries/edit/:id',
                name: 'adminGalleryEdit',
                component: AdminGalleryEdit,
            }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
          return savedPosition
        }
        if (to.hash) {
          return { el: to.hash }
        }
        return { x: 0, y: 0 }
    }
})

router.beforeEach((to, from, next) => {

    const loggedIn = store.getters['userModule/loggedIn']

    const canNavigate = to.matched.some(() => {
        if (!loggedIn && to.meta.requiresAuth) {
            return false
        } else return !(loggedIn && to.meta.guest)
    })

    if (!canNavigate) {
        return next('/')
    } else {
        next()
    }
})

export default router
