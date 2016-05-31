<!DOCTYPE html>

<html lang="en">

<html>
<head>
    <meta id="token" name="token" value="{{ csrf_token() }}">
    <title>¡Chats!</title>
    <link rel="stylesheet" href="/css/materialize.min.css">
    <link rel="stylesheet" href="/css/app2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12" v-if="formulario">
                <br><br>
                <form class="col s12" action="/Chat" method="POST" @submit.prevent="AgregarChat">
                    <center>
                        <div class="card-panel">
                            <span class="">
                                <div class="input-field col s12">
                                    <b class="left">Usuario 1:</b>
                                        <input type="text" class="validate" name="usuario" v-model="usuario1" required/>
                                </div>
                                <div class="input-field col s12">
                                    <b class="left">Usuario 2:</b>
                                        <input type="text" class="validate" name="usuario" v-model="usuario2" required/>
                                </div>
                                <div class="col s12" v-show="usuario2">
                                    <button type="submit" class=" col s12 waves-effect waves-light btn pink darken-4"> 
                                        Iniciar chat
                                    </button>
                                </div>
                            </span>
                        </div>
                    </center>
                </form>
            </div>
            <div class="col s12" v-else>
                <br><br>
                <form class="col s12" @submit.prevent="MostrarChats">
                    <center>
                        <div class="card-panel" id="card-panel1">
                            <span class="">
                                <ul v-for="chat in Chats">
                                    <li>
                                        <div class="input-field col s12">
                                            <b class="left">Usuario1: @{{ usuario1 }}</b>
                                            <input type="text" class="validate" name="usuario" v-model="mensaje1" placeholder="@{{ usuario1 }} dice..."/>
                                        </div>
                                        <div class="col s12">
                                            <button type="submit" class="col s4 waves-effect waves-light btn pink darken-4 right" v-on:click="InsertarChat1()"> 
                                                Enviar
                                            </button>
                                        </div>
                                        <div class="input-field col s12">
                                            <b class="left">Usuario2: @{{ usuario2 }}</b>
                                            <input type="text" class="validate" name="usuario" v-model="mensaje2" placeholder="@{{ usuario2 }} dice..."/>
                                        </div>
                                        <div class="col s12">
                                            <button type="submit" class="col s4 waves-effect waves-light btn pink darken-4 right" v-on:click="InsertarChat2()"> 
                                                Enviar
                                            </button>
                                        </div>
                                    </li>
                                </ul>
                            </span>
                        </div>
                    </center>
                </form>
            </div>
            <div class="col s12" v-if="formulario==false">
                <center>
                    <div class="card-panel" id="card-panel2">
                        <p v-for="chat in Chats2">
                            <label><b>Usuario:</b> @{{ chat.usuario }}</label>
                            <br>
                            <label><b>Mensaje:</b> @{{ chat.mensaje }}</label>
                        </p>
                    </div>
                </center>
            </div>
        </div>
    </div>
    <!--<div class="container col s12">
        <div class="container">
            <p>
                <h4>Chats ( @{{ contador }} )</h4>
                <form class="col s12" action="/Chat" method="POST" @submit.prevent="AgregarChat" v-if="contador < 5">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="input-field col s12">
                            <b>Usuario:</b>
                                <input type="text" class="validate" name="usuario" v-model="nuevoChat.usuario" placeholder="Escribir usuario..." required/>
                        </div>
                        <div class="input-field col s12">
                            <b>Mensaje:</b>
                                <input type="text" class="validate" name="mensaje" v-model="nuevoChat.mensaje" placeholder="Escribir mensaje..." required/>
                        </div>
                    </div>
                    <div class="col s12" v-show="nuevoChat.mensaje">
                        <button type="submit" class=" col s12 waves-effect waves-light btn pink darken-4"> 
                            Agregar
                        </button>
                    </div>
                </form>
                <div id="mensaje" v-else>
                    <h6>
                        <center>
                            Llegó al limite de Chats
                        </center>
                    </h6>
                </div>
            </p>
        </div>
        <div class="container">
            <ul v-for="chat in Chats">
                <li>
                    <hr>
                    <b>Usuario:</b> @{{ chat.usuario }}
                    <button class="right" v-on:click="removeChat(chat)" id="eliminar">
                        Eliminar <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <br>
                    <b>Mensaje:</b> @{{ chat.mensaje }}
                    <hr>
                </li>
            </ul>
                <button type="submit" class="col s12 waves-effect waves-light btn pink darken-4 right" v-if="contador == 5" v-on:click="InsertarChat()">
                    Almacenar chats
                </button>
        </div>
        <div class="container">
            <br><br><hr>
            <h4>Chats almacenados ( @{{ Chats2.length }} )</h4>
            <p v-for="chat in Chats2">
                <label><b>Usuario:</b> @{{ chat.usuario }}</label>
                <br>
                <label><b>Mensaje:</b> @{{ chat.mensaje }}</label>
            </p>
            <hr>
        </div>
    </div>-->

    <script src="/js/jquery-2.2.1.min.js"></script>
    <script src="/js/materialize.min.js"></script>
    <script src="/js/vue.min.js"></script>
    <script src="/js/vue-resource.min.js"></script>
    <script src="/js/app.js"></script>

    <script>

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    
    new Vue({

        el:"body",
        data:{
            formulario: true,
            contador: 0,
            usuario1:'',
            usuario2:'', 
            mensaje1:'',
            mensaje2:'',
            nuevoChat: {
                usuario:'',
                mensaje:'',
            },
            Chats: [],
            Chat:"",
            Chats2: [],
        },
        ready: function(){
            this.MostrarChats();
        },
        methods: {
                AgregarChat: function(){
                    var chat = this.nuevoChat;
                    this.Chats.push(chat);
                    this.nuevoChat = { usuario:'', mensaje:''};
                    //this.contador = this.contador + 1;
                    this.formulario = false;
                },
                InsertarChat1: function(){
                    var chat = this.Chats;
                    //for(var i in chat){
                        this.$http.post('/Chat', {'usuario': this.usuario1, 'mensaje': this.mensaje1}).then(
                            function(response){ 
                                Materialize.toast('Mensaje enviado correctamente.', 3000, 'rounded');
                            },
                            function(response){ 
                                Materialize.toast('Error al enviar mensaje.', 3000, 'rounded');
                            }
                        );
                    //}
                    this.MostrarChats();
                },
                InsertarChat2: function(){
                    var chat = this.Chats;
                    //for(var i in chat){
                        this.$http.post('/Chat', {'usuario': this.usuario2, 'mensaje': this.mensaje2}).then(
                            function(response){ 
                                Materialize.toast('Mensaje enviado correctamente', 3000, 'rounded');
                            },
                            function(response){ 
                                Materialize.toast('Error al enviar mensaje.', 3000, 'rounded');
                            }
                        );
                    //}
                    this.MostrarChats();
                },
                MostrarChats: function(){
                    this.$http.get('/Chat/Mostrar').then(function(response){
                        this.$set('Chats2', response.data);
                    });
                },
                removeChat: function(chat){
                    this.Chats.$remove(chat);
                    this.contador = this.contador - 1;
                },
            },
        });
    </script>
</body>
</html>

<!--
    <script>

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    
    new Vue({

        el:"body",
        data:{
            contador: 0,
            nuevoChat: {
                usuario:'',
                mensaje:'',
            },
            Chats: [],
            Chat:"",
            Chats2: [],
        },
        ready: function(){
            this.MostrarChats();
        },
        methods: {
                AgregarChat: function(){
                    var chat = this.nuevoChat;
                    this.Chats.push(chat);
                    this.nuevoChat = { usuario:'', mensaje:''};
                    this.contador = this.contador + 1;
                },
                InsertarChat: function(){
                    var chat = this.Chats;
                    for(var i in chat){
                        this.$http.post('/Chat',chat[i]).then(
                            function(response){ 
                                Materialize.toast('Chat agregado correctamente', 3000, 'rounded');
                            },
                            function(response){ 
                                Materialize.toast('Error al insertar chat', 3000, 'rounded');
                            }
                        );
                    }
                    this.MostrarChats();
                },
                MostrarChats: function(){
                    this.$http.get('/Chat/Mostrar').then(function(response){
                        this.$set('Chats2', response.data);
                    });
                },
                removeChat: function(chat){
                    this.Chats.$remove(chat);
                    this.contador = this.contador - 1;
                },
            },
        });
    </script>
-->