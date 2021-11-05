import axios from 'axios'
import store from '../store/index'

export const api = axios.create({
    baseURL: process.env.VUE_APP_API_URL,
    withCredentials: true,
});

api.interceptors.request.use((config) => {
    store.dispatch('loadingModule/loading', true)
    return config
}, function (error) {
    store.dispatch('loadingModule/loading', false)
    return Promise.reject(error)
});

api.interceptors.response.use(
    (response) => {
        store.dispatch('loadingModule/loading', false)
        return response
    },
    function (error) {
        store.dispatch('loadingModule/loading', false)
        if (
            [401, 403, 419].includes(error.response.status) &&
            store.getters['userModule/loggedIn']
        ) {
            store.dispatch('userModule/logout')
        }
        return Promise.reject(error)
    }
);

export default {
    async login(payload) {
        await api.get("/sanctum/csrf-cookie")
        return api.post("/login", payload)
    },
    logout() {
        return api.post("/logout")
    },
    getAdminGalleries() {
        return api.get('/api/admin/galleries')
    },
    getAdminGallery(id) {
        return api.get(`/api/admin/galleries/${id}`)
    },
    postGallery(payload) {
        return api.post("/api/admin/galleries", payload, {
            headers: {'Content-Type': 'multipart/form-data'}
        })
    },
    updateGallery(id, payload) {
        return api.post(`/api/admin/galleries/edit/${id}`, payload, {
            headers: {'Content-Type': 'multipart/form-data'}
        })
    },
    deleteGallery(id) {
        return api.delete(`/api/admin/galleries/${id}`)
    },
    getGalleries(category){
        return api.get(`/api/galleries?category=${category}`)
    },
    getGallery(slug){
        return api.get(`/api/galleries/${slug}`)
    },
    contact(payload) {
        return api.post("/api/contact", payload)
    }
};
