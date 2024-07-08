<template>
    <div class="container">
        <p class="text-2xl text-black font-medium pt-4 md:mb-16 max-md:mb-10">
            Чтобы использовать банковскую карту Humo и Uzcard для оплаты, на
            нужной странице следует нажать кнопку «Пополнить баланс». Это
            позволит осуществить оплату через мобильный приложение ООО «Click» и
            ИП OOO «INSPIRED» PAYME
        </p>
        <p class="text-2xl font-medium mb-4">
            Для оплаты нужно перейти: Логин > Админ > Платежи/транзакции >
            выбрать: Click либо Payme > Оплатить
        </p>
        <div class="flex justify-center payment md:pb-10 max-md:pb-6">
            <div class="">
                <a-table
                    :columns="columns"
                    :data-source="data"
                    bordered
                    pagination="false"
                >
                </a-table>
            </div>
        </div>
    </div>
</template>

<script setup>
const columns = [
    {
        title: "Подпроцессор",
        dataIndex: "name",
        key: "name",
    },
    {
        title: "Вид обработки",
        dataIndex: "age",
        key: "age",
    },
];

const data = [
    {
        key: 1,
        name: "Payme",
        age: " Процессинг платежей",
    },
    {
        key: 2,
        name: "Click",
        age: " Процессинг платежей",
    },
    {
        key: 3,
        name: "Octopay",
        age: " Процессинг платежей",
    },
];
</script>
<style>
.payment .ant-table-wrapper .ant-table-pagination.ant-pagination {
    display: none !important;
}

.ant-table-wrapper .ant-table-thead > tr > th {
    font-weight: 800 !important;
}
.ant-table-wrapper
    .ant-table.ant-table-bordered
    > .ant-table-container
    > .ant-table-content
    > table
    > thead
    > tr
    > th {
    padding: 16px 100px 16px 16px !important;
}
</style>
