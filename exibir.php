<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script src='sweetalert2.min.js'></script>
        <link rel='stylesheet' href='sweetalert2.min.css'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css'rel='stylesheet'><!--Bootstrap-->
        <link href='https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css' rel='stylesheet'><!--Datatables-->
        <link rel="stylesheet" href="css/exibir.css"><!--Site-->
    </head>
    <body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">
      <?php include './includes/navbar_modal.php'?>
      <div class="container">
        <h1>Editar e Deletar Dados</h1>
        <?php
          include './conexao.php';
        // Verifica se houve algum erro na conexão
        if (mysqli_connect_errno()) {
            echo 'Falha ao conectar com o banco de dados: ' . mysqli_connect_error();
            exit();
        }

        // Função para escapar caracteres especiais para uso em consultas SQL
        function escape($str) {
            global $mysqli;
            return mysqli_real_escape_string($mysqli, $str);
        }

        // Verifica se o formulário de edição foi enviado
        if (isset($_POST['editarId'])) {
            $id = $_POST['editarId'];
            $novoNome = escape($_POST['editarNome']);
            $novoEmail = escape($_POST['editarCpf']);
    
           // Verifica se o formulário de edição foi enviado
       if (isset($_POST['editarId'])) {
        $id = $_POST['editarId'];
        $novoNome = escape($_POST['editarNome']);
        $novoEmail = escape($_POST['editarCpf']);

       
        
        echo '<div class="alert alert-success" id="alerta">Dados atualizados com sucesso.</div>';
        echo '<script>setTimeout(function(){document.getElementById("alerta").style.display="none";}, 3000);</script>';
      
        } else {echo "
                <script>
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!',
                  footer: '<a >Why do I have this issue?</a>'
                })
                </script>";
            echo '<div class="alert alert-danger">Erro ao atualizar os dados.</div>';
        }
    }

        

        // Verifica se o botão de deletar foi clicado
        if (isset($_POST['deletarId'])) {
            $id = $_POST['deletarId'];

            // Deleta o usuário do banco de dados
            $query = "DELETE FROM cliente WHERE id=$id";
            $resultado = mysqli_query($mysqli, $query);

        }

        // Consulta os dados do banco de dados
        $query = 'SELECT id, nome, cpf FROM cliente';
        $result = mysqli_query($mysqli, $query);

        // Verifica se há dados retornados
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table' id='example'->";
            echo '<thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Editar</th><th>Deletar</th></tr></thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['cpf'] . '</td>';
                echo '<td>';
                echo '<button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" data-id="' . $row['id'] . '" data-nome="' . $row['nome'] . '" data-email="' . $row['cpf'] . '">Editar</button>';
                echo '</td>';
                echo '<td>';
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
        mysqli_close($mysqli);
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
                        <form id="editarForm" method="POST" action="recebe_editar.php">
                            <input type="hidden" name="editarId" id="editarId">
                            <div class="form-group">
                                <label for="editarNome">Nome:</label>
                                <input type="text" class="form-control" id="editarNome" name="editarNome" required>
                            </div>
                            <div class="form-group">
                                <label for="editarCpf">CPF:</label>
                                <input type="text" class="form-control" id="editarCpf" name="editarCpf" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <script>
            // Função para preencher o modal de edição com os dados corretos
            $('#editarModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var nome = button.data('nome');
                var cpf = button.data('cpf');

                $('#editarId').val(id);
                $('#editarNome').val(nome);
                $('#editarCpf').val(cpf);
            });
        </script>
    <!-- Script JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


        
        <script src='sweetalert2.min.js'></script>
    <link rel='stylesheet' href='sweetalert2.min.css'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
      //Editar
      function ed(id) {
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
    <script src='js/deletar.js'></script>
    <!--Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <!--Termino do Bootstrap-->
               
    <!--Datatables-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#example').DataTable();
       });     
    </script>
    <!--Termino Datatables-->
  </body>
</html>