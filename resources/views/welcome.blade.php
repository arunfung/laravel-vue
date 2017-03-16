<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta id="token" name="token" value="{{ csrf_token() }}">
        <title>Laravel-Vue</title>
        <link rel="stylesheet" href="{{mix('/css/app.css')}}">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif
        </div>
        <div class="container">
            <tasks-app></tasks-app>
        </div>
        <template id="tasks-template">
            <form class="form-group" @submit.prevent="createTask">
                <input type="text" class="form-control" v-model="notes">
                <button type="submit" class="btn btn-success btn-block">Create Task</button>
            </form>
            <h1>my tasks</h1>
            <ul class="list-group">
                <li class="list-group-item" v-for="task in list | orderBy 'id' -1">
                    @{{task.body}} <strong @click="deleteTask(task)">X</strong>
                </li>
            </ul>
        </template>

        <script src="http://cdn.bootcss.com/vue/1.0.14/vue.js"></script>
        {{--<link rel="stylesheet" href="{{mix('/js/app.js')}}">--}}
        <script src="http://cdn.bootcss.com/vue-resource/1.2.1/vue-resource.min.js"></script>
        <script>

            Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
            var resource = Vue.resource('api/tasks/{id}');
            Vue.component('tasks-app',{
                template:'#tasks-template',
                data:function () {
                    return {
                        notes:'',
                        list:[]
                    }
                },
                created:function () {
                    var vm = this;
//                    this.list = JSON.parse(this.list);
                    this.$http.get('api/tasks').then(response => {
//                        console.log(response.data);
                        vm.list = response.data;
                }, response => {

                    });
                },
                methods:{
                    deleteTask: function (task) {
                        resource.delete({id: task.id}).then(response => {
                            console.log(response.data);
                            // success callback
                        }, response => {
                            // error callback
                        });
                        this.list.$remove(task);
                    },
                    createTask: function (){

                        Vue.http.post('api/tasks', {body:this.notes}).then(response => {
                            this.list.push(response.data.task);
                            this.notes = '';
                        }, response=>{

                        });
                    }
                }

            });
            new Vue({
                el:'.container'
            })
        </script>
    </body>
</html>
