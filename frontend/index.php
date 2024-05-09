<?php

?>

<!doctype html>
<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

    	<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
  	</head>
  	<body>
		<!--
    	<div class="container">
    		<div class="row">
    			<div class="col-md-4">&nbsp;</div>
    			<div class="col-md-4">
		    		<div class="card">
		    			<div class="card-header">Login</div>
		    			<div class="card-body">
		    				<form method="post" id="form">
		    					<div class="mb-3">
			    					<label>Username</label>
			    					<input type="username" name="username" class="form-control" />
			    				</div>
			    				<div class="mb-3">
			    					<label>Password</label>
			    					<input type="password" name="password" class="form-control" />
			    				</div>
			    				<div class="text-center">
			    					<input type="submit" name="login" class="btn btn-primary" value="Login" />
			    				</div>
		    				</form>
		    			</div>
		    		</div>
		    	</div>
	    	</div>
    	</div>
		-->

		<script src="jquery-3.5.1.min.js"></script>
		<script>
			var username = 'breno';
			var password = '2902';
			
			//envia credenciais e recebe um token caso eles existam no banco
			function loginApi() {
				$.ajax({
					url: "http://localhost/TrabApi/backend/login",
					method: 'POST',
					data: {'username' : username, 'password': password},
					})
					.done(function( data ) {
						localStorage.setItem('user_token_jwt', data);
				});
			}


			//exemplo de como o token pode ser usado pra verificar se o usuario que esta acessando 
			//tais endpoints tem acesso
			function getUsers(){
				$.ajax({
					url: "http://localhost/trabapi/backend/getAll",
					method: 'GET',
					//cabecalho com o token
					headers: {
						'Authorization': 'Bearer ' + localStorage.getItem('user_token_jwt')
					},
					})
					.done(function( data ) {
						console.log(data);
				});
			}
		</script>
  	</body>
</html>