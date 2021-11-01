<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Список</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <input type="text"
                                       class="form-control pull-left"
                                       v-model="itemModel"
                                >
                            </div>
                            <div class="col-3 text-right">
                                <button type="button"
                                        class="btn btn-secondary"
                                        :disabled="!itemModel"
                                        @click="addItem"
                                >
                                    Добавить
                                </button>
                            </div>
                        </div>

                        <div class="items">
                            <h3>Список элементов:</h3>
                            <div class="text-success" v-if="successMessage">{{ successMessage }}</div>
                            <div class="text-danger"
                                 v-if="errors && errors.items && errors.items[0] && errors.items[0] === 'validation.min.array'"
                            >
                                В списке должно быть минимум 5 записей
                            </div>

                            <ul>
                                <li v-for="(item, key) in items" :key="key">
                                    {{ item.item }}
                                    <span>
                                        <button type="button"
                                                class="btn btn-link btn-sm"
                                                :disabled="items.length === 0"
                                                @click="removeItem(key)"
                                        >
                                            (Удалить)
                                        </button>
                                    </span>
                                    <div v-if="errors" class="text-danger">
                                        <span v-if="errors['items.' + key + '.item']">Такая запись уже существует</span>
                                    </div>
                                </li>
                            </ul>

                            <button type="button"
                                    class="btn btn-primary"
                                    :disabled="items.length === 0"
                                    @click="sendItems"
                            >
                                Отправить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            items: [],
            errors: null,
            itemModel: null,
            successMessage: null,
        }
    },
    methods: {
        addItem() {
            this.items.push({
                item: this.itemModel
            });
            this.itemModel = null;
            this.successMessage = null;
        },
        removeItem(key) {
            this.items.splice(key, 1);
            this.errors['items.' + key + '.item'] = null;
            this.successMessage = null;
        },
        sendItems () {
            axios.post(
                '/items',
                {items: this.items}
            ).then(response => {
                this.errors = null;
                this.successMessage = response.data;
            }).catch(error => {
                this.errors = error.response.data.errors;
                this.successMessage = null;
            });
        }
    },
}
</script>

<style>
.items {
    margin-top: 20px;
}
</style>
