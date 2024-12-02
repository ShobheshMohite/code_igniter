<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>User Account Details</h1>
  <table>
    <tr>
      <td>First Name</td>
      <td>Last Name</td>
    </tr>
    <?php foreach ($users as $user); ?>
    <tr>
      <td><?php echo $user['firstName']; ?></td>
      <td><?php echo $user['lastName']; ?></td>
    </tr>
  </table>
</body>

</html>