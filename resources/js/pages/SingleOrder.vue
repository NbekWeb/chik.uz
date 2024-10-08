<script setup>
import { ref, onMounted, watch, reactive } from "vue";
import axios from "axios";
import Pusher from "pusher-js";
import Echo from "laravel-echo";
import ScrollbarComponent from "../components/ScrollbarComponent.vue";
import { message } from "ant-design-vue";
import { useRouter, useRoute } from "vue-router";

const props = defineProps(["id"]);
const formRef = ref();
const formState = reactive({ msg: "", rate: 0 });
const rules = {
    msg: [
        {
            required: true,
            message: "Пожалуйста, введите комментарий",
            trigger: "blur",
        },
    ],
    rate: [
        {
            validator: (rule, value, callback) => {
                if (value < 1 || value > 5) {
                    callback(new Error("Оценка должна быть от 1 до 5"));
                } else {
                    callback();
                }
            },
            trigger: "blur",
        },
    ],
};
const router = useRouter();
const route = useRoute();
const order = ref({});
const chats = ref([]);
const text = ref("");
const loading = ref(false);
const loadingM = ref(true);
const comment = ref(true);
const arbitaj = ref(true);
const itemsChat = ref();
const error = ref(null);
const currentUser = ref(null);
const cash = ref("");
const buying = ref(false);
const scrollbar = ref(null);
const lastChat = ref(null);
const canSend = ref(true);
const formatPrice = (num) => {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
};

const scrollItem = () => {
    if (itemsChat.value !== null) {
        setTimeout(() => {
            itemsChat.value.scrollTop = itemsChat.value.scrollHeight;
        }, 100);
    }
};

const submit = async () => {
    if (!text.value.trim()) {
        message.error("Текст не может быть пустым!");
        return;
    }
    if (canSend.value) {
        canSend.value = false;
        chats.value.push({
            text: text.value,
            user_id: currentUser.value.id,
            sended: 1,
        });

        try {
            loading.value = true;

            const formData = new FormData();
            formData.append("text", text.value);
            await axios.post(`/api/order/${props.id}/messages`, formData);

            chats.value[chats.value.length - 1].sended = 3;
        } catch (e) {
            chats.value[chats.value.length - 1].sended = 2;
            message.error(e.message);
        } finally {
            loading.value = false;
            canSend.value = true;
            text.value = "";
            scrollItem();
        }
    }
};

const buyOrder = async (orderId, status) => {
    try {
        buying.value = true;
        const formData = new FormData();
        formData.append("text", "Buyed");
        await axios.post(`/api/order/${props.id}/messages`, formData);
        await axios.put(`/api/update-order-status/${orderId}`, {
            status: status,
        });
        chats.value.push({
            text: "Buyed",
            user_id: currentUser.value.id,
        });

        window.location.reload();
    } catch (error) {
        console.log(error.response.data.error)
        message.error(error.response.data.error);
    } finally {
        buying.value = false;
    }
};

const forceMajeure = async (orderId) => {
    try {
        buying.value = true;
        arbitajFunc();
        await axios.put(`/api/force-majeure/${orderId}`);
        window.location.reload();
    } catch (error) {
        message.error(error);
    } finally {
        buying.value = false;
    }
};

const fetchData = async () => {
    try {
        const [chatsResponse, currentUserResponse] = await Promise.all([
            axios.get(`/api/order/${props.id}/messages`),
            axios.get(`/api/user`),
        ]);

        chats.value = chatsResponse.data.data;
        currentUser.value = currentUserResponse.data;
    } catch (error) {
        if(error.response.status==404){
            router.push({name:"NotFound"})
        }
        else{
            message.error(error.message);
        }
    }
};

const fetchOrderData = async () => {
    loadingM.value = true;
    try {
        const response = await axios.get("/api/order/" + props.id);
        order.value = response.data.data;
        const lastChatUserId =
            order.value.chats?.[order.value.chats.length - 1];
        const orderUserId = order.value.user_id;

        if (
            orderUserId != lastChatUserId?.user_id &&
            lastChatUserId.status != 1
        ) {
            await axios.post(`/api/message/${lastChatUserId.id}`, {
                status: 1,
            });
        }
    } catch (err) {
        if (err.response.status == 404) {
            router.push({ name: "NotFound" });
        }
        else{
            message.error(err.response.status);
        }
    } finally {
        loadingM.value = false;
    }
};

const pushComment = async () => {
    try {
        await axios.post("/api/review", {
            post_id: order.value.post_id,
            comment: formState.msg,
            star: formState.rate,
            order_id: route.params.id,
        });
        message.success("Комментарий успешно добавлен");
        comOpen.value = false;
        comment.value = false;
    } catch (err) {
        comOpen.value = false;
        if (err.response.status == 404) {
            router.push({ name: "NotFound" });
        }
    }
};

const open = ref(false);
const comOpen = ref(false);
const showModal = () => {
    open.value = true;
};
const showCom = () => {
    comOpen.value = true;
};

const initializePusher = () => {
    const orderId = props.id;
    const channelName = `chat.${orderId}`;
    window.Echo.private(channelName).listen("NewChat", (e) => {
        if (e.chat.text === "Arbitajed") {
            arbitaj.value = false;
        } else if (e.chat.text === "Buyed" && e.chat.status == 0) {
            axios.post(`/api/message/${e.chat.id}`, { status: 1 });
            window.location.reload();
        } else {
            lastChat.value = e.chat.id;
            chats.value.push(e.chat);
            axios.post(`/api/message/${e.chat.id}`, { status: 1 });
            scrollItem();
        }
    });
};

async function arbitajFunc() {
    try {
        const formData = new FormData();
        formData.append("text", "Arbitajed");
        await axios.post(`/api/order/${props.id}/messages`, formData);
        chats.value.push({
            text: "Arbitajed",
            user_id: currentUser.value.id,
        });
    } catch (error) {
        message.error(error.error);
    } finally {
        loading.value = false;
    }
}

onMounted(async () => {
    await fetchData();
    initializePusher();
    await fetchOrderData();
    scrollItem();
});
</script>

<template>
    <div
        class="container flex flex-wrap justify-between gap-4 py-4 singleOrder"
    >
        <a-modal v-model:open="open" title="Заказ">
            <div class="px-2">
                <p>
                    Заказ ID:
                    <span class="ml-1">
                        {{ order.id }}
                    </span>
                </p>
                <p>
                    Chik: <span class="ml-1">{{ order.post_title }}</span>
                </p>
                <p>
                    Статус:
                    <span v-if="order.status !== null" class="ml-1">
                        <template v-if="order.status === 200"
                            >Под общением</template
                        >
                        <template v-else-if="order.status === 201"
                            >В ожидании...</template
                        >
                        <template v-else-if="order.status === 202"
                            >Принят</template
                        >
                        <template v-else-if="order.status === 203"
                            >Экстренный оператор</template
                        >
                        <template v-else-if="order.status === 204"
                            >Завершен</template
                        >
                        <template v-else-if="order.status === 205"
                            >Представлено на рассмотрение</template
                        >
                        <template v-else-if="order.status === 206"
                            >Заказ отклонен</template
                        >
                        <template v-else>Неизвестный</template>
                    </span>
                </p>
                <p>
                    Время:<span class="ml-1">{{ order.created_at }}</span>
                </p>
                <p>
                    Цена:<span class="ml-1">
                        {{ formatPrice(parseInt(order.price)) }}</span
                    >
                </p>
            </div>
        </a-modal>

        <a-modal v-model:open="comOpen" title="otziv">
            <a-form
                ref="formRef"
                :model="formState"
                :rules="rules"
                class="pt-3"
            >
                <a-form-item ref="msg" label="Комментарий" name="msg">
                    <a-input v-model:value="formState.msg" autocomplete="off" />
                </a-form-item>
                <a-form-item ref="rate" label="Оценка" name="rate">
                    <a-rate v-model:value="formState.rate" />
                </a-form-item>
                <a-button type="primary" @click.prevent="pushComment"
                    >Create</a-button
                >
            </a-form>
        </a-modal>

        <div class="flex-grow max-lg:w-full chat">
            <div class="bg-white rounded-md chat__wrapper">
                <div
                    class="flex items-center justify-between px-4 py-3 border-['#f6f6f6'] border-b"
                >
                    <div class="flex items-center">
                        <img
                            :src="'/assets/img/force_m.png'"
                            class="w-[25px] h-[25px] rounded-full"
                            alt="Sharon Lessman"
                        />
                        <p class="pl-2 m-0 text-lg font-bold max-md:text-xs">
                            Экстренный оператор
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a-button
                            @click="showModal"
                            type="link"
                            class="lg:hidden max-lg:flex"
                            >Информация...</a-button
                        >
                        <div class="">
                            <a-popconfirm
                                title="Вы уверены, что хотите выполнить арбитраж? После этого чат будет деактивирован."
                                ok-text="Да"
                                cancel-text="Нет"
                                @confirm="forceMajeure(order.id)"
                                placement="bottomRight"
                            >
                                <a-button
                                    type="primary"
                                    class="flex max-md:px-2"
                                    danger
                                    :disabled="
                                        buying ||
                                        order.status == 203 ||
                                        order.status == 204 ||
                                        !arbitaj
                                    "
                                >
                                    <svg
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="md:hidden max-md:flex"
                                    >
                                        <path
                                            d="M11.9998 8.99999V13M11.9998 17H12.0098M10.6151 3.89171L2.39019 18.0983C1.93398 18.8863 1.70588 19.2803 1.73959 19.6037C1.769 19.8857 1.91677 20.142 2.14613 20.3088C2.40908 20.5 2.86435 20.5 3.77487 20.5H20.2246C21.1352 20.5 21.5904 20.5 21.8534 20.3088C22.0827 20.142 22.2305 19.8857 22.2599 19.6037C22.2936 19.2803 22.0655 18.8863 21.6093 18.0983L13.3844 3.89171C12.9299 3.10654 12.7026 2.71396 12.4061 2.58211C12.1474 2.4671 11.8521 2.4671 11.5935 2.58211C11.2969 2.71396 11.0696 3.10655 10.6151 3.89171Z"
                                            stroke="white"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>

                                    <p class="text-white md:flex max-md:hidden">
                                        Арбитраж
                                    </p>
                                </a-button>
                            </a-popconfirm>
                        </div>
                    </div>
                </div>
                <div ref="itemsChat" class="overflow-auto h-[300px]">
                    <div class="mx-4 mt-4">
                        <div v-for="(chat, index) in chats" :key="index">
                            <div
                                v-if="
                                    chat.text !== 'Arbitajed' &&
                                    chat.text !== 'Buyed'
                                "
                                class="flex w-full mb-3"
                                :class="{
                                    'justify-start ':
                                        chat.user_id !== currentUser.id,
                                    'justify-end ':
                                        chat.user_id === currentUser.id,
                                }"
                            >
                                <div class="flex items-end">
                                    <img
                                        :src="
                                            chat.user_id === currentUser.id
                                                ? currentUser.image_url
                                                    ? currentUser.image_url
                                                    : '/assets/img/avatar.png'
                                                : order.post_user_image
                                                ? order.post_user_image
                                                : '/assets/img/avatar.png'
                                        "
                                        alt="User Avatar"
                                        class="h-[30px] w-[30px] rounded-full"
                                    />
                                </div>
                                <div
                                    class="p-2 rounded bg-light min-w-[100px]"
                                    style="max-width: calc(100% - 50px)"
                                >
                                    <p class="m-0 text-base">
                                        {{ chat.text }}
                                        <!-- {{
                                                                     chat.user_id ===
                                                                     currentUser.id
                                                                         ? "Вы"
                                                                         : chat.user
                                                                         ? `${chat.user.name}`
                                                                         : "Unknown"
                                                                 }} -->
                                    </p>
                                    <div
                                        class="mt-1 text-xs text-muted text-end"
                                    >
                                        <template v-if="chat.sended == 1">
                                            Отправка
                                        </template>
                                        <template v-else-if="chat.sended == 2">
                                            <span class="text-red-500">
                                                Не отправлено
                                            </span>
                                        </template>
                                        <template v-else>
                                            {{ chat.time || "Cейчас" }}
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 border-t border-['#f6f6f6']">
                    <div
                        class="flex justify-content-between align-items-center send__msg"
                        v-if="
                            order &&
                            order.id &&
                            arbitaj &&
                            order.status !== 203 &&
                            order.status !== 204
                        "
                    >
                        <form
                            @submit.prevent="submit"
                            class="flex justify-between w-full mr-2"
                        >
                            <a-input
                                v-model:value="text"
                                type="text"
                                id="textAreaExample"
                                class="h-full md:pr-2 form-control max-md:pr-0"
                                placeholder="Напишите сообщение"
                                autocomplete="off"
                            />

                            <div
                                class="max-w-[140px] max-md:ml-2 md:ml-4 send_btn canSend"
                            >
                                <a-spin :spinning="!canSend">
                                    <a-button
                                        :disabled="loading"
                                        @click="submit"
                                        class="items-center w-full h-full gap-1 btn btn-primary"
                                        style="display: flex"
                                    >
                                        <svg
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M10.4995 13.5001L20.9995 3.00005M10.6271 13.8281L13.2552 20.5861C13.4867 21.1815 13.6025 21.4791 13.7693 21.566C13.9139 21.6414 14.0862 21.6415 14.2308 21.5663C14.3977 21.4796 14.5139 21.1821 14.7461 20.587L21.3364 3.69925C21.5461 3.16207 21.6509 2.89348 21.5935 2.72185C21.5437 2.5728 21.4268 2.45583 21.2777 2.40604C21.1061 2.34871 20.8375 2.45352 20.3003 2.66315L3.41258 9.25349C2.8175 9.48572 2.51997 9.60183 2.43326 9.76873C2.35809 9.91342 2.35819 10.0857 2.43353 10.2303C2.52043 10.3971 2.81811 10.5128 3.41345 10.7444L10.1715 13.3725C10.2923 13.4195 10.3527 13.443 10.4036 13.4793C10.4487 13.5114 10.4881 13.5509 10.5203 13.596C10.5566 13.6468 10.5801 13.7073 10.6271 13.8281Z"
                                                stroke="#fff"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>

                                        <p class="mb-0 max-md:hidden">
                                            Отправить
                                        </p>
                                    </a-button>
                                </a-spin>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- @click="unread" -->
            <div
                class="gap-2 pb-4 mt-4 d-grid d-md-flex justify-content-md-end"
                v-if="arbitaj"
            >
                <button
                    class="btn btn-success btn-buy me-md-2"
                    type="button"
                    @click="showCom"
                    v-if="
                        !order?.reviews?.[0] && order.status == 204 && comment
                    "
                >
                    Отзив
                </button>
                <button
                    class="btn btn-success btn-buy me-md-2"
                    @click="buyOrder(order.id, 201)"
                    :disabled="buying || order.status !== 200"
                    type="button"
                    v-else
                >
                    Покупать
                </button>
                <button
                    class="btn btn-danger"
                    type="button"
                    @click="buyOrder(order.id, 206)"
                    :disabled="buying || order.status !== 201"
                >
                    {{
                        order.status === 206
                            ? "Заказ отклонен"
                            : "Отказать заказ"
                    }}
                </button>
                <button
                    class="btn btn-primary btn-p"
                    type="button"
                    @click="buyOrder(order.id, 204)"
                    :disabled="buying || order.status !== 205"
                >
                    {{
                        order.status === 204 ? "Подверден" : "Подвердите заказ"
                    }}
                </button>
            </div>
        </div>
        <div class="lg:block max-lg:hidden">
            <!-- <h3 class="mb-4 text-2xl font-bold text-center">Заказ</h3> -->
            <a-spin :spinning="loadingM">
                <div class="text-xl font-semibold bg-white rounded-2xl">
                    <p class="px-4 py-3 mb-0">
                        Заказ ID:
                        <span class="ml-1 font-medium text-muted">
                            {{ order.id }}
                        </span>
                    </p>
                    <p class="px-4 py-3 mb-0 border-t">
                        Chik: <span class="ml-1 font-medium text-muted">{{ order.post_title }}</span>
                    </p>
                    <p class="px-4 py-3 mb-0 border-t">
                        Статус:
                        <span v-if="order.status !== null" class="ml-1 font-medium text-muted">
                            <template v-if="order.status === 200"
                                >Под общением</template
                            >
                            <template v-else-if="order.status === 201"
                                >В ожидании...</template
                            >
                            <template v-else-if="order.status === 202"
                                >Принят</template
                            >
                            <template v-else-if="order.status === 203"
                                >Экстренный оператор</template
                            >
                            <template v-else-if="order.status === 204"
                                >Завершен</template
                            >
                            <template v-else-if="order.status === 205"
                                >Представлено на рассмотрение</template
                            >
                            <template v-else-if="order.status === 206"
                                >Заказ отклонен</template
                            >
                            <template v-else>Неизвестный</template>
                        </span>
                    </p> 
                    <p class="px-4 py-3 mb-0 border-t">
                        Время:<span class="ml-1 font-medium text-muted">{{ order.created_at }}</span>
                    </p>
                    <p class="px-4 py-3 mb-0 border-t">
                        Цена:<span class="ml-1 font-medium text-muted">
                            {{ formatPrice(parseInt(order.price)) }}</span
                        >
                    </p>
                </div>
            </a-spin>
        </div>
    </div>
</template>

<style>
.singleOrder .order .ant-card {
    width: 300px !important;
}

.singleOrder .ant-card .ant-card-head-title {
    text-align: center !important;
}

.send_btn .ant-btn-default:not(:disabled):hover {
    color: #1677ff !important;
    color: #fff !important;
    border-color: #1677ff !important;
}

.send__msg .ant-spin .ant-spin-dot-item {
    background-color: #1677ff !important;
}

.ant-popover .ant-popover-inner {
    margin-left: 30px !important;
}
</style>
