<template>

    <div class="container">

        <div class="row top">
            <div class="col d-flex justify-content-center">
                <form class="form-inline" v-on:submit.prevent>
                    <div class="form-group mb-2">
                        <input  class="form-control" type="text" v-model.lazy="searchText" placeholder="Search">
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <h1>Todo List</h1>
            </div>
            <div class="col-sm-6 col-lg-9">
                <modal-component 
                    v-bind:id-name="'create'"
                    v-bind:head-title="'Add new todo thing'"
                    v-bind:btn-color="'btn-primary'"
                    v-bind:button-text="'Add new one'"
                    v-bind:ok-text="'Save'"
                    v-on="{onClick:resetInput, onConfirm:addNewPost, onCancel:resetInput}">
                    <form v-on:submit.prevent>
                        <div class="form-group">
                            <label for="title">title</label>
                            <input type="text" class="form-control" id="title" v-model="input.title">
                        </div>
                        <div class="form-group">
                            <label for="content">content</label>
                            <textarea class="form-control" rows="3" id="content" v-model="input.content"></textarea>
                        </div>
                    </form>
                </modal-component>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">title</th>
                    <th scope="col">content</th>
                    <th scope="col">created at</th>
                    <th scope="col">updated at</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list,index) in lists" v-bind:key="index">
                    <td scope="row">{{ list.title }}</td>
                    <td scope="row">{{ list.content }}</td>
                    <td scope="row">{{ list.created_at }}</td>
                    <td scope="row">{{ list.updated_at }}</td>
                    <td scope="row">
                        <modal-component 
                            v-bind:id-name="'edit'"
                            v-bind:head-title="'Edit'"
                            v-bind:btn-color="'btn-success'"
                            v-bind:button-text="'Edit'"
                            v-bind:ok-text="'Update'"
                            v-on:onClick="setInput(list)"
                            v-on:onConfirm="updatePost(list.id)"
                            v-on:onCancel="resetInput">
                            <form v-on:submit.prevent>
                                <div class="form-group">
                                    <label for="title">title</label>
                                    <input type="text" class="form-control" id="title" v-model="input.title">
                                </div>
                                <div class="form-group">
                                    <label for="content">content</label>
                                    <textarea class="form-control" rows="3" id="content" v-model="input.content"></textarea>
                                </div>
                            </form>
                        </modal-component>
                    </td>
                    <td scope="row"><button class="btn btn-danger" v-on:click="onDelet(list.id)">delete</button></td>
                </tr>
            </tbody>
        </table>
        
    </div>

</template>

<script>
import  ModalComponent  from "./ModalComponent.vue"
export default {
    components: {
        ModalComponent
    },
    data() {
        return {
            searchText: '',
            input:{
                title: '',
                content: ''
            },
            lists: null
        }
    },
    watch: {
        searchText: function() {
            this.debouncedGetList();
        }
    },
    methods: {
        onDelet(id) {
            axios.delete('api/todolist/delete/'+id)
                .then(response=>{
                    console.log(response.data);
                    this.getTodoListData();
                })
                .catch(error=>(console.log(error)))
        },
        getTodoListData() {
            const search = this.searchText==='' ? {} : {search:this.searchText}

            axios.get('api/todolist',{params:search})
            .then(response=>(this.lists = response.data))
        },
        addNewPost() {
            axios.post('api/todolist/add', this.input)
                .then(response=>{
                    console.log(response.data);
                    this.getTodoListData();
                });
        },
        updatePost(id) {
            const updateData = {
                id,
                title: this.input.title,
                content: this.input.content
            }
            axios.patch('api/todolist/update/' ,updateData)
                .then(response=>{
                    console.log(response.data);
                    this.getTodoListData();
                })
        },
        resetInput() {
            this.input.title='',
            this.input.content=''
        },
        setInput(list) {
            this.input.title = list.title;
            this.input.content = list.content;
        }
    },
    mounted() {
        console.log("TodoComponent mount.");
        this.getTodoListData();
    },
    created: function() {
        this.debouncedGetList = _.debounce(this.getTodoListData, 500)
    }
}
</script>
