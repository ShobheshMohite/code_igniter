<?php
class UserModel extends CI_Model
{
  public function getData()
  {
    $this->load->database();
    $q = $this->db->query("select * from users");
    $data = $q->result();
    return $data;
  }
}
?>