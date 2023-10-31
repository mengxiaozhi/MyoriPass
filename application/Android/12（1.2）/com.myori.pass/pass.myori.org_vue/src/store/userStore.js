// src/store/userStore.js
import { defineStore } from 'pinia';

export const useUserStore = defineStore({
    id: 'user',
    state: () => ({
        isLoggedIn: false,  
        userData: null, 
        status: 0,      
    }),
    actions: {
        setUser(data) {
            this.isLoggedIn = true;
            this.userData = data;
        },
        clearUser() {
            this.isLoggedIn = false;
            this.userData = null;
        },
        setStatus(status) {
            this.status = status;
        }
    }
});
