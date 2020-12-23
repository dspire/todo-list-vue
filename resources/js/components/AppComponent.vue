<style scoped>
.todo-items {
    list-style-type: none;
}
.task-input {
    margin-bottom: 12px;
}
.task-input.input {
    width: 300px;
}
.todo-items {
    text-align: left;
}
</style>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="task-input">
                    <input v-model="newTodo" placeholder="Type your task" v-on:keyup.enter="addTodo">
                </div>
                <ul class="todo-items">
                    <li v-for="item in todos" :key="item.id">
                        <input type="checkbox" v-model="item.completed">
                        <span v-bind:class="{ done: item.completed }">{{ item.title }}</span>
                        <span v-on:click="removeTodo"> X </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['itemsSource'],
    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            newTodo: "",
            todos: [
                // {
                //     "id": 1,
                //     "title": "Draw",
                //     "completed": false
                // }
            ]
        }
    },
    created() {
        let sourceUrl = './' + this.itemsSource;
        this.fetchData(this, sourceUrl)
    },

    computed: {},
    methods: {
        addTodo: function () {
            let val = this.newTodo;
            if (!val) {
                return;
            }

            let num = this.todos[this.todos.length - 1] + 1;
            this.todos.push({
                id: num,
                title: val,
                completed: false
            });
            this.newTodo = "";
        },
        removeTodo: function () {
            alert('removed!');
        },
        fetchData(ref, path) {
            fetch(path)
                .then(
                    function (response) {
                        if (response.status !== 200) {
                            console.log('Http problem. Status Code: ' + response.status);
                            return;
                        }

                        response.json().then(function (data) {
                            ref.todos = data;
                        });
                    }
                )
                .catch(function (err) {
                    console.log('Fetch Error ', err);
                });

        }
    },
}
</script>
