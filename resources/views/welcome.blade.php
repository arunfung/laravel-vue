<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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

            <div class="content">
                <tasks-app></tasks-app>
            </div>
        </div>
        <template id="tasks-template">
            <h1>my tasks</h1>
            <ul class="list-group">
                <li class="list-group-item" v-for="task in list">
                    @{{task.body}} <strong @click="deleteTask(task)">X</strong>
                </li>
            </ul>
        </template>

        <script src="http://cdn.bootcss.com/vue/1.0.14/vue.js"></script>
        <script src="http://cdn.bootcss.com/vue-resource/1.2.1/vue-resource.min.js"></script>

        <script>
            Vue.component('tasks-app',{
                template:'#tasks-template',
                data:function () {
                    return {
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
                        this.list.$remove(task);
                    }
                }

            });
            new Vue({
                el:'.content'
            })
        </script>
    </body>
</html>
