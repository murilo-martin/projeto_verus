<?php

    include "../includes/mysqlconecta.php";

    $id_emp = $_POST['id'];

    $emp = mysqli_fetch_array(mysqli_query($conexao, "SELECT `cnpj`, `nome`, `setor`, `email`, `senha`, `ativo` FROM `empresas` WHERE id = $id_emp"));

    $disabled = $emp[5] == '1' ?"disabled":"";
    $ativo = $emp[5] == '1' ?"Ativo":"Desativado";
    
    echo "<div class='row'>
        <div class='col'>
            <small class='form-text align-start mb-1'>
                CNPJ:
            </small>
        </div>
        <div class='col'>
        <small class='form-text align-start mb-1'>
                Nome da empresa:
            </small>
        </div>
    </div>

    <div class='row'>
        <div class='col'>
            <input class='form-control' type='text' id='cnpj_emp' value='$emp[0]' required>
        </div>
        <div class='col'>
            <input class='form-control' type='text' id='nome_emp' value='$emp[1]' required>
        </div>
        
        </div>
    </div>
    <div class='row'>
        <div class='col'>
            <small class='form-text align-start mb-1'>
                Setor:
            </small>
        </div>
        <div class='col'>
        <small class='form-text align-start mb-1'>
                Email:
            </small>
        </div>
    </div>
        
        <div class='row'>
        <div class='col'>
            <input class='form-control' type='text' id='setor_emp' value='$emp[2]' required>
        </div>
        <div class='col'>
            <input class='form-control' type='text' id='email_emp' value='$emp[3]' required>
        </div>
        
    </div>
    <div class='row'>
        <div class='col'>
            <small class='form-text align-start mb-1'>
                Senha:
            </small>
        </div>
        <div class='col'>
        <small class='form-text align-start mb-1'>
                Ativo:
            </small>
        </div>
    </div>
        
        <div class='row'>
        <div class='col'>
            <input class='form-control' type='text' id='senha_emp' value='$emp[4]' required>
        </div>
        <div class='col'>
            <select class='form-select' aria-label='Default select example' id='ativo_emp' $disabled>
            <option selected value='$emp[5]'>$ativo</option>
            <option value='1'>Ativo</option>
</select>
        </div>
        
    </div>
    </div>"
   

?>