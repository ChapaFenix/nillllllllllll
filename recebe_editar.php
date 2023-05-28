
      <?php
        include './conexao.php';
        $nome = $_POST["nome"];
        $cpf = $_POST["cpf"];
        echo $id.$nome.$cpf;
        $alt = $mysqli-> query("UPDATE cliente SET id='$id' WHERE nome='$nome' , cpf='$cpf'");
      
        if($alt){
          echo "Sucesso: Atualizado corretamente!";
        }else{
          echo "Aviso: Não foi atualizado!";
        }    
              
    ?>  