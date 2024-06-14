<template>
    <div class="container">
        <br>
        <div class="inquiry" title="Здесь вы найдете запросы на ваши Chik">
            <div v-if="inquiries.length === 0">
                <h1 class="mb-3 text-center h3 fw-bold text-danger">Запросов не найдено</h1>
            </div>
            <div v-else>
                <h1 class="mb-3 h3">Запросы на заказ</h1>
                <div v-for="inquiry in inquiries" :key="inquiry.id" title="">
                    <ul class="py-2 pt-3 list-group">
                        <li class="list-group-item">Заказ ID: {{ inquiry.id }}</li>
                        <li class="list-group-item">Заказчик: {{ inquiry.user_name }}</li>
                        <li class="list-group-item">Chik: {{ inquiry.post_title }}</li>
                        <li class="list-group-item">Статус:
                            <span v-if="inquiry.status !== null">
                                <template v-if="inquiry.status === 200">Под общением</template>
                                <template v-else-if="inquiry.status === 201">В ожидании...</template>
                                <template v-else-if="inquiry.status === 202">Принят</template>
                                <template v-else-if="inquiry.status === 203">Экстренный оператор</template>
                                <template v-else-if="inquiry.status === 204">Завершен</template>
                                <template v-else-if="inquiry.status === 205">Представлено на рассмотрение</template>
                                <template v-else-if="inquiry.status === 206">Заказ отклонен</template>
                                <template v-else>Неизвестный</template>
                            </span>
                        </li>
                        <li class="list-group-item">Цена: {{ parseInt(inquiry.price) }}</li>
                        <li class="list-group-item">Сделано: {{ inquiry.created_at }}</li>
                    </ul>
                    <router-link :to="'/inquiry/' + inquiry.id" type="button" class="btn btn-primary btn-sm"
                        title="Открыть Заказ">Открыть
                        Заказ</router-link>
                </div>
            </div>
        </div>
        <br>
    </div>
</template>

<script>
import axios from "axios";

export default {
    emits: ["updateSidebar"],
    data() {
        return {
            inquiries: [],
        };
    },
    methods: {
        fetchinquiries() {
            axios
                .get("/api/inquiries")
                .then((response) => {
                    this.inquiries = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching inquiries:", error);
                });
        },
    },
    mounted() {
        this.fetchinquiries();
    },
};
</script>

<style scoped>
/* Add any custom styles for your orders here */
.inquiry-item {
    margin-bottom: 20px;
    border: 1px solid #ccc;
    padding: 10px;
}

.btn {
    background-color: #e4606d;
    border-color: #e4606d;
}
</style>
