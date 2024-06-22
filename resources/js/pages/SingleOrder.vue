<script setup>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import Pusher from "pusher-js";
import Echo from "laravel-echo";
import ScrollbarComponent from "../components/ScrollbarComponent.vue";

const props = defineProps(["id"]);
const order = ref({});
const chats = ref([]);
const text = ref("");
const loading = ref(false);
const arbitaj = ref(true);
const error = ref(null);
const currentUser = ref(null);
const cash = ref("");
const buying = ref(false);
const scrollbar = ref(null);
const formatPrice = (num) => {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
};

const submit = async () => {
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
};

const buyOrder = async (orderId, status) => {
    try {
        buying.value = true;
        await axios.put(`/api/update-order-status/${orderId}`, {
            status: status,
        });
        // window.location.reload();
    } catch (error) {
        console.error("Purchase failed:", error);
    } finally {
        buying.value = false;
    }
};

const confirmForceMajeure = (orderId) => {
    if (
        window.confirm(
            "Вы уверены, что хотите выполнить арбитраж? После этого чат будет деактивирован."
        )
    ) {
        forceMajeure(orderId);
    }
};

const forceMajeure = async (orderId) => {
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
        console.error("Error fetching data:", error);
        error.value = "Error fetching data";
    }
};

const fetchOrderData = async () => {
    try {
        const response = await axios.get("/api/order/" + props.id);
        order.value = response.data.data;
    } catch (error) {
        console.log(error);
    }
};

const open = ref(false);
const showModal = () => {
  open.value = true;
};
const handleOk = e => {
  open.value = false;
};

const initializePusher = () => {
    const orderId = props.id;
    const channelName = `chat.${orderId}`;
    window.Echo.private(channelName).listen("NewChat", (e) => {
        // console.log(e.chat.text);
        if (e.chat.text === "Arbitajed") {
            arbitaj.value = false;
        }
        chats.value.push(e.chat);
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
        console.error("Error submitting message:", error);
        error.value = "Error submitting message";
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    fetchData();
    initializePusher();
    fetchOrderData();
});
</script>

<template>
    <div class="container flex flex-wrap justify-between py-4 singleOrder">
       
        <a-modal v-model:open="open" @ok="handleOk" title="Заказ">
           
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
        <div class="w-full chat">
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
                    <a-button  @click="showModal"  type="link" >Более...</a-button>
                    <a-button
                        type="primary"
                        danger
                        @click="confirmForceMajeure(order.id)"
                        :disabled="
                            buying ||
                            order.status == 203 ||
                            order.status == 204 ||
                            !arbitaj
                        "
                        >Арбитраж</a-button
                    >
                    
           
                 </div>
                </div>
                <scrollbar-component height="300px">
                    <template #content>
                        <div class="mx-4 mt-4">
                            <div
                                v-for="(chat, index) in chats"
                                :key="index"
                                class=""
                            >
                                <div
                                    v-if="chat.text !== 'Arbitajed'"
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
                                                chat.userImage
                                                    ? chat.userImage
                                                    : '/assets/img/avatar.png'
                                            "
                                            class="h-[30px] w-[30px] rounded-full"
                                        />
                                    </div>
                                    <div
                                        class="p-2 rounded bg-light min-w-[100px]"
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
                                            class="text-[8px] text-muted text-end mt-1"
                                        >
                                            {{ chat.time }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </scrollbar-component>
                <div class="px-4 py-3 border-t border-['#f6f6f6']">
                    <div
                        class="flex justify-content-between align-items-center"
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
                            <input
                                v-model="text"
                                type="text"
                                id="textAreaExample"
                                class="pr-2 form-control"
                                placeholder="Напишите сообщение"
                                autocomplete="off"
                                style="width: calc(100% - 100px);"
                            />
                            <button type="submit" class="ml-4 btn btn-primary">
                                Отправить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div
                class="gap-2 pb-4 mt-4 d-grid d-md-flex justify-content-md-end"
            >
                <button
                    class="btn btn-success btn-buy me-md-2"
                    @click="buyOrder(order.id, 201)"
                    :disabled="buying || order.status !== 200"
                    type="button"
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
    </div>
</template>

<style>
.singleOrder .order .ant-card {
    width: 300px !important;
}



.singleOrder .ant-card .ant-card-head-title {
    text-align: center !important;
}

/* .singleOrder .chat {
    width: calc(100% - 320px) !important;
} */
</style>
