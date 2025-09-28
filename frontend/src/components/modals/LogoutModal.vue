<script setup>
import { useUserStore } from '@/stores/userStore'
import { useRouter } from 'vue-router'
import { toast } from 'vue3-toastify'

const router = useRouter()
const userStore = useUserStore()

const handleLogout = async () => {
    try {
        const response = await userStore.handleLogout()

        if (response.status === 200) {
            toast('Successfully logged out!', {
                autoClose: 1000,
            })

            router.push('/login')
        }
    } catch (error) {
        toast('Failed to logout!', {
            autoClose: 1000,
        })
    }
}
</script>

<template>
    <div
        v-if="userStore.isLogoutModalShown"
        class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50"
    >
        <!-- 🌸 Modal Box -->
        <div
            class="bg-white/90 border-4 border-pink-200 rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center"
        >
            <!-- Cute Icon -->
            <div class="text-6xl mb-4">🐰💔</div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-pink-600 mb-2">Leaving already? 🌸</h2>

            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Are you sure you want to logout? <br />
                We’ll miss you… (｡•́︿•̀｡)
            </p>

            <!-- Buttons -->
            <div class="flex justify-center gap-4">
                <button
                    @click="handleLogout"
                    class="px-5 py-2 rounded-full bg-pink-400 text-white font-semibold shadow-md hover:bg-pink-500 transition"
                >
                    Yes, Logout 🚪
                </button>
                <button
                    @click="userStore.toggleLogoutModal"
                    class="px-5 py-2 rounded-full bg-gray-200 text-gray-700 font-semibold shadow-md hover:bg-gray-300 transition"
                >
                    Stay 💖
                </button>
            </div>
        </div>
    </div>
</template>
