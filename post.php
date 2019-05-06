<?php 
	if ($_POST) {		

		$name = $_POST['name'];
		$email = $_POST['email'];
		$telefone = $_POST['tel'];

		if ($name === "") {
			echo json_encode(["status" => false, "msg" => "Preencha o campo Name"]);exit;
		}

		if ($email === "") {
			echo json_encode(["status" => false, "msg" => "Preencha o campo Email"]);exit;
		}

		if ($telefone === "") {
			echo json_encode(["status" => false, "msg" => "Preencha o campo Telefone"]);exit;
		}

		$id = save($_POST);

		if ($id) {
			$result = find($id);
			echo json_encode(["status" => true, "msg" => "Cadastrado com Sucesso!! ID : {$id}", "contacts" => $result]);exit;
		}else{
			echo json_encode(["status" => false, "msg" => "Error no DB!!"]);exit;
		}
		
		
	}

	if ($_GET) {
		$data = listAll();
		echo json_encode($data);exit;
	}


	function conn(){
		$conn = new \PDO("mysql:host=localhost;dbname=ajax_jquery", "root", "");
		return $conn;
	}

	function save($data){
		$db = conn();
		$query = "INSERT INTO contacts (name, email, tel) VALUES (:name, :email, :tel)";
		$stmt = $db->prepare($query);
		$stmt->bindValue(':name', $data['name']);
		$stmt->bindValue(':email', $data['email']);
		$stmt->bindValue(':tel', $data['tel']);
		$stmt->execute();
		return $db->lastInsertId();
	}

	function listAll(){
		$db = conn();
		$query = "SELECT * FROM contacts";
		$stmt = $db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function find($id){
		$db = conn();
		$query = "SELECT * FROM contacts where id = :id";
		$stmt = $db->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}