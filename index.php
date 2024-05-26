<!DOCTYPE html>
<html>
<head>
    <title>Login/Sign Up</title>
    <style>
        /* Add your new CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-toggle {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .form-toggle span {
            padding: 10px 20px;
            cursor: pointer;
        }

        .form-toggle span.active {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        .form {
            display: none;
        }

        .form.active {
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-toggle">
                <span id="login-toggle" class="active">Login</span>
                <span id="signup-toggle">Sign Up</span>
            </div>
            <div id="login-form" class="form active">
                <h2>Login</h2>
                <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
            </div>
            <div id="signup-form" class="form">
                <h2>Sign Up</h2>
                <form action="signup.php" method="post">
                <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="text" name="campus" placeholder="Campus" required>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript code to handle form toggle
        const loginToggle = document.getElementById('login-toggle');
        const signupToggle = document.getElementById('signup-toggle');
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');

        loginToggle.addEventListener('click', () => {
            loginToggle.classList.add('active');
            signupToggle.classList.remove('active');
            loginForm.classList.add('active');
            signupForm.classList.remove('active');
        });

        signupToggle.addEventListener('click', () => {
            signupToggle.classList.add('active');
            loginToggle.classList.remove('active');
            signupForm.classList.add('active');
            loginForm.classList.remove('active');
        });
    </script>
</body>
</html>