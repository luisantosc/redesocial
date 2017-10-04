<?php
	session_start();
		$usuario = "root";
			$senha = "";
			$servidor = "localhost";
			$bddnome = "cadastros";
			header('Content-Type: text/html, charset-utf-8');
			$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
			
			if(!$conexao){
				echo "Sem conexao";
			}
			
	$id = $_GET['id'];
	$modificar = mysqli_query ($conexao,"UPDATE amizade
			SET status = 'amigo'
			WHERE convite = $id");
	header("Location: home.php");

?>