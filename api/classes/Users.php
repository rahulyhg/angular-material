<?php
	class Users{

		private $db;
		private $response = ['success' => [], 'error' => []];

		function __construct($db){
			$this->db = $db;
		}

		public function fetchAll(){

			$users = [];
			$users = $this->db->get('users');
			return json_encode($users);

		}

		public function insertUser(){

			$data = (array)(json_decode(file_get_contents("php://input")));
			$id = $this->db->insert('users', $data);

			if (!empty($id)) {
				$this->response['success'] = ['New user added successfuly!'];
				return json_encode($this->response);
			} else {
				$this->response['error'] = ['Error! Please try again.'];
				return json_encode($this->response);
			}

		}

		public function getUser($id){

			$this->db->where('id', $id);
			$user = $this->db->getOne('users');

			if(!empty($user)){
				$this->response['success'] = [$user];
				return json_encode($this->response);
			} else {
				$this->response['error'] = ['User not exist!'];
				return json_encode($this->response);
			}
		}

		public function removeUser($id){
			$this->db->where('id', $id);
			if ($this->db->delete('users')) {
				$this->response['success'] = ['User successfuly deleted!'];
				return json_encode($this->response);
			} else {
				$this->response['error'] = ['Error! Please try again.'];
				return json_encode($this->response);
			}
		}
	}
?>