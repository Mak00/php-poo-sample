<?php include('views/header/header.php'); ?>  

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-small btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#">Batman</a>
            <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                    Hey, <?php echo $_SESSION['user_name']; ?>
                    <a class="navbar-link" href="index.php?logout">Logout</a>
                </p>
                <ul class="nav">                            
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Account</a></li>                             
                    <li><a href="#">Blog</a></li>                             
                </ul>                       
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>   

<div class="container">      
    <!-- your home page -->
</div>

<?php include('views/footer/footer.php'); ?>
