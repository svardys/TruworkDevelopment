<template>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 pb-8 sm:px-6 md:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">Galerie - Tvorba</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <form @submit.prevent="submit" class="space-y-8 divide-y divide-gray-200">
                <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                    <div>
                        <div>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Vyplňte všechny pole na formuláři</p>
                        </div>
                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Název
                                    galerie</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="max-w-lg flex rounded-md shadow-sm">
                                        <input v-model="form.title" type="text" name="title" id="title"
                                               autocomplete="title"
                                               class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-md sm:text-sm border-gray-300"
                                               required/>
                                    </div>
                                    <div class="mt-1 text-sm text-red-600" v-if="form.errors.has('title')"
                                         v-text="form.errors.get('title')"></div>
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Kategorie</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <select v-model="form.category" id="category" name="category"
                                                class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md"
                                                required>
                                            <option value="1">Kuchyně</option>
                                            <option value="2">Vestavěné skříně</option>
                                            <option value="3">Komerční prostory</option>
                                            <option value="4">Ostatní</option>
                                        </select>
                                        <div class="mt-1 text-sm text-red-600" v-if="form.errors.has('category')"
                                             v-text="form.errors.get('category')"></div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Úvodní
                                    obrázek</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div id="thumbn"
                                         class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                         @dragover="dragover" @dragleave="dragleave" @drop="drop">
                                        <div class="space-y-1 text-center">
                                            <div v-if="thumbnailPreview" @click="remove('thumb')"
                                                 class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                                <img :src="thumbnailPreview" alt=""
                                                     class="object-cover pointer-events-none group-hover:opacity-75"/>
                                                <XIcon
                                                    class="absolute inset-0 visible w-full z-10 cursor-pointer text-gray-900 opacity-0 group-hover:opacity-100"></XIcon>
                                            </div>
                                            <svg v-else class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                 fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="thumbnail"
                                                       class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Nahrát soubor</span>
                                                    <input ref="thumbnailUploader" @click="resetThumbnail"
                                                           @change="showThumbnail" id="thumbnail" name="thumbnail"
                                                           type="file" class="sr-only" accept="image/png, image/jpeg"/>
                                                </label>
                                                <p class="pl-1">Může se sem i přetáhnout</p>
                                            </div>
                                            <p class="text-xs text-gray-500">Pouze formát: PNG, JPG</p>
                                        </div>
                                    </div>
                                    <div class="mt-1 text-sm text-red-600" v-if="form.errors.has('thumbnail')"
                                         v-text="form.errors.get('thumbnail')">
                                    </div>
                                </div>
                            </div>
                            <div
                                class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label
                                    class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Další
                                    obrázky</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div id="image"
                                         class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
                                         @dragover="dragover" @dragleave="dragleave" @drop="drop">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                 fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="images"
                                                       class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Nahrát soubor</span>
                                                    <input ref="imagesUploader" @click="resetImages"
                                                           @change="showImages" id="images" name="images" type="file"
                                                           multiple accept="image/png, image/jpeg" class="sr-only"/>
                                                </label>
                                                <p class="pl-1">Může se sem i přetáhnout</p>
                                            </div>
                                            <p class="text-xs text-gray-500">Pouze formát: PNG, JPG</p>
                                        </div>
                                    </div>
                                    <div class="mt-1 text-sm text-red-600" v-if="form.errors.has('images')"
                                         v-text="form.errors.get('images')">
                                    </div>
                                    <div v-for="(image, index) in form.images" :key="index">
                                        <div class="mt-1 text-sm text-red-600" v-if="form.errors.has(`images.${index}`)"
                                             v-text="form.errors.get(`images.${index}`)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul role="list"
                                class="grid grid-cols-5 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-10 xl:gap-x-8 mt-5">
                                <li v-for="(image, key) in imagesPreview" :key="key" @click="remove(key)"
                                    class="relative">
                                    <div
                                        class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                                        <img :src="image.path" alt=""
                                             class="object-cover pointer-events-none group-hover:opacity-75"/>
                                        <XIcon
                                            class="absolute inset-0 visible w-full z-10 cursor-pointer text-gray-900 opacity-0 group-hover:opacity-100"></XIcon>
                                    </div>
                                    <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">
                                        {{ image.name }}</p>
                                    <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                                        {{ parseFloat(image.size / 1024 / 1024).toFixed(2) }} MB</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button @click="reset" type="button"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Zrušit
                        </button>
                        <button type="submit"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Uložit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <Exception :open="showException" :message="message" @close="close"></Exception>
</template>


<script>
import {reactive, ref} from 'vue'
import {useRouter} from 'vue-router'
import {XIcon} from '@heroicons/vue/outline'
import api from '../../../services/api'
import Form from '../../../utilities/form'
import Exception from '../../Exception.vue'

export default {
    components: {
        XIcon,
        Exception
    },
    setup() {
        const router = useRouter()

        const thumbnailUploader = ref(null)
        const imagesUploader = ref(null)

        const thumbnailPreview = ref(null)
        const imagesPreview = ref([])

        const form = reactive(new Form({
            title: null,
            category: null,
            thumbnail: null,
            images: []
        }))

        const showException = ref(false)
        const message = ref()

        function showThumbnail(e) {
            let selectedFile
            let typeFile

            if (e.target.files === undefined) {
                selectedFile = e.dataTransfer.files[0]
                typeFile = e.dataTransfer.files[0].type
            } else {
                selectedFile = e.target.files[0]
                typeFile = e.target.files[0].type
            }
            if (typeFile === ('image/jpeg' || 'image/jgp' || 'image||png')) {
                thumbnailPreview.value = URL.createObjectURL(selectedFile)
                form.thumbnail = selectedFile
            }
            else
            {
              alert('Nahrát lze pouze soubory typu image. jpeg jpg png')
            }
        }

        function showImages(e) {
            let selectedFiles

            if (e.target.files === undefined) {
                selectedFiles = e.dataTransfer.files
            } else {
                selectedFiles = e.target.files
            }
            for (let i = 0; i < selectedFiles.length; i++) {
                if (selectedFiles[i].type === 'image/jpeg' || 'image/jgp' || 'image||png') {
                    let img = {
                        path: URL.createObjectURL(selectedFiles[i]),
                        name: selectedFiles[i].name,
                        size: selectedFiles[i].size
                    }
                    imagesPreview.value.push(img)
                    form.images.push(selectedFiles[i])
                }
            }
        }

        function resetThumbnail() {
            thumbnailUploader.value.value = null
        }

        function resetImages() {
            imagesUploader.value.value = null
        }

        function reset() {
            form.reset()
            resetThumbnail()
            resetImages()
            thumbnailPreview.value = null
            imagesPreview.value = []
        }

        function submit() {
            api.postGallery(form.objectToFormData())
                .then(response => {
                    form.onSuccess()
                    resetThumbnail()
                    resetImages()
                    thumbnailPreview.value = null
                    imagesPreview.value = []
                    router.push({name: 'galleriesShow', params: {slug: response.data.slug}})
                }).catch(error => {
                if (error.response.data.errors) {
                    form.onFail(error.response.data.errors)
                } else {
                    showException.value = true
                    message.value = error.response.data.message
                }
            })
        }

        function close(){
            showException.value = false
        }

        //Drag AND Drop
        function remove(i) {
            if (i === 'thumb') {
                form.thumbnail = null
                thumbnailPreview.value = null
            } else {
                form.images.splice(i, 1)
                imagesPreview.value.splice(i, 1)
            }
        }

        function dragover(event) {
            event.preventDefault()
            if (!event.currentTarget.classList.contains('bg-green-300')) {
                event.currentTarget.classList.remove('bg-white')
                event.currentTarget.classList.add('bg-green-300')
            }
        }

        function dragleave(event) {
            event.currentTarget.classList.add('bg-white')
            event.currentTarget.classList.remove('bg-green-300')
        }

        function drop(event) {
            event.preventDefault()
            if (event.target.id === 'image') {
                showImages(event)
            } else {
                showThumbnail(event)
            }
            event.currentTarget.classList.add('bg-white')
            event.currentTarget.classList.remove('bg-green-300')
        }

        return {
            form,
            thumbnailUploader,
            imagesUploader,
            thumbnailPreview,
            imagesPreview,
            showException,
            message,
            resetThumbnail,
            resetImages,
            showThumbnail,
            showImages,
            reset,
            submit,
            close,
            drop,
            dragleave,
            dragover,
            remove,
            XIcon
        }
    }
}
</script>
