<!DOCTYPE html>
<html>

<head>
    <title>LOGIN</title>
</head>

<body>
    <h1>Create an account and use your username and password in the API request to access the API.</h1>
    <form action="../Controllers/AccountControllers/CreateController.php" method="post">
        <label for="username">Username</label><br>
        <input type="text" name="username" max-length = "255"></input><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" max-length = "255"></input><br><br>
        <input type="submit" value="Create ACCOUNT"></input>
    </form>
</body>

</html>