<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Information Application</title>
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/bootstrap.min'; ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
  <div class="navbar navbar-dark bg-dark">
    <div class="container">
      <a href="<?php echo base_url() . 'index.php/user/create/' ?>" class="navbar-brand">Customer Information
        App</a>
    </div>
  </div>
  <div class="container" style="padding-top : 10px;">
    <h3>Admin Login</h3>

    <div class="row">

      <div class="col-md-6">
        <hr>
        <form method="POST" action="<?php echo base_url() . 'index.php/user/' ?>">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp"
              placeholder="Enter email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group mb-3">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="InputPassword" placeholder="Password" required>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      </form>
    </div>


</body>

</html>