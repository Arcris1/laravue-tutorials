<script setup>
import { onMounted, ref } from 'vue'
import { fetchTasks, createTask, updateTask, deleteTask } from '@/services/task'
import { toast } from 'vue3-toastify'

const tasks = ref()
const task = ref()
const isLoading = ref(false)

const handleFetchTasks = async () => {
    try {
        isLoading.value = true
        const response = await fetchTasks()

        tasks.value = response.data
    } catch (error) {
        toast('There is a problem fetching tasks, please try again later', {
            autoClose: 1000,
        })
    } finally {
        isLoading.value = false
    }
}

const handleAddTask = async () => {
    if (!task.value) {
        toast('Task field is required', {
            autoClose: 1000,
        })
        return
    }

    isLoading.value = true

    try {
        const response = await createTask({
            task: task.value,
        })

        const statusCode = response.status
        if (statusCode === 201) {
            toast('Task added successfully', {
                autoClose: 1000,
            })

            // Refresh the task list
            handleFetchTasks()
        }
    } catch (error) {
        if (error.response?.data?.task) {
            toast(error.response.data.task, {
                autoClose: 1000,
            })
        } else {
            toast('There is a problem adding the task, please try again later', {
                autoClose: 1000,
            })
        }
    } finally {
        task.value = ''
        isLoading.value = false
    }
}

const handleDelete = async (taskId) => {
    console.log(taskId)

    try {
        const response = await deleteTask(taskId)

        if (response.status === 200) {
            toast(response.data.message, {
                autoClose: 1000,
            })

            // Refresh the task list
            handleFetchTasks()
        }
    } catch (error) {
        console.log(error)
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

const handleTaskUpdate = async (taskId, isDone) => {
    try {
        const response = await updateTask({
            task_id: taskId,
            is_done: isDone,
        })

        if (response.status === 200) {
            toast(response.data.message, {
                autoClose: 1000,
            })
        }
    } catch (error) {
        toast('There is a problem updating the task, please try again later', {
            autoClose: 1000,
        })
    } finally {
        // Refresh the task list
        handleFetchTasks()
    }
}

onMounted(() => {
    handleFetchTasks()
})
</script>

<template>
    <div class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 min-h-screen font-sans">
        <!-- 🌸 Navbar -->
        <nav
            class="bg-white/80 backdrop-blur-lg border-b-4 border-pink-200 shadow-md px-6 py-3 flex justify-between items-center rounded-b-2xl"
        >
            <!-- Left: Logo -->
            <div class="text-2xl font-extrabold text-pink-500 drop-shadow-sm">🎀 KawaiiApp</div>

            <!-- Right: User + Logout -->
            <div class="flex items-center gap-4">
                <span class="text-gray-700 font-medium">
                    Hi, <span class="text-pink-500 font-bold">Cris 🐰</span>
                </span>
                <button
                    class="px-4 py-2 bg-pink-400 text-white rounded-full shadow-md hover:bg-pink-500 transition font-semibold text-sm"
                >
                    🚪 Logout
                </button>
            </div>
        </nav>

        <!-- 🌸 Main Content -->
        <div class="p-6 flex flex-col items-center">
            <h1 class="text-3xl font-bold text-pink-600 mb-2">Welcome back! ✨</h1>
            <p class="text-gray-600 mb-6">Here’s your super kawaii todo list 💖</p>

            <!-- 🐰 Todo App Card -->
            <div
                class="bg-white/80 backdrop-blur-lg shadow-xl rounded-3xl w-full max-w-md p-6 border-4 border-pink-200"
            >
                <!-- Input -->
                <div class="flex gap-2 mb-6">
                    <input
                        v-model="task"
                        type="text"
                        placeholder="✍️ Add a kawaii task..."
                        class="flex-1 px-4 py-3 border-2 border-pink-200 rounded-full focus:ring-2 focus:ring-pink-300 outline-none placeholder-pink-300 text-gray-700 shadow-inner"
                    />

                    <template v-if="!isLoading">
                        <button
                            @click="handleAddTask"
                            class="px-5 py-3 bg-pink-400 text-white rounded-full shadow-md hover:bg-pink-500 transition font-bold text-lg"
                        >
                            ➕
                        </button>
                    </template>
                    <template v-else>
                        <div
                            class="px-5 py-3 bg-pink-400 text-white rounded-full shadow-md font-bold text-lg flex items-center justify-center"
                        >
                            ⏳
                        </div>
                    </template>
                </div>

                <!-- Task List (static for now) -->
                <ul class="space-y-3">
                    <li
                        v-for="task in tasks"
                        :key="task.id"
                        class="flex items-center justify-between bg-gradient-to-r from-pink-100 via-purple-100 to-blue-100 border border-pink-200 p-3 rounded-full shadow-md hover:shadow-lg transition"
                    >
                        <div class="flex items-center gap-3">
                            <input
                                :checked="task.is_done"
                                @change="handleTaskUpdate(task.id, $event.target.checked)"
                                type="checkbox"
                                class="w-6 h-6 accent-pink-400 rounded-full cursor-pointer"
                            />
                            <span
                                class="text-gray-700 font-medium"
                                :class="{ 'line-through': task.is_done }"
                                >{{ task.task }}</span
                            >
                        </div>
                        <button
                            @click="handleDelete(task.id)"
                            class="text-pink-500 hover:text-red-500 transition text-xl"
                        >
                            💔
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
