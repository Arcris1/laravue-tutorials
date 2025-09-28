<script setup>
import { onMounted, ref } from 'vue'
import { toast } from 'vue3-toastify'

import { registerUser } from '@/services/auth'

const name = ref()
const email = ref()
const password = ref()
const isLoading = ref(false)

const handleRegister = async () => {
    isLoading.value = true
    try {
        const response = await registerUser({
            name: name.value,
            email: email.value,
            password: password.value,
        })

        console.log(response.data)

        const statusCode = response.status
        if (statusCode === 201) {
            toast('Account created successfully', {
                autoClose: 1000,
            })
        }
    } catch (error) {
        if (error.response?.data) {
            toast(error.response?.data?.email, {
                autoClose: 1000,
            })
        } else {
            toast('There is a problem creating an account, please try again later', {
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
        class="bg-gradient-to-br from-blue-100 via-pink-100 to-purple-100 min-h-screen flex items-center justify-center p-4 font-sans"
    >
        <div
            class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl w-full max-w-sm p-8 border-4 border-purple-200"
        >
            <!-- Header -->
            <h1 class="text-4xl font-extrabold text-center text-purple-500 mb-2 drop-shadow-sm">
                🌷 Join Us 🌷
            </h1>
            <p class="text-center text-gray-500 mb-6 text-sm">
                Create a kawaii account and be part of the magic ✨
            </p>

            <!-- Form -->
            <form @submit.prevent="handleRegister" class="space-y-4">
                <div>
                    <input
                        v-model="name"
                        type="text"
                        placeholder="🐰 Your Name"
                        class="w-full px-4 py-3 border-2 border-purple-200 rounded-full focus:ring-2 focus:ring-purple-300 outline-none placeholder-purple-300 shadow-inner"
                    />
                </div>
                <div>
                    <input
                        v-model="email"
                        type="email"
                        placeholder="📧 Email"
                        class="w-full px-4 py-3 border-2 border-purple-200 rounded-full focus:ring-2 focus:ring-purple-300 outline-none placeholder-purple-300 shadow-inner"
                    />
                </div>
                <div>
                    <input
                        v-model="password"
                        type="password"
                        placeholder="🔑 Password"
                        class="w-full px-4 py-3 border-2 border-purple-200 rounded-full focus:ring-2 focus:ring-purple-300 outline-none placeholder-purple-300 shadow-inner"
                    />
                </div>
                <template v-if="!isLoading">
                    <button
                        type="submit"
                        class="w-full bg-purple-400 text-white py-3 rounded-full shadow-md hover:bg-purple-500 transition font-bold text-lg"
                    >
                        🌸 Register
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
                Already have an account?
                <router-link to="/login" class="text-purple-500 font-semibold hover:underline"
                    >Login 💖</router-link
                >
            </p>
        </div>
    </div>
</template>
