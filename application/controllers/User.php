<?php
class User extends CI_Controller
{
  public function User()
  {
    $this->load->model("UserModel");
    $data['users'] = $this->UserModel->getData();
    $this->load->view("Users/userList", $data);
  }
}
?>