<?php include('views/header/header.php'); ?>

<div class="login_wrapper container">    
    <?php
    if ($login->errors) {
        foreach ($login->errors as $error) {
            ?>              
            <div class="offset2 span8 alert alert-block alert-error fade-in">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <p><?php echo $error; ?></p>            
            </div>            
            <?php
        }
    }

    if ($login->messages) {
        foreach ($login->messages as $message) {
            ?>
            <div class="offset2 span8 alert alert-block alert-success fade-in">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <p><?php echo $message; ?></p>
            </div>              
            <?php
        }
    }
    ?>  

    <!--form-->
    <div class="container">
        <form id="effect" class="form-signin" method="post" action="index.php" name="loginform" id="loginform">
            <h2 class="form-signin-heading">Please sign in</h2>                   
            <input type="text" id="login_input_username" class="input-block-level" placeholder="User Name" name="user_name" value="<?php echo $login->view_user_name; ?>">
            <input type="password" class="input-block-level" type="password" name="user_password" autocomplete="off" placeholder="Password">
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
            </label>
            <button id="button" class="btn btn-info" name="login"type="submit">Sign in</button>
            <a class="login_link" href="index.php?register">Create new Account</a>
        </form>
    </div>
</div>

<?php include('views/footer/footer.php'); ?>