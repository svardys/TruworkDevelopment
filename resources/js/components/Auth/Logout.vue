<template>
    <p @click="logout" class="cursor-pointer">
        Odhlásit se
    </p>
</template>

<script>
import {useStore} from 'vuex'
export default {
    setup() {
        const store = useStore()
        async function logout(){
            await store.dispatch('userModule/logout')
        }
        return {
            logout
        }
    }
};
</script>
