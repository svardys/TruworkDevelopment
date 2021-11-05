import {createStore} from 'vuex'
import createPersistedState from 'vuex-persistedstate'

import userModule from './modules/user'
import loadingModule from './modules/loading'

const store = createStore(
    {
        plugins: [createPersistedState({
            paths: ['userModule']
        })],
        modules: {
            userModule,
            loadingModule
        },
    }
)

export default store
