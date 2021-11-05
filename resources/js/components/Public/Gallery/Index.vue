<template>
    <HeroScene :title="category"></HeroScene>
    <h1 class="mt-10 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl text-center"> Ukázka naší práce</h1>
    <div class="relative bg-mycolor max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 mt-5">
        <ul role="list" class="grid grid-cols-2 gap-x-3 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-3 xl:gap-x-8">
            <li v-for="(gallery, i) in galleries" :key="i" class="relative">
                <router-link :to="{ name: 'galleriesShow', params: {slug: gallery.slug } }" class="w-full h-full">
                    <div
                        class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                        <img :src="gallery.thumbnail[0].path" :alt="category"
                             class="object-cover pointer-events-none group-hover:opacity-75"/>
                        <EyeIcon class="absolute inset-0 opacity-0 group-hover:opacity-70"></EyeIcon>
                    </div>
                    <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">
                        {{ gallery.title }}
                    </p>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
import {onMounted, ref, watch} from 'vue'
import {useRoute, useRouter} from 'vue-router'
import api from '../../../services/api'
import HeroScene from '../../HeroScene.vue'
import {EyeIcon} from '@heroicons/vue/outline'

export default {
    components: {
        HeroScene,
        EyeIcon,
    },
    setup() {
        const route = useRoute()
        const router = useRouter()
        const galleries = ref([])
        const category = ref()

        async function callApi() {
            await api.getGalleries(route.query.category).then(response => {
                    galleries.value = response.data
                    category.value = response.data[0].category.name
                }
            ).catch(() => (
                router.push({name: 'homeIndex'})
            ))
        }

        onMounted(() => {
            callApi()
        })

        watch(() => route.query.category, (val) => {
            if (val) {
                callApi()
            }
        });

        return {
            galleries,
            category,
        }
    },
}
</script>
