<?php

?>

<head>
    <title>Register & Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
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

<body>
    <div class="container mt-4 ">
        <div class="row d-flex justify-content-center ">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div id="signupForm">

                            <h4 class="card-title text-center">Sign Up</h4>
                            <form action="../config/register_aksi.php" method="POST">
                                <div class="form-group">
                                    <label for="fName"><i class="fas fa-user"></i> First Name</label>
                                    <input type="text" class="form-control" id="fName" name="fName"
                                        placeholder="First Name" required
                                        oninvalid="this.setCustomValidity('Isi First Name nya')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="form-group">
                                    <label for="lName"><i class="fas fa-user"></i> Last Name</label>
                                    <input type="text" class="form-control" id="lName" name="lName"
                                        placeholder="Last Name" required
                                        oninvalid="this.setCustomValidity('Isi Last Name nya')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="form-group">
                                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                        required oninvalid="this.setCustomValidity('Isi Email nya')"
                                        oninput="this.setCustomValidity('')"> <!-- Input untuk Email -->
                                </div>
                                <div class="form-group"> <!-- Grup input untuk Password -->
                                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required
                                        oninvalid="this.setCustomValidity('Isi Password nya')"
                                        oninput="this.setCustomValidity('')"> <!-- Input untuk Password -->
                                </div>
                                <div class="form-group"> <!-- Grup input untuk Level -->
                                    <label for="level"><i class="fas fa-user"></i> Level</label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select> <!-- Pilihan level User atau Admin -->
                                </div>

                                <button type="submit" class="btn btn-primary btn-block" name="signUp">Sign Up</button>
                                <!-- Tombol untuk mengirim formulir Sign Up -->
                                <p class="text-center mt-3">
                                    Sudah Punya Akun? <a href="login.php">Klik disini</a></p>
                            </form>
                        </div>