<?php include('views/header/header.php'); ?>

<div class="login_wrapper container">
    <?php
    if ($login->errors) {
        foreach ($login->errors as $error) {
            ?>              
            <div class="offset2 span6 alert alert-block alert-error fade-in">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <p><?php echo $error; ?></p>            
            </div>       
            <?php
        }
    }

    if ($login->messages) {
        foreach ($login->messages as $message) {
            ?>
            <div class="offset2 span6 alert alert-block alert-success fade-in">
                <a class="close" data-dismiss="alert" href="#">×</a>
                <?php echo $message; ?>
            </div>              
            <?php
        }
    }
    ?>    

    <?php if (!$login->registration_successful) { ?>

        <form class="form-signin" method="post" action="index.php?register" name="registerform" id="registerform">
            <div class="login" style="height:300px;">
                <h2 class="form-signin-heading">Please register</h2>  
                <input id="login_input_username" type="text" name="user_name" placeholder="Username">                        
                <input id="login_input_email" type="email" name="user_email" placeholder="Email" />
                <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" autocomplete="off" placeholder="Password"/>
                <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" autocomplete="off" placeholder="Repead password" />
                <div class="login_submit_register">
                    <button class="btn btn-info" name="register" type="submit" value="Register">Register</button>                        
                </div>        
            </div>                                
            <a class="login_link" href="index.php">Back to Login Page</a>            
        </form>

    <?php } ?>

</div>

<?php include('views/footer/footer.php'); ?>