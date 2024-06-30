<template>
    <div class="container">
        <h1 class="pt-3 text-center">Изменить категорию!</h1>

        <!-- Success message -->
        <!-- <div class="success-msg" v-if="success">
            <i class="fa fa-check"></i>
            Успешно обновлено
        </div> -->
        <a-modal v-model:open="previewVisible" wrapClassName="edit_cat">
            <img
                :src="previewImage"
                alt="Image Preview"
                style="width: 100%"
                v-if="previewImage"
            />
            <img :src="formState.img" alt="Image Preview" v-else />
        </a-modal>

        <!-- Form -->
        <div class="pt-2 max-w-[500px]">
            <a-form
                :model="formState"
                :rules="rules"
                @submit.prevent="submit"
                ref="formRef"
                layout="vertical"
            >
                <a-form-item
                    label="Название категории"
                    name="name"
                    :validateStatus="getError('name')"
                >
                    <a-input v-model:value="formState.name"></a-input>
                </a-form-item>

                <a-form-item label="Мену ид" name="menu_id">
                    <a-select
                        v-model:value="formState.menu_id"
                        show-search
                        placeholder="Выберите  мену ид"
                        style="width: 200px"
                        :options="items"
                    ></a-select>
                </a-form-item>

                <a-form-item label="Фото" name="photos">
                    <a-upload
                        v-if="!formState.img || showPhoto"
                        v-model:file-list="fileList"
                        list-type="picture-card"
                        accept=".jpg,.jpeg,.png"
                        class="avatar-uploader w-[300px]"
                        :show-upload-list="true"
                        :before-upload="beforeUpload"
                        @change="handleChange"
                        @preview="handlePreview"
                        :customRequest="dummyRequest"
                    >
                        <div v-if="fileList.length < 1">
                            <PlusOutlined />
                            <div class="ant-upload-text">Загрузить</div>
                        </div>
                    </a-upload>
                    <div
                        v-else
                        class="w-[102px] h-[102px] rounded-lg p-2"
                        style="border: 1px solid #d9d9d9"
                    >
                        <div class="relative w-full h-full def-avator">
                            <img
                                :src="formState.img"
                                alt=""
                                class="object-cover w-full h-full"
                            />
                            <div
                                class="absolute top-0 w-full h-full text-center border bg-inherit def-img"
                            >
                                <div
                                    class="flex items-center justify-center h-full gap-2"
                                >
                                    <span
                                        role="img"
                                        aria-label="eye"
                                        @click="handlePreview"
                                        class="anticon anticon-eye"
                                    >
                                        <svg
                                            focusable="false"
                                            data-icon="eye"
                                            width="1em"
                                            height="1em"
                                            fill="currentColor"
                                            aria-hidden="true"
                                            viewBox="64 64 896 896"
                                        >
                                            <path
                                                d="M942.2 486.2C847.4 286.5 704.1 186 512 186c-192.2 0-335.4 100.5-430.2 300.3a60.3 60.3 0 000 51.5C176.6 737.5 319.9 838 512 838c192.2 0 335.4-100.5 430.2-300.3 7.7-16.2 7.7-35 0-51.5zM512 766c-161.3 0-279.4-81.8-362.7-254C232.6 339.8 350.7 258 512 258c161.3 0 279.4 81.8 362.7 254C791.5 684.2 673.4 766 512 766zm-4-430c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm0 288c-61.9 0-112-50.1-112-112s50.1-112 112-112 112 50.1 112 112-50.1 112-112 112z"
                                            ></path>
                                        </svg>
                                    </span>
                                    <span
                                        role="img"
                                        aria-label="delete"
                                        class="anticon anticon-delete"
                                        @click="deleteImg"
                                    >
                                        <svg
                                            focusable="false"
                                            data-icon="delete"
                                            width="1em"
                                            height="1em"
                                            fill="currentColor"
                                            aria-hidden="true"
                                            viewBox="64 64 896 896"
                                        >
                                            <path
                                                d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"
                                            ></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a-form-item>

                <a-button type="primary" html-type="submit" class="mt-3"
                    >Сохранить</a-button
                >
            </a-form>
        </div>

        <div class="pb-3 text-center create-categories">
            <router-link :to="{ name: 'CategoriesList' }"
                >Список категорий <span>&#8594;</span>
            </router-link>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { PlusOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";

const previewVisible = ref(false);
const props = defineProps(["id"]);
const id = props.id;
const formRef = ref(null);
const fileList = ref([]);
const items = ref([]);
const formState = ref({
    name: "",
    img: null,
    menu_id: null,
});
const errors = reactive({});
const showPhoto = ref(false);
const loading = ref(false);
const previewImage = ref("");
const images = ref([]);
const imageUrl = ref("");

const rules = reactive({
    name: [
        {
            required: true,
            message: "Пожалуйста, введите название категории!",
            trigger: "blur",
        },
    ],
    photos: [{ validator: checkFileList, trigger: "change" }],
    // menu_id: [
    //     {
    //         required: true,
    //         message: "Пожалуйста, выберите  мену ид",
    //         trigger: "blur",
    //     },
    // ],
});

const dummyRequest = ({ file, onSuccess }) => {
    setTimeout(() => {
        onSuccess("ok");
    }, 0);
};

function getBase64(img, callback) {
    if (!img) return;
    const reader = new FileReader();
    reader.addEventListener("load", () => {
        if (typeof callback === "function") {
            callback(reader.result);
        }
    });
    reader.readAsDataURL(img);
}

const deleteImg = () => {
    formState.value.img = null;
    showPhoto.value = true;
};

const handleChange = (info) => {
    const newFileList = info.fileList.slice(-10);
    fileList.value = newFileList;

    if (info.file.status === "done" || info.file.status === "uploading") {
        loading.value = true;
    }

    if (info.file.status === "done") {
        getBase64(info.file.originFileObj, (url) => {
            loading.value = false;
            imageUrl.value = url;
        });
        images.value.push(info.file.originFileObj);
    }
};

const handlePreview = async (file) => {
    if (!file.url && !file.preview) {
        file.preview = await getBase64(file.originFileObj);
    }
    previewImage.value = file.thumbUrl;
    previewVisible.value = true;
};

const beforeUpload = (file) => {
    const isJpgOrPng = file.type === "image/jpeg" || file.type === "image/png";
    if (!isJpgOrPng) {
        message.error("Вы можете загружать только JPG/PNG файл!");
        return false;
    }
    const isLt2M = file.size / 1024 / 1024 < 2;
    if (!isLt2M) {
        message.error("Изображение должно быть меньше 2MB!");
        return false;
    }
    return true;
};

function checkFileList() {
    return new Promise((resolve, reject) => {
        if (fileList.value.length != 1 && !formState.value.img) {
            reject("Изображение обязательно!");
        } else {
            resolve();
        }
    });
}

const router = useRouter();

const submit = () => {
    if (
        !!formState.value.name &&
        !!formState.value.menu_id &&
        (!!formState.value.img || !!images.value[0])
    ) {
        const formData = new FormData();
        formData.append("name", formState.value.name);
        formData.append("menu_id", formState.value.menu_id);
        formData.append("_method", "PUT");
        if (images.value[0]) {
            formData.append("photo", images.value[0]);
        }
        axios
            .post("/api/categories/" + id, formData)
            .then(() => {
                formState.value.name = "";
                formState.value.img = null;
                fileList.value = [];
                images.value = [];
                message.success("Меню успешно добавлено!");
                router.push({ name: "CategoriesList" });
            })
            .catch((error) => {
                message.error(error.message);
            });
    } else {
        message.error("Заполните все поля!");
    }
};

const getError = (fieldName) => {
    return errors[fieldName] ? "error" : "";
};

// Fetch initial data

onMounted(async () => {
    await axios
        .get("/api/menu_list")
        .then((res) => {
            const menuItems = [];
            for (let i = 0; i < res.data.data.length; i++) {
                const item = {
                    label: res.data.data[i].name,
                    value: res.data.data[i].id,
                };
                menuItems.unshift(item);
            }
            items.value = menuItems;
        })
        .catch((error) => {
            console.error("Error fetching menu list:", error);
        });

    await axios
        .get(`/api/categories/${id}`)
        .then((response) => {
            loading.value = true;
            formState.value.name = response.data.name;
            formState.value.img = response.data.photo;
            formState.value.menu_id = response.data.menu_id;
        })
        .catch((error) => {
            console.error(error);
        });
});
</script>

<style>
.edit_cat .ant-modal .ant-modal-body img {
    padding-top: 30px !important;
    width: 100% !important;
    height: 100% !important;
    max-height: 500px !important;
    object-fit: cover !important;
}

.ant-form-item-with-help .ant-form-item-explain {
    color: red !important;
}
.def-img {
    display: none;
}
.def-avator:hover {
    background: rgba(0, 0, 0, 0.45);
    color: rgba(256, 256, 256, 0.8) !important;
}

.def-avator .anticon:hover {
    color: #fff;
}

.def-avator:hover .def-img {
    display: block;
}
</style>
