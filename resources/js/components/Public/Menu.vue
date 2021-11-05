<template>
    <div class="min-h-full w-full bg-mycolor" id="hero">
        <header id="navbar" class="bg-mycolor fixed inset-x-0 top-0 z-50 w-screen">
            <div class="relative">
                <div class="flex justify-between items-center max-w-7xl mx-auto py-6 md:justify-start">
                    <div class="flex justify-start lg:w-0 lg:flex-1">
                        <router-link :to="{ name: 'homeIndex', hash: '#home' }">
                            <span class="sr-only">Workflow</span>
                            <img class="h-8 w-auto sm:h-10 m-5" src="/storage/images/initialize/logo.png" alt=""/>
                        </router-link>
                    </div>
                    <div class="-my-2 md:hidden">
                        <div @click="showMenu = true"
                            class="rounded-md p-2 m-5 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Open menu</span>
                            <MenuIcon class="h-6 w-6" aria-hidden="true"/>
                        </div>
                    </div>
                    <nav as="nav" class="hidden md:flex space-x-10">
                        <div class="relative">
                            <button @click="showMenu = !showMenu"
                                :class="[showMenu ? 'text-gray-900' : 'text-gray-500', 'group bg-mycolor rounded-md inline-flex items-center text-base font-medium hover:text-gray-900']">
                                <span>Vyrábíme</span>
                                <ChevronDownIcon
                                    :class="[showMenu ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']"
                                    aria-hidden="true"/>
                            </button>

                            <transition enter-active-class="transition ease-out duration-200"
                                        enter-from-class="opacity-0 translate-y-1"
                                        enter-to-class="opacity-100 translate-y-0"
                                        leave-active-class="transition ease-in duration-150"
                                        leave-from-class="opacity-100 translate-y-0"
                                        leave-to-class="opacity-0 translate-y-1">
                                <nav v-show="showMenu"
                                    class="absolute z-10 -ml-4 mt-3 transform w-screen max-w-md lg:max-w-2xl lg:ml-0 lg:left-1/2 lg:-translate-x-1/2 ">
                                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                        <div
                                            class="relative grid gap-6 bg-mycolor px-5 py-6 sm:gap-8 sm:p-8 lg:grid-cols-2 px-2">
                                            <router-link
                                                v-for="item in solutions"
                                                :key="item.name"
                                                :to="{ name: 'galleriesIndex', query:{category: item.category}, hash: '#hero' }"
                                                class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                                <div
                                                    class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-600 text-white sm:h-12 sm:w-12">
                                                    <component :is="item.icon" class="h-6 w-6" aria-hidden="true"/>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-base font-medium text-gray-900">
                                                        {{ item.name }}
                                                    </p>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        {{ item.description }}
                                                    </p>
                                                </div>
                                            </router-link>
                                        </div>
                                    </div>
                                </nav>
                            </transition>
                        </div>
                        <router-link v-for="item in navigation" :to="{ name: 'homeIndex', hash: item.href }"
                                     :key="item.name" class="text-base font-medium text-gray-500 hover:text-gray-900">
                            {{ item.name }}
                        </router-link>
                    </nav>
                    <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                        <!--
                          !!!!Maybe in the future. Ready for login and user registration!!!!
                          <a href="#" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">
                           Sign in
                         </a>
                         <a href="#" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                           Sign up
                         </a>
                         -->
                    </div>
                </div>

                <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                            enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in"
                            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                    <div v-show="showMenu"
                                  class="absolute z-30 top-0 inset-x-0 px-2 transition transform origin-top-right md:hidden">
                        <div
                            class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-mycolor divide-y-2 divide-gray-50">
                            <div class="pt-5 pb-6">
                                <div class="flex items-center justify-between">
                                    <router-link :to="{ name: 'homeIndex', hash: '#home' }">
                                        <div>
                                            <img class="h-8 w-auto m-5" src="/storage/images/initialize/logo.png" alt="Workflow" />
                                        </div>
                                    </router-link>
                                    <div>
                                        <button @click="showMenu = false"
                                            class="bg-mycolor rounded-md m-5 p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                            <span class="sr-only">Close menu</span>
                                            <XIcon class="h-6 w-6" aria-hidden="true"/>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <nav class="grid grid-cols-1 gap-7 px-2">
                                        <router-link
                                            v-for="item in solutions"
                                            :key="item.name"
                                            :to="{ name: 'galleriesIndex', query:{category: item.category}, hash: '#hero' }"
                                            class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                            <div
                                                class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-md bg-indigo-600 text-white">
                                                <component :is="item.icon" class="h-6 w-6" aria-hidden="true"/>
                                            </div>
                                            <div class="ml-4 text-base font-medium text-gray-900">
                                                {{ item.name }}
                                            </div>
                                        </router-link>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </header>
    </div>
</template>

<script>
import {ref,watch} from 'vue'
import {useRoute} from 'vue-router'
import {
    CheckIcon,
    MenuIcon,
    XIcon,
} from '@heroicons/vue/outline'
import {ChevronDownIcon} from '@heroicons/vue/solid'

const solutions = [
    {
        name: 'Kuchyně',
        description: 'Kuchyně na míru.',
        category: 'kuchyne',
        icon: CheckIcon,
    },
    {
        name: 'Vestavěné skříně',
        description: 'Vestavěné skříně na míru.',
        category: 'vestavene_skrine',
        icon: CheckIcon,
    },
    {
        name: 'Komerční prostory',
        description: "Vybavíme školy, školky, obecní úřády, restaurace, a další.",
        category: 'komercni_prostory',
        icon: CheckIcon
    },
    {
        name: 'Ostatní',
        description: "Pergoly, dveře, přistřešky.",
        category: 'ostatni',
        icon: CheckIcon,
    },
]
const navigation = [
    {name: 'O nás', href: '#about-us'},
    {name: 'Reference', href: '#'},
    {name: 'Kontakt', href: '#contact-as'},
]

export default {
    components: {
        ChevronDownIcon,
        MenuIcon,
        XIcon,
    },
    setup() {
        const showMenu = ref(false);
        const route = useRoute()

        watch(() => route.query.category, (val) => {
            if (val) {
                showMenu.value = false
            }
        });
        return {
            solutions,
            navigation,
            showMenu,
        }
    },
}
</script>

