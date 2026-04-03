<?php
session_start();
require_once 'includes/config.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    $editId = $_POST['editId'] ?? '';
    $serviceNo = $_POST['serviceNo'] ?? '';
    $fullName = $_POST['fullName'] ?? '';
    $rank = $_POST['rank'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $commissionDate = $_POST['commissionDate'] ?? '';
    $status = $_POST['status'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $education = $_POST['education'] ?? '';
    $training = $_POST['training'] ?? '';
    
    if ($editId) {
        // Update existing personnel
        $sql = "UPDATE personnel SET 
                    personnel_number = :serviceNo,
                    full_name_en = :fullName,
                    rank = :rank,
                    unit = :branch,
                    joint_date = :commissionDate,
                    current_status = :status,
                    email = :email,
                    contact = :contact,
                    higher_education = :education,
                    training = :training
                WHERE personnel_number = :editId";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':serviceNo' => $serviceNo,
            ':fullName' => $fullName,
            ':rank' => $rank,
            ':branch' => $branch,
            ':commissionDate' => $commissionDate,
            ':status' => $status,
            ':email' => $email,
            ':contact' => $contact,
            ':education' => $education,
            ':training' => $training,
            ':editId' => $editId
        ]);
        
        $response['success'] = true;
        $response['message'] = 'Personnel updated successfully';
    } else {
        // Check if personnel number already exists
        $check = $pdo->prepare("SELECT COUNT(*) FROM personnel WHERE personnel_number = ?");
        $check->execute([$serviceNo]);
        if ($check->fetchColumn() > 0) {
            $response['message'] = 'Personnel number already exists';
            echo json_encode($response);
            exit;
        }
        
        // Insert new personnel
        $sql = "INSERT INTO personnel (
                    personnel_number, full_name_en, rank, unit, 
                    joint_date, current_status, email, contact, higher_education, training
                ) VALUES (
                    :serviceNo, :fullName, :rank, :branch,
                    :commissionDate, :status, :email, :contact, :education, :training
                )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':serviceNo' => $serviceNo,
            ':fullName' => $fullName,
            ':rank' => $rank,
            ':branch' => $branch,
            ':commissionDate' => $commissionDate,
            ':status' => $status,
            ':email' => $email,
            ':contact' => $contact,
            ':education' => $education,
            ':training' => $training
        ]);
        
        $response['success'] = true;
        $response['message'] = 'Personnel added successfully';
    }
} catch(PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>