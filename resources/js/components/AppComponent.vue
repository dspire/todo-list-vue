<style scoped>
.todo-items {
    list-style-type: none;
}

.task-input {
    margin-bottom: 12px;
}

.task-input input {
    width: 300px;
}

.todo-items {
    text-align: left;
}

.todo-items .done {
    text-decoration: line-through;
}

.todo-items li .destroy {
    content: '';
    width: 12px;
    height: 12px;
    margin-left: 20px;
    display: inline-block;
    background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTIgMmM1LjUxNCAwIDEwIDQuNDg2IDEwIDEwcy00LjQ4NiAxMC0xMCAxMC0xMC00LjQ4Ni0xMC0xMCA0LjQ4Ni0xMCAxMC0xMHptMC0yYy02LjYyNyAwLTEyIDUuMzczLTEyIDEyczUuMzczIDEyIDEyIDEyIDEyLTUuMzczIDEyLTEyLTUuMzczLTEyLTEyLTEyem01IDE1LjUzOGwtMy41OTItMy41NDggMy41NDYtMy41ODctMS40MTYtMS40MDMtMy41NDUgMy41ODktMy41ODgtMy41NDMtMS40MDUgMS40MDUgMy41OTMgMy41NTItMy41NDcgMy41OTIgMS40MDUgMS40MDUgMy41NTUtMy41OTYgMy41OTEgMy41NSAxLjQwMy0xLjQxNnoiLz48L3N2Zz4=");
    background-repeat: no-repeat;
    background-position: center;
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
                        <span v-on:click="removeTodo(item)" class="destroy"></span>
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
            todos: []
        }
    },
    created() {
        this.fetchData(this, this.sourceUrl)
    },
    computed: {
        sourceUrl: function () {
            return './' + this.itemsSource
        }
    },
    methods: {
        addTodo: function () {
            let val = this.newTodo;
            if (!val) {
                return;
            }

            this.addTodoRequest('./' + this.itemsSource, {
                "title": val
            });

            let num = this.todos[this.todos.length - 1] + 1;
            this.todos.push({
                id: num,
                title: val,
                completed: false
            });
            this.newTodo = "";
        },
        removeTodo: function (todo) {
            console.log(todo);
            this.removeTodoRequest('./' + this.itemsSource + '/' + todo.id);
            this.todos.splice(this.todos.indexOf(todo), 1);
        },
        addTodoRequest: function (path, data) {
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(path, {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-type": "application/json; charset=UTF-8",
                    "X-CSRF-TOKEN": token
                }
            })
                .then(response => response.json())
                .then(json => console.log(json))
                .catch(err => console.log(err));
        },
        removeTodoRequest: function (path) {
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(path, {
                method: "DELETE",
                headers: {
                    "Content-type": "application/json; charset=UTF-8",
                    "X-CSRF-TOKEN": token
                }
            })
                .then(response => response.json())
                .then(json => console.log(json))
                .catch(err => console.log(err));

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
