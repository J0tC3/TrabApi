<!doctype html>
<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

    	<!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
  	</head>
  	<body>
    	<div class="container">
    		<div class="row">
    			<div class="col-md-4">&nbsp;</div>
    			<div class="col-md-4">
		    		<div class="card">
		    			<div class="card-header">Login</div>
		    			<div class="card-body">
		    				<form method="post" id="form" action = "./addartigo.php">
		    					<div class="mb-3">
			    					<label>Username</label>
			    					<input type="username" id="username" name="username" class="form-control" />
			    				</div>
			    				<div class="mb-3">
			    					<label>Password</label>
			    					<input type="passcode" id="passcode" name="passcode" class="form-control" />
			    				</div>
			    				<div class="text-center">
			    					<input type="submit" id="btnSubmit" name="login" class="btn btn-primary" value="Login" />
			    				</div>
		    				</form>
		    			</div>
		    		</div>
		    	</div>
	    	</div>
    	</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<script src="jquery-3.5.1.min.js"></script>
		<script>
			const btnSubmit = document.getElementById('btnSubmit');

			btnSubmit.addEventListener('click', loginApi);
			
			//envia as credenciais e recebe um token caso elas existam no banco
			function loginApi() {
				const username = $("#username").val();
				const passcode = $("#passcode").val();

				$.ajax({
					url: "http://localhost/TrabApi/backend/login",
					method: 'POST',
					data: {'username' : username, 'passcode': passcode},
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