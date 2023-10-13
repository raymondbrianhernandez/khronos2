<?php include('../private/shared/header.php'); ?>
        
<div id="frm">
    <br><br>    
    <form name="form" action="../private/authentication.php" onsubmit = "return validation()" method="POST">  
        <p>  
            <label>Username:</label>  
            <input type="text" id="user" name="user"/>  
        </p>  
        <p>  
            <label>Password:</label>  
            <input type="password" id="pass" name="pass"/>  
        </p>  
        <p>     
            <input type="submit" id="btn" value="Login"/>  
        </p>  
    </form>
    <p style="text-align:center">
        <b>Invalid username or password.</b>
    </p>  
</div>
        
<!-- ?php include('../private/shared/footer.php'); ?> -->