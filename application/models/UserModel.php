<?php
class UserModel extends CI_Model
{
  public function getData()
  {
    return [
      [
        'firstName' => 'Shobhesh',
        'lastName' => 'Mohite',
      ],
      [
        'firstName' => 'Anuj',
        'lastName' => 'Sharma',
      ],
    ];
  }
}
?>