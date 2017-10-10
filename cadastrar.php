<!doctype html>  
<html>
	<head>
		<meta charset="utf-8"/>	
		<link rel="stylesheet" href="./css/style.css"/>
		<link href="https://fonts.googleapis.com/css?family=Quicksand|Raleway" rel="stylesheet">
		<script src="./js/jquery.min.js"></script>
		
	</head>
	<body>
		<h1 id="Cadastrar"> Cadastrar </h1>
		<a class="seta" href="index.php"><img class="img" id="Voltar" src="./img/seta_php.png" /> </a>
		<div class="botao">
			<a class="entrar-cadastrar" href="cadastrar.php"> Cadastrar </a>
			<a class="entrar-cadastrar" href="login.php"> Entrar </a>
			
			
		</div>

		<div class="cadastro">
			<form method="post" action="registrar.php">
				<input name="nome" placeholder="Nome" type="text"/><br/>
				<input name="snome" placeholder="Sobrenome" type="text" /><br/>
				<input name="email" placeholder="Email" type="email"/><br/>
				<input name="cemail" placeholder="Confimação de email" type="email"/><br/>
				<input name="unome" placeholder="Username" type="text" maxlength="10"/><br/>
				<input name="senha" placeholder="Senha" type="password" maxlength="20"/><br/>
				<input name="csenha" placeholder="Confirmação de senha" type="password" maxlength="20"/><br/>
				Masculino<input type="checkbox" name="sexo" value="M"><br/>
				Feminino<input type="checkbox" name="sexo" value="F"> <br/>
				Outro<br/><input type="checkbox" name="sexo" value="O"> <br/>
				<input name="data" placeholder="Data de nascimento" type="date"/><br/>
				<input class="sub" type="submit" value="Cadastrar"/><br/>
				

			</form>
		</div>
		

	</body>
</html>