<?php
//require_once 'model/config.php';
require_once 'Landings.php';
require_once 'DB.php';

if (isset($_GET['buscar'])) {
    $regiao = $_GET['buscar'];
    $landing = new Landings();
    $unidades = $landing->unidade($regiao);
	
    foreach($unidades as $key => $value){
        echo "<option value='" . $value->id_unidade . "' >" . $value->unidade . "</option>";
    }
}
?>