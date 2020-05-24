<template>
    <div>
        <hr>
        <ul class="history-wrapper ">
            <li class="history-item">
                <a href="#" class="alert-link" title="k9nz00@yandex.ru">Andrey Semka</a>
                <span>2 дня назад </span>
                <span>изменил статью</span>
                <div class="w-100 history-body">
                    <div class="d-inline-block">
                        <p class="history-state">Было:</p>
                        <span>Eum at officiis harum dolor nostrum deleniti. Sed reiciendis corrupti nulla</span>
                    </div>
                    <div class="d-inline-block">
                        <p class="history-state">Стало:</p>
                        <span>t necessitatibus quae quaerat praesentium numquam a quia. Optio aut aliquid velit impedit. Quos nobo</span>
                    </div>
                </div>
            </li>
            <li class="history-item">
                <a href="#" class="alert-link" title="k9nz00@yandex.ru">Andrey Semka</a>
                <span>2 дня назад </span>
                <span>изменил статью</span>
                <div class="w-100 history-body">
                    <div class="d-inline-block">
                        <p class="history-state">Было:</p>
                        <span>Eum at officiis harum dolor nostrum deleniti. Sed reiciendis corrupti nulla</span>
                    </div>
                    <div class="d-inline-block">
                        <p class="history-state">Стало:</p>
                        <span>t necessitatibus quae quaerat praesentium numquam a quia. Optio aut aliquid velit impedit. Quos nobo</span>
                    </div>
                </div>
            </li>
            <li class="history-item">
                <a href="#" class="alert-link" title="k9nz00@yandex.ru">Andrey Semka</a>
                <span>2 дня назад </span>
                <span>изменил статью</span>
                <div class="w-100 history-body">
                    <div class="d-inline-block">
                        <p class="history-state">Было:</p>
                        <span>Eum at officiis harum dolor nostrum deleniti. Sed reiciendis corrupti nulla</span>
                    </div>
                    <div class="d-inline-block">
                        <p class="history-state">Стало:</p>
                        <span>t necessitatibus quae quaerat praesentium numquam a quia. Optio aut aliquid velit impedit. Quos nobo</span>
                    </div>
                </div>
            </li>
        </ul>
        <hr>
    </div>
</template>

<script>
    export default {
        name: 'HistoryComponent',
        props: ['history'],
        computed: {
            testHistory() {
                return JSON.parse(this.history)
            }
        },
        methods: {
            getHistory() {
                console.log(this.history)
            }
        }
    }
</script>

<style scoped>

    .history-wrapper {
        margin: 0;
        padding: 0;
    }

    .history-item {
        list-style: none;
        padding-top: 3px;
        padding-bottom: 4px;
    }

    .history-item:hover {
        background: rgba(234, 236, 232, 0.85);
    }


    .history-state {
        font-weight: 700;
        margin: 0;
        padding: 0;
    }

    .history-body > div {
        width: 49%;
    }
</style>
