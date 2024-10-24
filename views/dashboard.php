<?php 
session_start();
require_once '../config/db.php';
require_once '../controllers/UserController.php';


$userController = new UserController($pdo);
$users = $userController->getUsers();


?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>Aplicacion - Dashboard</title>
    <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .sidebar {
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="dashboard-bg">
        <div class="container-fluid">
            <header class="text-center my-4">
                <h1>Sistema web de Procesamiento de datos RollPay</h1>
            </header>

            <div class="row flex-fill">
                <!-- Navegación -->
                <nav class="col-md-2 sidebar bg-light">
                    <h5 class="mt-3">Mantenimiento</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Usuarios</a>
                        </li>
                    </ul>
                    <h5 class="mt-3">
                        <a class="nav-link" href="logout.php">Salir</a>
                    </h5>
                </nav>

                <!-- Contenido -->
                <main class="col-md-9">
                    <h2 class="mt-3">Lista de Usuarios</h2>
                    <table id="userTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo $usuario['username']; ?></td>
                                <td><?php echo $usuario['email']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm editUser" data-id="<?php echo $usuario['id']; ?>">Editar</button>
                                    <button class="btn btn-danger btn-sm deleteUser" data-id="<?php echo $usuario['id']; ?>">Eliminar</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>
    </div>

<script src="../public/assets/js/jquery-3.7.1.min.js"></script>
<script src="../public/assets/js/bootstrap.bundle.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
<script src="../public/assets/js/bootstrap.min.js"></script>
                            

<script>
        $(document).ready(function() {
            // DataTable
            var table = $('#userTable').DataTable();

            // Editar usuario
            $(document).on('click', '.editUser', function() {
                var userId = $(this).data('id');

                
                $.ajax({
                    url: 'get_user.php',
                    type: 'POST',
                    data: { id: userId },
                    dataType: 'json',
                    success: function(data) {
                        $('#editUserId').val(data.id);
                        $('#editUsername').val(data.username);
                        $('#editEmail').val(data.email);
                        // modal
                        $('#editUserModal').modal('show');
                    },
                    error: function() {
                        alert('Error al obtener los datos del usuario. Inténtalo de nuevo.');
                    }
                });
            });

            // Eliminar usuario
            $(document).on('click', '.deleteUser', function() {
                var userId = $(this).data('id');
                if(confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                    $.ajax({
                        url: 'delete_user.php', 
                        type: 'POST',
                        data: { id: userId },
                        success: function(response) {
                            table.row($(this).closest('tr')).remove().draw();
                            alert('Usuario eliminado correctamente.');
                        },
                        error: function() {
                            alert('Error al eliminar el usuario. Inténtalo de nuevo.');
                        }
                    });
                }
            });


        });
    </script>

</body>
</html>


