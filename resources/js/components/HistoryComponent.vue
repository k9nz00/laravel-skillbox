<template>
    <div>
        <hr>
        <ul class="history-wrapper ">
            <li v-for="item in historyItems" class="history-item">
                <a href="#" class="alert-link" :title="item.email">{{item.name}}</a>
                <span>{{item.created_at}}</span>
                <span>изменил статью</span>
                <div class="w-100 history-body">
                    <div class="d-inline-block">
                        <p class="history-state">Было:</p>
                        <span class="history-item-wrap" v-for="(historyItemValue, historyItemKey) in item.beforeValue">
                            <span class="history-item-key">{{historyItemKey}}:</span><span class="history-item-value">{{historyItemValue}}</span>
                        </span>
                    </div>
                    <div class="d-inline-block">
                        <p class="history-state">Стало:</p>
                        <span class="history-item-wrap" v-for="(historyItemValue, historyItemKey) in item.afterValue">
                            <span class="history-item-key">{{historyItemKey}}:</span><span class="history-item-value">{{historyItemValue}}</span>
                        </span>
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
            historyItems() {
                let arr = []
                this.history.forEach((item) => {
                    let obj = {
                        name: item.name,
                        created_at: item.pivot.created_at,
                        email: item.email,
                        afterValue: JSON.parse(item.pivot.after),
                        beforeValue: JSON.parse(item.pivot.before)
                    }
                    arr.push(obj)
                })
                return arr
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
        padding-top: 15px;
        padding-bottom: 0;
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

    .history-item-wrap {
        display: block;
    }

    .history-item-value {
        font-style: italic;
        color: #2a7048;
    }

    .history-item-key {
        font-weight: 700;

    }
</style>
