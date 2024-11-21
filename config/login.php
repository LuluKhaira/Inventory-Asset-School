<?php
include 'link.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Arial', sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-body {
            padding: 2rem;
        }
        .card-title {
            color: #4a4a4a;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
        .form-group label {
            color: #6c757d;
            font-weight: 500;
        }
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #4a4a4a;
            box-shadow: 0 0 0 0.2rem rgba(74, 74, 74, 0.25);
        }
        .btn-primary {
            background-color: #4a4a4a;
            border-color: #4a4a4a;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #333333;
            border-color: #333333;
        }
        .toggle-form {
            color: #4a4a4a;
            text-decoration: underline;
            cursor: pointer;
        }
        .toggle-form:hover {
            color: #333333;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Sign In</h3>
                        <form method="post" action="../config/login_aksi.php">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required
                                    oninvalid="this.setCustomValidity('Please enter your email')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i> Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                                    required oninvalid="this.setCustomValidity('Please enter your password')"
                                    oninput="this.setCustomValidity('')">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="signIn">Sign In</button>
                            <p class="text-center mt-3">
                                Don't have an account? <a href="register.php">Click here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>