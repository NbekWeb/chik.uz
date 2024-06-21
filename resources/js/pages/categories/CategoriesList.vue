<template>
    <div class="container pt-3">
        <div class="bg-white">
            <h1 class="py-3 text-center">Список категорий</h1>
            <div class="mx-3">
                <a-table :columns="columns" :data-source="categories" bordered>
                    <template #bodyCell="{ column, record }">
                        <template v-if="column.dataIndex === 'action'">
                            <div class="flex items-center justify-start gap-3 ">
                                <router-link :to="{
                                    name: 'EditCategories',
                                    params: { id: record.id },
                                }">
                                    <a-button type="link p-0">

                                        Редактировать
                                    </a-button>
                                </router-link>
                                <a-popconfirm title="Удалить эту категорию?" @confirm="destroy(record.id)">
                                    <template #default>
                                        <a-button danger> Удалить </a-button>
                                    </template>
                                </a-popconfirm>
                            </div>
                        </template>
                    </template>
                </a-table>
            </div>
        </div>

        <!-- success message -->
        <div class="success-msg" v-if="success">
            <i class="fa fa-check"></i>
            Удалено успешно
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

<style scoped>
.edit-link {
    margin-right: 10px;
}

.delete-btn {
    background: none;
    border: none;
    color: #007bff;
    cursor: pointer;
}

.delete-btn:hover {
    color: #0056b3;
}
</style>
