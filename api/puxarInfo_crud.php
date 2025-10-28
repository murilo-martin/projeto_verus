<?php

    include "../includes/mysqlconecta.php";

    $query = mysqli_query($conexao,"SELECT  `cnpj`, `nome`, `setor`, `email`, `senha`, `ativo`,`id` FROM `empresas`");

    while ($emp = mysqli_fetch_array($query)) {
        
        $disabled = $emp[5] == 0 ? "disabled": ""; 
        $ativo = $emp[5] == '1' ?"Ativo":"Desativado";

        echo "<tr>";
        echo "<td>{$emp[0]}</td>";
        echo "<td>{$emp[1]}</td>";
        echo "<td>{$emp[2]}</td>";
        echo "<td>{$emp[3]}</td>";
        echo "<td>{$emp[4]}</td>";
        echo "<td>{$ativo}</td>";
        echo "<td class='d-flex justify-content-evenly g-2'>
            <button type='button' class='btn btn-danger fw-bold' onclick='showDeleteModal($emp[6])' title='Deletar' $disabled>
                <i class='bi bi-trash3-fill'></i>
            </button>
            <button type='button' class='btn btn-primary fw-bold' onclick='showEditModal($emp[6])' title='Editar'>
                <i class='bi bi-pencil-fill'></i>
            </button>
        </td>";
        echo "</tr>";

    }

?>