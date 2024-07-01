<template>
    <br />
    <div class="container">
        <div class="">
            <a-modal v-model:open="open" title="Заказ">
                <div class="px-2">
                    <p>
                        Заказ ID:
                        <span class="ml-1">
                            {{ inquiry.id }}
                        </span>
                    </p>
                    <p>
                        Chik: <span class="ml-1">{{ inquiry.post_title }}</span>
                    </p>
                    <p>
                        Статус:
                        <span v-if="inquiry.status !== null" class="ml-1">
                            <template v-if="inquiry.status === 200"
                                >Под общением</template
                            >
                            <template v-else-if="inquiry.status === 201"
                                >В ожидании...</template
                            >
                            <template v-else-if="inquiry.status === 202"
                                >Принят</template
                            >
                            <template v-else-if="inquiry.status === 203"
                                >Экстренный оператор</template
                            >
                            <template v-else-if="inquiry.status === 204"
                                >Завершен</template
                            >
                            <template v-else-if="inquiry.status === 205"
                                >Представлено на рассмотрение</template
                            >
                            <template v-else-if="inquiry.status === 206"
                                >Заказ отклонен</template
                            >
                            <template v-else>Неизвестный</template>
                        </span>
                    </p>
                    <p>
                        Время:<span class="ml-1">{{ inquiry.created_at }}</span>
                    </p>
                    <p>
                        Цена:<span class="ml-1">
                            {{ formatPrice(parseInt(inquiry.price)) }}</span
                        >
                    </p>
                </div>
            </a-modal>

            <main class="content">
                <div class="container p-0">
                    <div class="bg-white rounded-md">
                        <div class="row g-0">
                            <div class="col-12">
                                <div
                                    class="flex items-center justify-between px-4 py-3 border-['#f6f6f6'] border-b"
                                >
                                    <div class="flex items-center">
                                        <img
                                            :src="'/assets/img/force_m.png'"
                                            class="w-[25px] h-[25px] rounded-full"
                                            alt="Sharon Lessman"
                                        />
                                        <p
                                            class="pl-2 m-0 text-lg font-bold max-md:text-xs"
                                        >
                                            Экстренный оператор
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <a-button @click="showModal" type="link"
                                            >Информация...</a-button
                                        >
                                        <div class="">
                                            <a-popconfirm
                                                title="Вы уверены, что хотите выполнить арбитраж? После этого чат будет деактивирован."
                                                ok-text="Да"
                                                cancel-text="Нет"
                                                @confirm="
                                                    forceMajeure(order.id)
                                                "
                                                placement="bottomRight"
                                            >
                                                <a-button
                                                    type="primary"
                                                    class="flex max-md:px-2"
                                                    danger
                                                    :disabled="
                                                        buying ||
                                                        inquiry.status == 203 ||
                                                        inquiry.status == 204 ||
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

                                                    <p
                                                        class="text-white md:flex max-md:hidden"
                                                    >
                                                        Арбитраж
                                                    </p>
                                                </a-button>
                                            </a-popconfirm>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    ref="itemsChatInquiry"
                                    class="overflow-auto h-[300px]"
                                >
                                    <div class="mx-4 mt-4">
                                        <div
                                            v-for="(chat, index) in chats"
                                            :key="index"
                                        >
                                            <div
                                                v-if="
                                                    chat.text !== 'Arbitajed' &&
                                                    chat.text !== 'Buyed'
                                                "
                                                class="flex w-full mb-3"
                                                :class="{
                                                    'justify-start ':
                                                        chat.user_id !==
                                                        currentUser.id,
                                                    'justify-end ':
                                                        chat.user_id ===
                                                        currentUser.id,
                                                }"
                                            >
                                                <div class="flex items-end">
                                                    <img
                                                        :src="
                                                            chat.user_id ===
                                                            currentUser.id
                                                                ? currentUser.image_url
                                                                    ? currentUser.image_url
                                                                    : '/assets/img/avatar.png'
                                                                : inquiry.user_image
                                                                ? inquiry.user_image
                                                                : '/assets/img/avatar.png'
                                                        "
                                                        class="h-[30px] w-[30px] rounded-full"
                                                    />
                                                </div>
                                                <div
                                                    class="p-2 rounded bg-light min-w-[100px]"
                                                    style="
                                                        max-width: calc(
                                                            100% - 50px
                                                        );
                                                    "
                                                >
                                                    <p class="m-0 text-base">
                                                        {{ chat.text }}
                                                    </p>
                                                    <div
                                                        class="mt-1 text-xs text-muted text-end"
                                                    >
                                                        <template
                                                            v-if="
                                                                chat.sended == 1
                                                            "
                                                        >
                                                            Отправка
                                                        </template>
                                                        <template
                                                            v-else-if="
                                                                chat.sended == 2
                                                            "
                                                        >
                                                            <span
                                                                class="text-red-500"
                                                            >
                                                                Не отправлено
                                                            </span>
                                                        </template>
                                                        <template v-else>
                                                            {{
                                                                chat.time ||
                                                                "Cейчас"
                                                            }}
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-grow-0 px-4 py-3 border-top">
                                    <div
                                        class="d-flex justify-content-between align-items-center"
                                        v-if="
                                            inquiry &&
                                            inquiry.id &&
                                            arbitaj &&
                                            inquiry.status !== 203 &&
                                            inquiry.status !== 204
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
                                                class="max-w-[140px] max-md:ml-2 md:ml-4"
                                            >
                                                <a-button
                                                    :disabled="loading"
                                                    @click="submit"
                                                    class="items-center w-full h-full gap-1 btn btn-primary"
                                                    style="display: flex;"
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

                                                    <p
                                                        class="mb-0 max-md:hidden"
                                                    >
                                                        Отправить
                                                    </p>
                                                </a-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <br />
        <div class="gap-2 pb-4 d-grid d-md-flex justify-content-md-end">
            <button
                class="btn btn-success btn-buy me-md-2"
                @click="updateOrderStatus(inquiry.id, 202)"
                :disabled="buying || inquiry.status !== 201"
            >
                {{ inquiry.status === 202 ? "Заказ принят" : "Принять заказ" }}
            </button>
            <button
                class="btn btn-danger"
                @click="updateOrderStatus(inquiry.id, 206)"
                :disabled="buying || inquiry.status !== 201"
            >
                {{
                    inquiry.status === 206 ? "Заказ отклонен" : "Отказать заказ"
                }}
            </button>
            <button
                class="btn btn-primary btn-p"
                @click="updateOrderStatus(inquiry.id, 205)"
                :disabled="buying || inquiry.status !== 202"
            >
                {{
                    inquiry.status === 204
                        ? "Подверден"
                        : inquiry.status === 205
                        ? "Поданный"
                        : "Представлять на рассмотрение"
                }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, toRefs } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";
import Echo from "laravel-echo";

const props = defineProps(["id"]);
const emit = defineEmits(["updateSidebar"]);

const buying = ref(false);
const chats = ref([]);
const text = ref("");
const loading = ref(false);
const arbitaj = ref(true);
const error = ref(null);
const currentUser = ref(null);
const orderUserId = ref(null);
const inquiry = ref({});
const itemsChatInquiry = ref();

const open = ref(false);
const showModal = () => {
    open.value = true;
};

const formatPrice = (num) => {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
};

async function forceMajeure(orderId) {
    try {
        buying.value = true;
        arbitajFunc();
        await axios.put(`/api/force-majeure/${orderId}`);
        window.location.reload();
    } catch (error) {
        console.error("forceMajeure failed:", error);
    } finally {
        buying.value = false;
    }
}

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
        console.error("Error submitting message:", error);
        error.value = "Error submitting message";
    } finally {
        loading.value = false;
    }
}

const scrollItem = () => {
    if (itemsChatInquiry.value !== null) {
        setTimeout(() => {
            itemsChatInquiry.value.scrollTop =
                itemsChatInquiry.value.scrollHeight;
        }, 100);
    }
};

async function submit() {
    if (!text.value.trim()) {
        message.error("Текст не может быть пустым!");
        return;
    }
    chats.value.push({
        text: text.value,
        user_id: currentUser.value.id,
        sended: 1,
        img: currentUser.image,
    });
    try {
        loading.value = true;
        const formData = new FormData();
        formData.append("text", text.value);
        await axios.post(`/api/order/${props.id}/messages`, formData);
        chats.value[chats.value.length - 1].sended = 3;
    } catch (error) {
        chats.value[chats.value.length - 1].sended = 2;
        console.error("Error submitting message:", error);
        error.value = "Error submitting message";
    } finally {
        text.value = "";
        loading.value = false;
        scrollItem();
    }
}

async function fetchData() {
    try {
        const [chatsResponse, currentUserResponse] = await Promise.all([
            axios.get(`/api/order/${props.id}/messages`),
            axios.get(`/api/user`),
        ]);
        chats.value = chatsResponse.data.data;
        currentUser.value = currentUserResponse.data;
        orderUserId.value = currentUser.value.id;
    } catch (error) {
        console.error("Error fetching data:", error);
        error.value = "Error fetching data";
    }
}

async function fetchInquiry() {
    try {
        const response = await axios.get("/api/inquiry/" + props.id);
        inquiry.value = response.data.data;

        const lastChatUserId =
            inquiry.value.chats?.[inquiry.value.chats.length - 1];

        if (
            orderUserId.value != lastChatUserId?.user_id &&
            lastChatUserId.status != 1
        ) {
            await axios.post(`/api/message/${lastChatUserId.id}`, {
                status: 1,
            });
        }
    } catch (error) {
        console.log(error);
    }
}

async function updateOrderStatus(orderId, status) {
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
        console.error(error);
    } finally {
        buying.value = false;
    }
}

function initializePusher() {
    const inquiryId = props.id;
    const channelName = `chat.${inquiryId}`;

    window.Echo.private(channelName).listen("NewChat", (e) => {
        if (e.chat.text === "Arbitajed") {
            arbitaj.value = false;
        } else if (e.chat.text === "Buyed" && e.chat.status == 0) {
            axios.post(`/api/message/${e.chat.id}`, { status: 1 });
            window.location.reload();
        } else {
            chats.value.push(e.chat);
            axios.post(`/api/message/${e.chat.id}`, { status: 1 });
            scrollItem();
        }
    });
}

onMounted(async () => {
    await fetchData();
    initializePusher();
    await fetchInquiry();
    scrollItem();
});
</script>

<style scoped>
/* Add any custom styles for your orders here */
.order-item {
    margin-bottom: 20px;
    border: 1px solid #ccc;
    padding: 10px;
}

.order-page {
    display: flex;
}

.order-table {
    border: 1px solid #ccc;
}

.order {
    flex-basis: 26%;
}

/* .btn-buy {
    background-color: #e4606d;
    border-color: #e4606d
} */

.btn-p {
    background-color: #34ce57;
    border-color: #34ce57;
}

.chat-online {
    color: #34ce57;
}

.chat-offline {
    color: #e4606d;
}

.chat-messages {
    display: flex;
    flex-direction: column;
    max-height: 800px;
    overflow-y: scroll;
}

.chat-message-left,
.chat-message-right {
    display: flex;
    flex-shrink: 0;
}

.chat-message-left {
    margin-right: auto;
}

.chat-message-right {
    flex-direction: row-reverse;
    margin-left: auto;
}

.py-3 {
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
}

.px-4 {
    padding-right: 1.5rem !important;
    padding-left: 1.5rem !important;
}

.flex-grow-0 {
    flex-grow: 0 !important;
}

.border-top {
    border-top: 1px solid #dee2e6 !important;
}

@media screen and (max-width: 425px) {
    .order-page {
        display: grid;
    }

    .order {
        flex-basis: none;
    }

    .content {
        margin-left: 0px;

        flex-basis: none;
    }
}
</style>
