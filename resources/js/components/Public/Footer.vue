<template>
<footer id="footer" class="relative bg-mycolor clear-both h-50">
<h2 id="footer-heading" class="sr-only">Footer</h2>
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-8 xl:col-span-1">
            <img class="h-10" src="/storage/images/initialize/logo.png" alt="logo_truwork" />
            <p class="text-gray-500 text-base">
                Zakázková výroba na míru.
            </p>
            <div class="flex space-x-6">
                <a class="text-gray-400 hover:text-gray-500">
                <!-- social icons -->
                </a>
            </div>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
            <div class="md:grid md:grid-cols-2 md:gap-8">
                <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                    Adresa
                </h3>
                <ul role="list" class="mt-4 space-y-4">
                    <li>
                        <p href="#" class="text-base text-gray-500">
                            Jeseník 790 00, Astur 185
                        </p>
                    </li>
                </ul>
                </div>
                <div class="mt-12 md:mt-0">
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                    Telefon
                </h3>
                <ul role="list" class="mt-4 space-y-4">
                    <li>
                        <p href="" class="text-base text-gray-500">
                            608 333 070
                        </p>
                    </li>
                </ul>
                </div>
            </div>
            <div class="md:grid md:grid-cols-2 md:gap-8">
                <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                    Telefon
                </h3>
                <ul role="list" class="mt-4 space-y-4">
                    <li>
                        <p href="#" class="text-base text-gray-500">
                            607 238 514
                        </p>
                    </li>
                </ul>
                </div>
                <div class="mt-12 md:mt-0">
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                    Email
                </h3>
                <ul role="list" class="mt-4 space-y-4">
                    <li>
                        <p class="text-base text-gray-500">
                            truwork@truwork.cz
                        </p>
                    </li>
                </ul>
                </div>
            </div>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-200 pt-8">
            <p class="text-base text-gray-400 text-center">
            &copy; 2021 Truwork S.R.O. Všechna práva vyhrazena.
            </p>
            <div v-if="loggedIn">
                <p class="text-base text-gray-400 text-center mt-2">
                    Přihlášen uživatel <span class="text-indigo-600 font-medium hover:text-indigo-700 text-base text-center">{{user}}</span>
                </p>
                <div>
                    <router-link :to="{ name: 'adminGalleryIndex' }">
                        <p class="text-base text-indigo-600 text-center mt-2">
                            Admin rozhraní
                        </p>
                    </router-link>
                    <Logout class="text-base text-red-900 text-center mt-2"></Logout>
                </div>
            </div>
            <div v-else>
                <router-link :to="{ name: 'authLogin' }" class="cursor-pointer">
                    <p class="text-base text-gray-900 text-center mt-2 cursor-pointer">
                        Přihlásit se
                    </p>
                </router-link>
            </div>
        </div>
    </div>
</footer>
</template>

<script>
import {computed} from 'vue'
import {useStore} from 'vuex'
import Logout from '../Auth/Logout'

export default {
    components: {
        Logout
    },
    setup() {
        const store = useStore()
        const user = computed(() => store.getters['userModule/user'])
        const loggedIn = computed(() => store.getters['userModule/loggedIn'])

        return {
            user,
            loggedIn
        }
    },
}
</script>
