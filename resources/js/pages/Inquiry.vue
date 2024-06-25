<template>
    <br />
    <div class="container">
        <div class="order-page">
            <div class="order">
                <h1 class="mb-3 h3">Заказ</h1>
                <ul class="list-group">
                    <li class="list-group-item">Заказ ID: {{ inquiry.id }}</li>
                    <li class="list-group-item">
                        Заказчик: {{ inquiry.user_name }}
                    </li>
                    <li class="list-group-item">
                        Chik: {{ inquiry.post_title }}
                    </li>
                    <li class="list-group-item">
                        Статус:
                        <span v-if="inquiry.status !== null">
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
                    </li>

                    <li class="list-group-item">
                        Время: {{ inquiry.created_at }}
                    </li>
                    <li class="list-group-item">
                        Цена: {{ formatPrice(inquiry.price) }}
                    </li>
                </ul>
            </div>
            <br />

            <main class="content">
                <div class="container p-0">
                    <h1 class="mb-3 h3">Чать</h1>

                    <div class="card">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="px-4 py-2 border-bottom d-lg-block">
                                    <div
                                        title="Эта кнопка на случай форс-мажорных или подобных случаев. После нажатия этой кнопки чат будет деактивирован и продолжения не будет."
                                        class="py-1 d-flex align-items-center"
                                    >
                                        <div class="position-relative">
                                            <img
                                                :src="'/assets/img/force_m.png'"
                                                class="mr-1 rounded-circle"
                                                alt="Sharon Lessman"
                                                width="40"
                                                height="40"
                                            />
                                        </div>
                                        <div class="pl-3 flex-grow-1">
                                            <strong>
                                                &nbsp; Экстренный оператор
                                            </strong>
                                        </div>
                                        <div>
                                            <button
                                                title="Эта кнопка на случай форс-мажорных или подобных случаев. После нажатия этой кнопки чат будет деактивирован и продолжения не будет."
                                                type="button"
                                                class="btn btn-danger btn-sm"
                                                @click="
                                                    confirmForceMajeure(
                                                        inquiry.id
                                                    )
                                                "
                                                :disabled="
                                                    buying ||
                                                    inquiry.status == 203 ||
                                                    inquiry.status == 204 ||
                                                    !arbitaj
                                                "
                                            >
                                                Арбитраж
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="position-relative">
                                    <div class="p-4 chat-messages">
                                        <div
                                            v-for="(chat, index) in chats"
                                            :key="index"
                                        >
                                            <div
                                                v-if="chat.text !== 'Arbitajed'"
                                                :class="{
                                                    'chat-message-left pb-4':
                                                        chat.user_id !==
                                                        currentUser.id,
                                                    'chat-message-right pb-4':
                                                        chat.user_id ===
                                                        currentUser.id,
                                                }"
                                            >
                                                <div>
                                                    <img
                                                        :src="
                                                            chat.userImage
                                                                ? chat.userImage
                                                                : '/assets/img/avatar.png'
                                                        "
                                                        class="mr-1 rounded-circle"
                                                        width="40"
                                                        height="40"
                                                    />
                                                    <div
                                                        class="mt-2 text-muted small text-nowrap"
                                                    >
                                                        {{ chat.time }}
                                                    </div>
                                                </div>
                                                <div
                                                    class="px-3 py-2 mr-3 rounded flex-shrink-1 bg-light"
                                                >
                                                    <div
                                                        class="mb-1 font-weight-bold"
                                                    >
                                                        {{
                                                            chat.user_id ===
                                                            currentUser.id
                                                                ? "Вы"
                                                                : chat.user
                                                                ? `${chat.user.name}`
                                                                : "Unknown"
                                                        }}
                                                    </div>
                                                    {{ chat.text }}
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
                                            class="mr-2 flex-grow-1 d-flex"
                                        >
                                            <input
                                                v-model="text"
                                                type="text"
                                                id="textAreaExample"
                                                class="mr-2 form-control"
                                                placeholder="Напишите сообщение"
                                                autocomplete="off"
                                            />
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                            >
                                                Отправить
                                            </button>
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
const inquiry = ref({});

function formatPrice(price) {
    return new Intl.NumberFormat("uz-Uz").format(price);
}

async function confirmForceMajeure(orderId) {
    if (
        window.confirm(
            "Вы уверены, что хотите выполнить арбитраж? После этого чат будет деактивирован."
        )
    ) {
        await forceMajeure(orderId);
    }
}

async function forceMajeure(orderId) {
    try {
        buying.value = true;
        // text.value = "Arbitajed";
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

async function submit() {
    try {
        loading.value = true;
        const formData = new FormData();
        formData.append("text", text.value);
        await axios.post(`/api/order/${props.id}/messages`, formData);
        chats.value.push({
            text: text.value,
            user_id: currentUser.value.id,
        });
        text.value = "";
    } catch (error) {
        console.error("Error submitting message:", error);
        error.value = "Error submitting message";
    } finally {
        loading.value = false;
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
    } catch (error) {
        console.error("Error fetching data:", error);
        error.value = "Error fetching data";
    }
}

async function fetchInquiry() {
    try {
        const response = await axios.get("/api/inquiry/" + props.id);
        inquiry.value = response.data.data;
    } catch (error) {
        console.log(error);
    }
}

async function updateOrderStatus(orderId, status) {
    try {
        buying.value = true;
        await axios.put(`/api/update-order-status/${orderId}`, {
            status: status,
        });
        window.location.reload();
    } catch (error) {
        console.error(error);
    } finally {
        buying.value = false;
    }
}

function initializePusher() {
    const route = useRoute();
    const inquiryId = route.params.id;
    const channelName = `chat.${inquiryId}`;

    window.Echo.private(channelName).listen("NewChat", (e) => {
        console.log(e.chat);
        if (e.chat.text === "Arbitajed") {
            arbitaj.value = false;
        }
        chats.value.push(e.chat);
    });
}

onMounted(() => {
    fetchData();
    initializePusher();
    fetchInquiry();
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

.content {
    margin-left: 35px;

    flex-basis: 71%;
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
