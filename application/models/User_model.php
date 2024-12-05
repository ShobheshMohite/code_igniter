<?php
class User_model extends CI_Model
{
  function create($formArray)
  {
    $this->db->insert('users', $formArray); // INSERT INTO users(name,email) values(?,?);
  }

  public function all()
  {
      $this->db->select('users.*, states.name as state_name, cities.name as city_name');
      $this->db->from('users');
      $this->db->join('states', 'users.state_id = states.id', 'left');
      $this->db->join('cities', 'users.city_id = cities.id', 'left');
      $query = $this->db->get();
      return $query->result_array();
  }
  

  function getUser($userId)
  {
    $this->db->where('user_id', $userId);
    return $user = $this->db->get('users')->row_array();
  }

  function updateUser($userId, $formArray)
  {
    $this->db->where('user_id', $userId);
    $this->db->update('users', $formArray);
  }

  function deleteUser($userId)
  {
    $this->db->where('user_id', $userId);
    $this->db->delete('users');
  }

  public function getStates()
  {
    $query = $this->db->get('states'); // Fetch all states
    return $query->result_array();
  }

  public function getCitiesByState($stateId)
  {
    $this->db->where('state_id', $stateId); // Fetch cities for the selected state
    $query = $this->db->get('cities');
    return $query->result_array();
  }

  public function getCities()
  {
    $query = $this->db->get('cities');
    return $query->result_array();
  }
}
?>