<?php
include "./inc/class.inc.guests.php";
include "./inc/class.inc.validate.php";

header('Content-Type: application/json');

$executionTime = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 3);
$memoryUsage = memory_get_peak_usage(true) / 1024 / 1024;

header('X-Debug-Time: ' . $executionTime);
header('X-Debug-Memory: ' . $memoryUsage);

$data = json_decode(file_get_contents('php://input'), true);

$method = $_SERVER['REQUEST_METHOD'];

$first_name = $data['first_name'];
$last_name = $data['last_name'];
$email = $data['email'];
$phone = $data['phone'];
$country = $data['country'];
$id = $_GET['id'];
$bd_connect = new Guests();
$valid = new Validate();

$error = false;
$data_error;
if (!empty($first_name) && !$valid->validateName($first_name)) {
    $error = true;
    $data_error = ['error' => 'Неправильно введено имя'];
}

if (!empty($last_name) && !$valid->validateName($last_name)) {
    $error = true;
    $data_error =  ['error' => 'Неправильно введена фамилия'];
}

if (!empty($email) && !$valid->validateEmail($email)) {
    $error = true;
    $data_error = ['error' => 'Неправильно введен email'];
}

if (!empty($phone) && !$valid->validatePhone($phone)) {
    $error = true;
    $data_error = ['error' => 'Неправильно введен телефон'];
}

if (empty($country)) {
    $country = $valid->getCountryByPhone($phone);
}

switch ($method) {
    case 'GET':
        if (!empty($id)) {
            $guest = $bd_connect->getGuestById($id);
            echo json_encode($guest);
        } else {
            $guests = $bd_connect->getGuests();
            echo json_encode($guests);
        }
        break;
    case 'POST':
        if (!empty($phone) && !empty($email) && $error === false) {
            $new_guest = $bd_connect->addGuest($first_name, $last_name, $phone, $email, $country);
            echo json_encode($new_guest);
        } else {
            echo json_encode($data_error);
        }
        break;
    case 'PATCH':
        if ($error === false) {
            $update_guest = $bd_connect->updateGuest($first_name, $last_name, $phone, $email, $country, $id);
            echo json_encode($update_guest);
        } else {
            echo json_encode($data_error);
        }
        break;
    case 'DELETE':
        if (!empty($id)) {
            $delete_guest = $bd_connect->deleteGuest($id);
            
            echo json_encode($delete_guest);
        } else {
            echo json_encode(['error' => 'Ошибка при удалении пользователя, не указан ID']);
        }
        break;
    default:
        echo json_encode(['error' => 'Неподдерживаемый метод']);
}
