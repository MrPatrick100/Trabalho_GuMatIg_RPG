<?php 
    require_once __DIR__ . '/../includes/auth.php';
    require_once __DIR__ . '/../repository/PersonagemRepository.php';
    require_once __DIR__ . '/../includes/header.php';

    $repo = new PersonagemRepository();
?>
     
    <div class="page-header">
        <h2>Editar Inventário</h2>
        <div class="form-card">
        <form action="personagem_create.php" method="post"></form>
        <div class="form-group">
       
        <input type="text" name="textoinv" id="tinv1" placeholder="Ex: Poção de Vida">
        <input type="text" name="textoinv" id="tinv2" placeholder="Ex: Armadura de Couro">
        <input type="text" name="textoinv" id="tinv3" placeholder="Ex: Espada Longa">
    </div>
     </div>

     <form action="personagem_create.php" method="post">
     <button type="submit" class="btn btn-primary">Salvar inventário</button>
     </form>

        <a href="personagem_create.php" class="btn btn-secondary">Voltar</a>



   
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

