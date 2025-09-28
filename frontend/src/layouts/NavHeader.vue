<script setup>
import { useUserStore } from '@/stores/userStore'

const userStore = useUserStore()
</script>

<template>
    <nav
        class="bg-white/80 backdrop-blur-lg border-b-4 border-pink-200 shadow-md px-6 py-3 flex justify-between items-center rounded-b-2xl"
    >
        <!-- Left: Logo -->
        <router-link to="/" class="text-2xl font-extrabold text-pink-500 drop-shadow-sm"
            >🎀 KawaiiApp</router-link
        >

        <!-- Right: User + Logout -->
        <div class="flex items-center gap-4">
            <span class="text-gray-700 font-medium">
                Hi,
                <router-link to="/profile" class="text-pink-500 font-bold"
                    >{{ userStore.userInfo?.name }} 🐰</router-link
                >
            </span>
            <button
                @click="userStore.toggleLogoutModal"
                class="px-4 py-2 bg-pink-400 text-white rounded-full shadow-md hover:bg-pink-500 transition font-semibold text-sm"
            >
                🚪 Logout
            </button>
        </div>
    </nav>
</template>
