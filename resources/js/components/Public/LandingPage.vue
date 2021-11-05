<template>
    <div class="bg-mycolor min-h-screen max-w-screen overflow-x-hidden overflow-y-hidden">
        <Menu></Menu>
        <router-view></router-view>
        <Footer></Footer>
    </div>
</template>

<script>
import Menu from './Menu'
import Footer from './Footer'
export default {
    components: {
        Menu,Footer
    }
}
</script>
