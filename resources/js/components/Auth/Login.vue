<template>
    <div class="h-screen bg-gray-50 flex flex-col justify-center py-5 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-12 w-auto"
                 src="/storage/images/initialize/logo.png"
                 alt="logo">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Přihlášení
            </h2>
        </div>
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form @submit.prevent="login" class="space-y-6">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div class="mt-1 relative">
                        <input v-model="form.email" id="email" name="email" type="email"
                               autocomplete="email" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               aria-describedby="email-error"/>
                        <div
                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                            v-if="form.errors.has('email')">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-1 text-sm text-red-600" id="email-error"
                         v-if="form.errors.has('email')"
                         v-text="form.errors.get('email')"></div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Heslo
                    </label>
                    <div class="mt-1">
                        <input v-model="form.password" id="password" name="password"
                               type="password" autocomplete="current-password" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                    </div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Přihlásit se
                    </button>
                </form>
            </div>
        </div>
    </div>
    <Exception :open="showException" :message="message" @close="close"></Exception>
</template>

<script>
import {reactive, ref} from 'vue'
import {useStore} from 'vuex'
import {useRouter} from 'vue-router'
import Form from '../../utilities/form'
import Exception from '../Exception'

export default {
    components: {
        Exception
    },
    setup() {
        const store = useStore()
        const router = useRouter()

        const form =
            reactive(new Form({
                email: null,
                password: null,
                rememberMe: true
            }))

        const showException = ref(false)
        const message = ref()

        async function login() {
            await store.dispatch('userModule/login', form.objectToFormData())
                .then(() => {
                    form.onSuccess()
                    router.push({name: 'adminGalleryIndex'})
                }).catch(error => {
                    if (error.response.data.errors) {
                        form.onFail(error.response.data.errors)
                    } else {
                        showException.value = true
                        message.value = error.response.data.message
                    }
                })
        }

        function close() {
            showException.value = false
        }

        return {
            form,
            showException,
            message,
            login,
            close
        }
    }
}
</script>
