<template>
    <HeroScene :title="category"></HeroScene>
    <router-link :to="{ name: 'galleriesIndex', query:{category: slug} }">
        <p class="mt-10 sm:text-sm sm:font-extrabold text-gray-900 ml-10 flex font-medium text-xs">
            <RewindIcon class="w-8 h-8 sm:w-10 sm:h-10"></RewindIcon><span class="mt-2">Zpět na seznam galerií</span>
        </p>
    </router-link>
    <div class="relative bg-mycolor max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 mt-5 ">
        <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
            <li v-for="(image, i) in images" :key="i" class="relative cursor-pointer">
                <div @click="openSlider(i)"
                     class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                    <img :src="image.path" :alt="category" class="object-cover pointer-events-none group-hover:opacity-75"/>
                    <ZoomInIcon class="absolute inset-0 opacity-0 group-hover:opacity-70"></ZoomInIcon>
                    <!-- <button type="button" class="absolute inset-0 focus:outline-none">
                        <span class="sr-only">View details for {{ image.name }}</span>
                    </button> -->
                </div>
            </li>
        </ul>
    </div>

    <!-- SLIDER -->
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="fixed z-100 inset-0 overflow-y-auto" @close="open = false">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                 enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity"/>
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="hidden sm:block absolute w-10 h-10 top-5 right-10 pt-4 pr-4 z-100">
                            <button type="button"
                                    class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    @click="open = false">
                                <span class="sr-only">Close</span>
                                <XIcon class="h-8 w-8" aria-hidden="true"/>
                            </button>
                        </div>
                <TransitionChild as="template" enter="ease-out duration-300"
                                 enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                 leave-from="opacity-100 translate-y-0 sm:scale-100"
                                 leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="inline-block align-middle overflow-hidden transform transition-all m-auto w-full max-h-screen pointer-events: none;">
                        <ChevronLeftIcon @click="prev()" class="hidden sm:block absolute left-10 top-1/2 bg-white sm:w-10 sm:h-10 h-3 w-3 z-100"></ChevronLeftIcon>
                        <ChevronRightIcon @click="next()" class="hidden sm:block absolute right-10 top-1/2 bg-white sm:w-10 sm:h-10 h-3 w-3 z-100"></ChevronRightIcon>
                        <div v-touch:swipe="onSwipeItem()" class="m-auto height-slide w-full flex justify-center inline-block align-middle">
                            <img v-for="(image, i) in images" :key="i"
                                :class="[i===index ? 'opacity-1' : 'absolute -left-full -right-full opacity-0' ,'transition duration-3000 active max-w-screen max-h-screen object-cover align-middle']"
                                :src="image.path"
                                alt="Carousel image"/>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
    <Exception :open="showException" :message="message" @close="close"></Exception>
</template>

<script>
import {onMounted, ref} from 'vue'
import {useRouter, useRoute} from 'vue-router'
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {CheckIcon, XIcon, ChevronRightIcon, ChevronLeftIcon,ZoomInIcon,RewindIcon} from '@heroicons/vue/outline'
import anime from 'animejs/lib/anime.es.js'
import api from '../../../services/api'
import HeroScene from '../../HeroScene.vue'
import Exception from '../../Exception.vue'


const animation = anime({
  targets: '.active',
  translateX: 250,
  direction: 'alternate',
  loop: false,
  easing: 'linear'
});

export default {
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        CheckIcon,
        XIcon,
        ChevronRightIcon,
        ChevronLeftIcon,
        HeroScene,
        Exception,
        ZoomInIcon,
        RewindIcon,
    },
    setup() {
        const route = useRoute()
        const router = useRouter()

        const open = ref(false)
        const index = ref(null)
        const image = ref(null)
        const images = ref([])
        const category = ref()
        const slug = ref()

        const showException = ref(false)
        const message = ref()

        onMounted(async () => {
                await api.getGallery(route.params.slug).then(response => {
                    images.value = response.data.images
                    category.value = response.data.title
                    slug.value = response.data.category.slug
                    }
                ).catch(() => (
                    router.push({name: 'homeIndex'})
                ))
            }
        )

        function close(){
            showException.value = false
        }

        function openSlider(i) {
            open.value = true
            index.value = i
        }

        function next(){
            let lastIndex = _.findLastIndex(images.value);
            index.value ++
            if ( lastIndex < index.value ){
                index.value = 0
            }
        }

        function prev(){
            let lastIndex = _.findLastIndex(images.value);
            index.value --
            if ( 0 > index.value ){
                index.value = lastIndex
            }
        }

        function onSwipeItem() {
		return function (direction) {
                if ( direction === "left" || direction === "top" ){
                    next()
                }
                if ( direction === "right" || direction === "bottom"){
                    prev()
                }
            }
        }

        return {
            image,
            open,
            images,
            showException,
            message,
            close,
            openSlider,
            next,
            prev,
            onSwipeItem,
            index,
            category,
            slug
        }
    }
}
</script>
