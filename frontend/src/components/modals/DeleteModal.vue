<script setup>
import { deleteTask } from '@/services/task'
import { useModalStore } from '@/stores/modalStore'
import { useRouter } from 'vue-router'
import { toast } from 'vue3-toastify'

const router = useRouter()
const modalStore = useModalStore()

const handleDelete = async () => {
    try {
        const taskId = modalStore.id

        const response = await deleteTask(taskId)

        if (response.status === 200) {
            toast(response.data.message, {
                autoClose: 1000,
            })

            modalStore.isDeleteSuccessfull = true
            modalStore.toggleDeleteModalVisibility()
        }
    } catch (error) {
        modalStore.isDeleteSuccessfull = false
        if (error.response?.data?.message) {
            toast(error.response.data.message, {
                autoClose: 1000,
            })
        } else {
            toast('There is a problem adding the task, please try again later', {
                autoClose: 1000,
            })
        }
    }
}
</script>
<template>
    <div
        v-if="modalStore.isDeleteModalShown"
        class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50"
    >
        <!-- 🌸 Modal Box -->
        <div
            class="bg-white/90 border-4 border-pink-200 rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center animate-bounce"
        >
            <!-- Cute Icon -->
            <div class="text-6xl mb-4">💔🧸</div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-pink-600 mb-2">Delete this? 🌸</h2>

            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Are you sure you want to delete this task? <br />
                It’ll be gone forever… (｡•́︿•̀｡)
            </p>

            <!-- Buttons -->
            <div class="flex justify-center gap-4">
                <button
                    @click="handleDelete"
                    class="px-5 py-2 rounded-full bg-red-400 text-white font-semibold shadow-md hover:bg-red-500 transition"
                >
                    Yes, Delete 💔
                </button>
                <button
                    @click="modalStore.toggleDeleteModalVisibility"
                    class="px-5 py-2 rounded-full bg-gray-200 text-gray-700 font-semibold shadow-md hover:bg-gray-300 transition"
                >
                    Cancel 🐰
                </button>
            </div>
        </div>
    </div>
</template>
