<template>
    <div class="container pt-3">
        <div class="bg-white">
            <h1 class="py-3 text-center">Список категорий</h1>
            <div class="mx-3">
                <a-table :columns="columns" :data-source="categories" bordered>
                    <template #action="{  record }">
                        <a-popconfirm
                            v-if="categories.length > 0"
                            title="Удалить эту категорию?"
                            @confirm="onDelete(record.id)"
                        >
                            <template #default>
                                <p>Delete</p>
                            </template>
                        </a-popconfirm>
                    </template>
                </a-table>
            </div>
        </div>

        <!-- success message -->
        <div class="success-msg" v-if="success">
            <i class="fa fa-check"></i>
            Удалено успешно
        </div>

        <!-- List of categories -->
        <div
            class="item"
            v-for="(category, index) in categories"
            :key="category.id"
        >
            <span>{{ index + 1 }}</span>
            <p>{{ category.name }}</p>
            <div>
                <router-link
                    class="edit-link"
                    :to="{
                        name: 'EditCategories',
                        params: { id: category.id },
                    }"
                >
                    Редактировать
                </router-link>
            </div>
            <button
                type="button"
                @click="destroy(category.id)"
                class="delete-btn"
            >
                Удалить
            </button>
        </div>

        <!-- Navigation to Create Categories -->
        <div class="index-categories">
            <router-link :to="{ name: 'CreateCategories' }">
                Создать категорию <span>&#8594;</span>
            </router-link>
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
    },
    {
        title: "Действия",
        dataIndex: "action",
    },
];

// Fetch categories function
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

// Delete category function
const destroy = (id) => {
    axios
        .delete("/api/categories/" + id)
        .then(() => {
            success.value = true;
            setTimeout(() => {
                success.value = false;
            }, 2500);
            fetchCategories(); // Refresh categories after deletion
        })
        .catch((error) => {
            console.error(error);
        });
};

onMounted(fetchCategories); // Fetch categories when component is mounted
</script>
