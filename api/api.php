<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$host = '127.0.0.1';
$db   = 'myintern_db';
$user = 'root'; 
$pass = '';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "DB Connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM companies ORDER BY choice_number ASC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} 
elseif ($method === 'POST') {
    $stmt = $pdo->query("SELECT MAX(choice_number) FROM companies");
    $nextNumber = ($stmt->fetchColumn() ?: 0) + 1;
    $approval = $data['supervisor_approval'] ?? 'Pending';

    $stmt = $pdo->prepare("INSERT INTO companies (choice_number, company_name, company_nature, company_address, core_business, supervisor_approval) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nextNumber, $data['company_name'], $data['company_nature'], $data['company_address'], $data['core_business'], $approval]);
    echo json_encode(["status" => "success", "message" => "New company choice added successfully!"]);
} 
elseif ($method === 'PUT') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("UPDATE companies SET company_name = ?, company_nature = ?, company_address = ?, core_business = ?, supervisor_approval = ? WHERE id = ?");
    $stmt->execute([$data['company_name'], $data['company_nature'], $data['company_address'], $data['core_business'], $data['supervisor_approval'], $id]);
    echo json_encode(["status" => "success", "message" => "Company choice updated successfully!"]);
} 
elseif ($method === 'DELETE') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM companies WHERE id = ?");
    $stmt->execute([$id]);
    
    $pdo->query("SET @count = 0");
    $pdo->query("UPDATE companies SET choice_number = @count:= @count + 1 ORDER BY choice_number ASC");

    echo json_encode(["status" => "success", "message" => "Company choice deleted successfully!"]);
}
?>
