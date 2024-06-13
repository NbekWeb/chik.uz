<template>
    <div class="container pt-3">
        <div class="bg-white">
            <h1 class="py-3 text-center">Список категорий</h1>
            <div class="mx-3">
                <a-table :columns="columns" :data-source="categories" bordered>
                    <!-- Custom slot for actions column -->
                    <template #actions="{ text, record }">
                        <span class="flex justify-center gap-2">
                            <router-link
                                :to="{ name: 'EditCategories', params: { id: record.id }}"
                                class="edit-link"
                            >
   Edit
                            </router-link>
                            <button
                                type="button"
                                @click="destroy(record.id)"
                                class="delete-btn"
                            >
                                Delete
                            </button>
                        </span>
                    </template>
                </a-table>
            </div>
        </div>

        <!-- success message -->
        <div class="success-msg" v-if="success">
            <i class="fa fa-check"></i>
            Удален успешно
        </div>

        <div class="index-categories">
            <router-link :to="{ name: 'CreateCategories' }"
                >Создать категории<span>&#8594;</span></router-link
            >
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const categories = ref([]);
const success = ref(false);

const columns = [
    {
        title: "Название",
        dataIndex: "name",
        key: "name",
    },
    {
        title: "Действия",
        key: "actions",
        align: "center", // optional alignment
        slots: { customRender: "actions" }, // Using a slot for custom rendering
    },
];

const fetchCategories = () => {
    axios
        .get("/api/categories")
        .then((response) => {
            categories.value = response.data;
        })
        .catch((error) => {
            console.error(error);
        });
};

const destroy = (id) => {
    axios
        .delete("/api/categories/" + id)
        .then(() => {
            success.value = true;
            setTimeout(() => {
                success.value = false;
            }, 2500);
            fetchCategories();
        })
        .catch((error) => {
            console.error(error);
        });
};

onMounted(fetchCategories);
</script>


<style scoped>
.categories-list {
    min-height: 100vh;
    background: #fff;
}

.categories-list h1 {
    font-weight: 300;
    padding: 50px 0 30px 0;
    text-align: center;
}

.categories-list .item {
    display: flex;
    justify-content: right;
    align-items: center;
    max-width: 300px;
    margin: 0 auto !important;
}

.categories-list .item p {
    font-size: 16px;
}

.categories-list .item p,
.categories-list .item div,
.categories-list .item {
    margin: 15px 8px;
}

.categories ul li {
    list-style: none;
    background-color: #494949;
    margin: 20px 5px;
    border-radius: 15px;
}

.categories ul {
    display: flex;
    justify-content: center;
}

.categories a {
    color: white;
    padding: 10px 20px;
    display: inline-block;
}

.create-categories a,
.index-categories a {
    all: revert;
    margin: 20px 0;
    display: inline-block;
    text-decoration: none;
}

.create-categories a span,
.index-categories a span {
    font-size: 22px;
}

.index-categories {
    text-align: center;
}
</style>
