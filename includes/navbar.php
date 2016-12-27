<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if(!AuthManager::isAuthenticated()){ ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } else { ?>
            <li><a href="userlist.php">User list</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php } ?>
    </ul>   
</nav>