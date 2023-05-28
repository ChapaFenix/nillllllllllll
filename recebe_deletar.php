
<?php
include './conexao.php';


  $id = $_GET['id'];
  
  $consultar = "SELECT * FROM cliente WHERE id ='$id' ";
  $con = $mysqli ->query($consultar) or die($mysqli -> errno);
  while($dados = $con -> fetch_array()){ 
  $id = $dados['id'];
  $nome = $dados['nome'];
  $cpf = $dados['cpf'];
  
  if($id != undefinde){
    echo"delete?"; 
  }
  $alt = $mysqli-> query("DELETE from cliente  WHERE id=$id");
  
  echo "
  <script src='sweetalert2.min.js'></script>
<link rel='stylesheet' href='sweetalert2.min.css'>
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script> 
  Swal.fire(
    'Good job!',
    '$nome foi deletando!',
    'success'
  )
  ";
  
  }
  
  ?>