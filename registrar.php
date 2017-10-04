<?php
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$c = false;
			$nome = $_POST['nome'];
			$snome = $_POST['snome'];
			$email = $_POST['email'];
			$cemail = $_POST['cemail'];
			$unome = $_POST['unome'];
			$passw = $_POST['senha'];
			$cpassw = $_POST['csenha'];
			$sexo = $_POST['sexo'];
			$data = $_POST['data'];
			
			$usuario = "root";
			$senha = "";
			$servidor = "localhost";
			$bddnome = "cadastros";
			header('Content-Type: text/html, charset-utf-8');
			$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
			
			if(!$conexao){
				echo "Sem conexao";
			}
			if($passw == $cpassw && $email == $cemail){
				$select = mysqli_query ($conexao,'SELECT * FROM cadastro');
			
		
			
				while($linha = mysqli_fetch_array($select)){
					if($linha["username"] == $unome){
						$c = true;
						break;
					}
				}
				if($c==false){
					$novoId = mysqli_num_rows($select);
					$novoId++;
					//$passw = hash("sha256",$passw);
					mysqli_query($conexao, "INSERT INTO cadastro(id,nome,sobrenome,username,senha,email,sexo) VALUES
					($novoId,'$nome','$snome','$unome','$passw','$email','$sexo')") or die ("Erro ao cadastrar");
					header ("Location: login.php");
				}
				else{
					echo "Usuario '". $unome ."' ja existe";
				}
			}
			else{
				echo "Confirmação de emil ou senha incorreta";
			}
			
		}
	?>