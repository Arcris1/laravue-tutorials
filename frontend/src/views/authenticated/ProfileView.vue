<script setup>
import { onMounted, ref } from 'vue'
import { fetchTasks, createTask, updateTask, deleteTask } from '@/services/task'
import { toast } from 'vue3-toastify'
import dayjs from 'dayjs'

import NavHeader from '@/layouts/NavHeader.vue'

import { useUserStore } from '@/stores/userStore'

const userStore = useUserStore()

// Format date to a human readable format
const formatDateToHumanReadable = (dateString) => {
    return dayjs(dateString).format('MMMM D, YYYY h:mm A')
}
</script>

<template>
    <div class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 min-h-screen font-sans">
        <!-- 🌸 Navbar -->
        <NavHeader />

        <!-- 🌸 Main Content -->
        <div class="p-6 flex flex-col items-center">
            <h1 class="text-3xl font-bold text-pink-600 mb-2">
                Welcome back! {{ userStore.userInfo?.name }} 💖 ✨
            </h1>
            <p class="text-gray-600 mb-6">Here’s your super kawaii profile 💖</p>

            <div
                class="bg-white/80 backdrop-blur-lg shadow-xl rounded-3xl w-full max-w-md p-6 border-4 border-pink-200"
            >
                <!-- About User -->
                <!-- Name -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-pink-500 mb-2">Name</h2>
                    <p class="text-gray-700">{{ userStore.userInfo?.name }}</p>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-pink-500 mb-2">Email</h2>
                    <p class="text-gray-700">{{ userStore.userInfo?.email }}</p>
                </div>

                <!-- Date Created -->
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-pink-500 mb-2">Date Created</h2>
                    <p class="text-gray-700">
                        {{ formatDateToHumanReadable(userStore.userInfo?.created_at) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
