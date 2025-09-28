<script setup>
import { onMounted, ref } from 'vue'
import { toast } from 'vue3-toastify'
import { useRouter } from 'vue-router'

import { loginUser } from '@/services/auth'
import { setAuthToken } from '@/config/axiosConfig'

const router = useRouter()

const email = ref()
const password = ref()
const isLoading = ref(false)

const handleLogin = async () => {
    isLoading.value = true
    try {
        const response = await loginUser({
            email: email.value,
            password: password.value,
        })

        setAuthToken(response.data?.token)

        toast('Login successful! Redirecting...', {
            autoClose: 1000,
        })

        // Redirect to homepage
        router.push('/')
    } catch (error) {
        if (error.response?.data?.message) {
            toast(error.response.data.message, {
                autoClose: 1000,
            })
        } else {
            toast('There is a problem with your network, please try again later', {
                autoClose: 1000,
            })
        }
    } finally {
        isLoading.value = false
    }
}
</script>
<template>
    <div
        class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 min-h-screen flex items-center justify-center p-4 font-sans"
    >
        <div
            class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl w-full max-w-sm p-8 border-4 border-pink-200"
        >
            <!-- Header -->
            <h1 class="text-4xl font-extrabold text-center text-pink-500 mb-2 drop-shadow-sm">
                🎀 Welcome Back 🎀
            </h1>
            <p class="text-center text-gray-500 mb-6 text-sm">
                Log in to continue your kawaii journey ✨
            </p>

            <!-- Form -->
            <form @submit.prevent="handleLogin" class="space-y-4">
                <div>
                    <input
                        v-model="email"
                        type="email"
                        placeholder="📧 Email"
                        class="w-full px-4 py-3 border-2 border-pink-200 rounded-full focus:ring-2 focus:ring-pink-300 outline-none placeholder-pink-300 shadow-inner"
                    />
                </div>
                <div>
                    <input
                        v-model="password"
                        type="password"
                        placeholder="🔑 Password"
                        class="w-full px-4 py-3 border-2 border-pink-200 rounded-full focus:ring-2 focus:ring-pink-300 outline-none placeholder-pink-300 shadow-inner"
                    />
                </div>
                <template v-if="!isLoading">
                    <button
                        type="submit"
                        class="w-full bg-pink-400 text-white py-3 rounded-full shadow-md hover:bg-pink-500 transition font-bold text-lg"
                    >
                        💖 Login
                    </button>
                </template>
                <template v-else>
                    <div
                        class="w-full bg-pink-400 text-white py-3 rounded-full shadow-md font-bold text-lg flex items-center justify-center"
                    >
                        <svg
                            class="animate-spin h-5 w-5 mr-3 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0a12 12 0 00-9.33 19.36l-1.4-1.4A8 8 0 014 12z"
                            ></path>
                        </svg>
                        Loading........
                    </div>
                </template>
            </form>

            <!-- Footer -->
            <p class="text-center text-sm text-gray-600 mt-4">
                Don't have an account?
                <router-link to="/register" class="text-pink-500 font-semibold hover:underline"
                    >Sign up 🌸</router-link
                >
            </p>
        </div>
    </div>
</template>
