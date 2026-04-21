<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title> CRUD </title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <h1> Cread, Read, Update, Delete (CRUD) </h1>
        <button onclick="mostrarAgregarAdministrador('modalAgregarUsuario')">
            Agregar Administrador
        </button>
        <table id="usuariosTable" border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Lastname</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aqui iria lo que se va a inyectar -->
            </tbody>
        </table>

        <div id="modalEditar" style="display:none;">
            <h3> Editar Administrador </h3>
            <form id="mostrarEditarAdministrador">
                ID : <span id="editId"></span><br>
                Username : <input type="text" id="editUsername"><br>
                Password : <input type="text" id="editPassword"><br>
                Email : <input type="text" id="editEmail"><br>
                Name : <input type="text" id="editName"><br>
                Lastname : <input type="text" id="editLastname"><br>
                <button type="button" onclick="guardarEdicion_A()">
                    Guardar
                </button>
            </form>
        </div>
        
        <div id="modalEliminar" style="display:none;">
            <h3> Confirmar Eliminacion </h3>
            <p> ¿Estas seguro de que quieres eliminar este administrador? </p>
            <form id="mostrarEliminarAdministrador">
                <button type="button" onclick="eliminarAdministrador()">
                    Eliminar
                </button>
            </form>
        </div>

        <div id="modalAgregarAdministrador" style="display:none;">
            <h3> Agregar Administrador </h3>
            <form action="insert_datos_a.php" id="nuevoAdministrador" method="post">
                <label for="username"> Username: </label>
                <input type="text" id="username" name="username" required>
                <br><br>
                <label for="password"> Password: </label>
                <input type="password" id="password" name="password" required>
                <br><br>
                <label for="email"> Email: </label>
                <input type="email" id="email" name="email" required>
                <br><br>
                <label for="name"> Name: </label>
                <input type="text" id="name" name="name" required>
                <br><br>
                <label for="lastname"> Lastname: </label>
                <input type="text" id="lastname" name="lastname" required>
                <br><br>
                <button type="submit" name="accion" value="agregar">
                    Agregar
                </button>
            </form>
        </div>

        <!-- Funcion AJAX (Asynchronous JavaScript and XML) -->
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: 'cargar_administradores.php',
                    type: 'GET',
                    success:function(response){
                        $('#usuariosTable tbody').html(response);
                    }
                });
            });

            function mostrarAgregarAdministrador(elementId) {
                var element = document.getElementById(elementId);
                if (elementId) {
                    element.style.display = 'block';
                }
            }

            function mostrarEditarAdministrador(id, username, password, email, name, lastname) {
                document.getElementById('editId').innerText = id;
                document.getElementById('editUsername').value = username;
                document.getElementById('editPassword').value = password;
                document.getElementById('editEmail').value = email;
                document.getElementById('editName').value = name;
                document.getElementById('editLastname').value = lastname;

                document.getElementById('modalEditar').style.display = 'block';
            }

            function guardarEdicion_A() {
                var id = document.getElementById('editId').innerText;
                var username = document.getElementById('editUsername').value;
                var password = document.getElementById('editPassword').value;
                var email = document.getElementById('editEmail').value;
                var name = document.getElementById('editName').value;
                var lastname = document.getElementById('editLastname').value;

                $.ajax({
                    type: 'POST',
                    url: 'guardar_edicion_administrador.php',
                    data: {id, username, password, email, name, lastname},
                    success: function(response) {
                        alert('Administrador editado correctamente');
                        document.getElementById('modalEditar').style.display = 'none';
                        actualizarListaAdministradores()
                    }
                });
            }

            function mostrarEliminarAdministrador() {
                var id = document.getElementById('editId').innerText;

                $.ajax({
                    type: 'POST',
                    url: 'eliminar_administrador.php',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        alert ("Administrador eliminado correctamente");
                        document.getElementById('modalEliminar').style.display = 'none';
                        actualizarListaAdministradores()
                    }
                });
            }

            function actualizarListaAdministradores() {
                $.ajax({
                    url: 'cargar_administradores.php',
                    type: 'GET',
                    success: function(response) {
                        $('#administradoresTable tbody').html(response);
                    }
                });
            }
        </script>
    </body>
</html>