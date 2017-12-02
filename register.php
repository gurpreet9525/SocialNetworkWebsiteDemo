<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign up</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
     <div class="container">
         <div class="row clearfix">
             <div class="col-md-4 column">
             </div>
             <div class="col-md-4 column">
                 <br />
                 <blockquote>
                     <p>
                        You are a good boy.
                     </p> <small>Me</small>
                 </blockquote>
                 <h3>
                    Welcome to sign up
                 </h3>
                 <br />
                 <p>
                    If you want to sign up, you have to pay me $1000000000.
                 </p>
                 <br />
                 <form id="registerData" role="form" method="POST" action="addnewuser.php" onsubmit="if(document.getElementById('agree').checked) { return true; }
                    else { alert('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy');
                 	return false; }">
                     <div class="form-group">
                         <label for="email">Email address</label><input type="email" name="EmailAdd" class="form-control"
                                                                         required="true" placeholder="Email Address"/>
                     </div>
                     <div class="form-group">
                         <label>Username</label><input type="text" name="Username" class="form-control"
                                                                        required="true" placeholder="Username"/>
                     </div>
                     <div class="form-group">
                         <label for="Password">Password</label><input type="password" name="Password" class="form-control"
                                                                       required="true" placeholder="Password"/>
                     </div>
                     <div class="form-group">
                         <p class="help-block">
                             I have read and agree to the <a href="terms.html">Terms and Conditions</a>  and Privacy Policy
                         </p>
                     </div>
                     <div class="checkbox" >
                         <label><input type="checkbox" id="agree"/>Check me out</label>
                     </div>
                     <button type="submit" class="btn btn-default">Submit</button>
                     <button type="button" class="btn btn-primary btn-sm" onclick="location='login.html'">Sign in</button>
                 </form>
             </div>
             <div class="col-md-4 column">
             </div>
         </div>
     </div>
</body>
</html>


