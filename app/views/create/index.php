<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Creat an account!</h1>
                                         
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['success']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-sm-auto">
    <form action="/create/verify" method="post" >
    <fieldset>
      <div class="form-group">
        <label for="username">Username</label>
        <input required type="text" class="form-control" name="username">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input required type="password" class="form-control" name="password">
      </div>
        <div class="form-group">
            <label for="repassword">Re-Password</label>
            <input required type="password" class="form-control" name="repassword">
        </div>
        <br>
        <div><a href="/">Go to Login Page</a></div>
            <br>
        <button type="submit" class="btn btn-primary">Create Account</button>
    </fieldset>
    </form> 
  </div>
</div>
</main>
    <?php require_once 'app/views/templates/footer.php' ?>
