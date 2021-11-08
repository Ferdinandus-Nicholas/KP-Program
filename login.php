<?php
    include_once("connection.php");
    
    $user="";
    $password="";
    
    $info="";
    
    //Data User
    $arr1 = [];
    $sql = "select * from tabel_user";
    $result = $con->query($sql);
    if($result->num_rows > 0){
        while($row=$result->fetch_assoc()){
            $arr=array("username"=>trim($row['username']),
            "password"=>trim($row['password']),
            "fk_email"=>trim($row['fk_email']));  
          array_push($arr1,$arr); 
        }
    }else{
      $info = "";
    }
    $jum = count($arr1);
    
    //LOGIN
    if(isset($_POST['login_btn'])){
        $user=$_POST["username"];
        $password=$_POST["password"];
    
        
            for($i=0;$i<$jum;$i++)
            {        
                $pass_encript = $arr1[$i]['password'];
                if($user == $arr1[$i]['username'])
                {
                    if(password_verify($password,$pass_encript))
                    {
                        header("Location: index.php?username=$user");
                    }
                }
            }  
            $message = "Username / Password Salah";
            echo "<script type='text/javascript'>alert('$message');</script>"; 
        
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Component Warehouse</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">

        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="POST">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" placeholder="username" name="username"/>
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <input type="submit" class="btn btn-info " value="Login Account" name="login_btn">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Component Warehouse 2021</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
