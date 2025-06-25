<template>

    <div class="mb-2 text-[#333] font-bold">
        {{ ___('To Do List') }}
    </div>
    <form @submit.prevent="createApi()" class="w-full flex items-center mb-2">
        <input type="text" name="todo" v-model="formData.task"
               class="w-full border border-gray-300 outline-0 duration-500 focus-within:border-[#3B497E] block h-[45px] px-4 rounded-xl me-2"
               :class="{ 'border-rose-600' : error?.task }" autocomplete="new-to-do" :placeholder="___('Enter what to do')"/>
        <button type="submit" class="cursor-pointer min-h-[45px] max-h-[45px] max-w-[45px] min-w-[45px] text-[14px] font-medium bg-[#21306b] duration-500 hover:bg-[#3B497E] inline-flex justify-center items-center text-white rounded-[0.625rem]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                 stroke="currentColor" class="size-[20px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
        </button>
    </form>
    <template v-if="taskData.length > 0">
        <div class="w-full min-h-[350px] max-h-[350px] overflow-y-auto">
            <div v-for="(each, index) in taskData" :key="index" class="w-full flex items-center justify-between mb-1">
                <div class="font-medium w-full">
                    <label :for="`check-`+index" class="flex justify-start items-center">
                        <input type="checkbox" :id="`check-`+index" name="status" @change="statusApi(each)"
                               class="hidden" autocomplete="off"/>
                        <span class="inline-flex justify-center items-center size-[25px] border rounded-md"
                              :class="{ 'bg-[#21306b] border-[#21306b]': each.status === 'completed', 'bg-transparent border-gray-300': each.status === 'incomplete' }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                             class="size-[15px] stroke-white"
                             :class="{ 'visible': each.status === 'completed', 'invisible': each.status === 'incomplete' }">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                    </span>
                        <span class="ms-2 relative ps-2 pe-3 block">
                        <hr class="absolute top-1/2 border border-red-400 start-0 end-0"
                            :class="{ 'visible': each.status === 'completed', 'invisible': each.status === 'incomplete' }"/>
                        <span class="block truncate-to-1-line">
                            {{ each.task }}
                        </span>
                    </span>
                    </label>
                </div>
                <button type="button"
                        class="min-w-[45px] min-h-[45px] inline-flex justify-center rounded-lg items-center bg-gray-200 duration-500 hover:bg-gray-300 cursor-pointer"
                        @click="deleteApi(each.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="size-[15px]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                    </svg>
                </button>
            </div>
        </div>
    </template>
    <template v-if="taskData.length === 0">
        <div
            class="w-full min-h-[350px] max-h-[350px] font-semibold flex justify-center items-center flex-col rounded-[0.625rem_0.625rem_0_0] bg-gray-100">
            <div class="mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="size-[45px]"
                     stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                </svg>
            </div>
            <div class="mb-2 text-[19px]">
                {{___(`No Data Found`)}}.
            </div>
            <div class="text-gray-800 text-[15px]">
                {{___(`Click to "+" for new task`)}}
            </div>
        </div>
    </template>

</template>

<script>

import axios from "axios";
import apiRoutes from "../../../../../services/apiRoutes.js";
import apiServices from "../../../../../services/apiServices.js";
import cookiesServices from "../../../../../services/cookiesServices.js";
import {toast} from "vue3-toastify";

export default {
    data() {
        return {
            listLoading: false,
            createLoading: false,
            deleteLoading: false,
            formData: {
                task: '',
                status: 'incomplete',
            },
            taskData: [],
            error: null,
        }
    },
    mounted() {
        this.listApi();
        this.lang = cookiesServices.get('lang') || "en";
    },
    methods: {
        async listApi() {
            try {
                this.listLoading = true;
                const response = await axios.get(apiRoutes.todo, {headers: apiServices.authHeaderContent});
                this.taskData = response.data.data;
            } catch (error) {
                console.log(error);
            } finally {
                this.listLoading = false;
            }
        },
        async createApi() {
            try {
                this.error = null;
                this.createLoading = true;
                await axios.post(apiRoutes.todo, this.formData, {headers: apiServices.authHeaderContent});
                await this.listApi();
                this.formData = {task: '', status: 'incomplete'};
                toast.success(this.lang === "en" ? "Task created successfully." : "تم إنشاء المهمة بنجاح.");
            } catch (error) {
                this.error = error?.response?.data?.errors
            } finally {
                this.createLoading = false;
            }
        },
        async deleteApi(id) {
            try {
                this.deleteLoading = true;
                await axios.delete(apiRoutes.todo + '/' + id, {headers: apiServices.authHeaderContent});
                await this.listApi();
                toast.success(this.lang === "en" ? "Task deleted successfully." : "تم حذف المهمة بنجاح.");
            } catch (error) {
                console.log(error);
            } finally {
                this.deleteLoading = false;
            }
        },
        async statusApi(item) {
            try {
                this.loading = true;
                const newStatus = item.status === 'completed' ? 'incomplete' : 'completed';
                await axios.post(`${apiRoutes.todo}/${item.id}?_method=PUT`, {status: newStatus}, {headers: apiServices.authHeaderContent});
                await this.listApi();
                toast.success(this.lang === "en" ? "Task status updated successfully." : "تم تحديث حالة المهمة بنجاح.");
            } catch (error) {
                console.log(error);
            } finally {
                this.loading = false;
            }
        }
    }
}

</script>
