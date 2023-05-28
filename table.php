<!DOCTYPE html>
<html>
<head>
    <title>Editar e Deletar Dados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Editar e Deletar Dados</h1>
        <?php
        // Conexão com o banco de dados (substitua as informações de acordo com seu ambiente)
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'cordeiro';

        $conn = mysqli_connect($host, $username, $password, $database);

        // Verifica se houve algum erro na conexão
        if (mysqli_connect_errno()) {
            echo 'Falha ao conectar com o banco de dados: ' . mysqli_connect_error();
            exit();
        }

        // Função para escapar caracteres especiais para uso em consultas SQL
        function escape($str) {
            global $conn;
            return mysqli_real_escape_string($conn, $str);
        }

        // Verifica se o formulário de edição foi enviado
        if (isset($_POST['editarId'])) {
            $id = $_POST['editarId'];
            $novoNome = escape($_POST['editarNome']);
            $novoEmail = escape($_POST['editarCpf']);
 
    
            // Atualiza os dados no banco de dados
            $sql = "SELECT * FROM cliente WHERE id='$id'";
            $query = $conn -> query($sql);
            $alt = $conn-> query("UPDATE cliente SET id='$id' WHERE nome='$novoNome' , cpf='$novoEmail'");
      
            if($alt){
                echo "
                <script>
                </script>
                ";
            }else{
                echo "Aviso: Não foi atualizado!";
            }    
                     

            
            
           

            
        }


        // Verifica se o botão de deletar foi clicado
        if (isset($_POST['deletarId'])) {
            $id = $_POST['deletarId'];

            // Deleta o usuário do banco de dados
            $query = "DELETE FROM cliente WHERE id=$id";
            $resultado = mysqli_query($conn, $query);

        }

        // Consulta os dados do banco de dados
        $query = 'SELECT id, nome, cpf FROM cliente';
        $result = mysqli_query($conn, $query);

        // Verifica se há dados retornados
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table">';
            echo '<thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th></tr></thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['cpf'] . '</td>';
                echo '<td>';
                echo '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" data-id="' . $row['id'] . '" data-nome="' . $row['nome'] . '" data-email="' . $row['cpf'] . '">Editar</button>';
                echo '<button class="btn btn-danger" onclick="deletar(' . $row['id'] . ')">Deletar</button>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo 'Nenhum registro encontrado.';
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($conn);
        ?>

        <!-- Modal de Edição -->
        <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Dados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editarForm" method="POST" action="">
                            <input type="hidden" name="editarId" id="editarId">
                            <div class="form-group">
                                <label for="editarNome">Nome:</label>
                                <input type="text" class="form-control" id="editarNome" name="editarNome" required>
                            </div>
                            <div class="form-group">
                                <label for="editarCpf">Cpf:</label>
                                <input type="number" class="form-control" id="editarCpf" name="editarCpf" required>
                            </div>
                            <button type="submit" class="btn btn-primary" onclick="editar()">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        // Função para preencher o modal de edição com os dados do usuário
        $('#editarModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nome = button.data('nome');
            var cpf = button.data('cpf');

            var modal = $(this);
            modal.find('#editarId').val(id);
            modal.find('#editarNome').val(nome);
            modal.find('#editarCpf').val(cpf);
        });
        </script>
        <script>
            function editar(<?php$resultado?>) {
                if ($resultado) {
                   <?php echo '<div class="alert alert-success">Usuário deletado com sucesso.</div>'; ?>
                } else {
                    <?php echo '<div class="alert alert-danger">Erro ao deletar o usuário.</div>';?>
                }
            }
        </script>

        
        <script src='sweetalert2.min.js'></script>
    <link rel='stylesheet' href='sweetalert2.min.css'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
    // DELETAR
    function deletar(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'

        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
                if (result.isConfirmed) {
                // Cria um formulário dinamicamente
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '';

                // Cria um campo oculto para o ID do usuário
                var inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'deletarId';
                inputId.value = id;

                // Adiciona o campo oculto ao formulário
                form.appendChild(inputId);

                // Adiciona o formulário ao corpo do documento e o submete
                document.body.appendChild(form);
                form.submit();
            }
            }
        })
    }
    </script>


        
            
       
    </script>
</body>
</html>
 