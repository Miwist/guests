<?php

class Guests
{
    private $db = 'db';
    private $user = 'user';
    private $password = 'pass';
    private $host = 'host';
    private $conn;

    public function __construct()
    {
        $this->conn =  pg_connect("host=$this->host dbname=$this->db user=$this->user password=$this->password");
    }

    public function getGuests()
    {
        $result =  pg_query($this->conn, "SELECT * FROM guests LIMIT 200");
        $guests = pg_fetch_all($result);

        return $guests;
    }

    public function getGuestById($id)
    {
        $result =  pg_query($this->conn, "SELECT * FROM guests WHERE id='$id'");

        if (pg_num_rows($result) == 0) {
            $guest = ['error' => "Пользователь с данным ID не найден"];
        } else {
            $guest = pg_fetch_all($result);
        }

        return $guest;
    }

    public function addGuest($first_name, $last_name, $phone, $email, $country)
    {
        $find_guest_by_email = pg_query($this->conn, "SELECT * FROM guests WHERE email='$email'");
        $find_guest_by_email = pg_fetch_all($find_guest_by_email);
        if (empty($find_guest_by_email)) {
            $find_guest_by_phone = pg_query($this->conn, "SELECT * FROM guests WHERE phone='$phone'");
            $find_guest_by_phone = pg_fetch_all($find_guest_by_phone);

            if (empty($find_guest_by_phone)) {
                $result = pg_query($this->conn, "INSERT INTO guests (first_name, last_name, phone, email, country) VALUES ('$first_name', '$last_name', '$phone', '$email', '$country')");

                if (!empty($result)) {
                    $data = ['status' => 'Гость успешно создан'];
                } else {
                    $data = ['error' => 'Ошибка при создании гостя'];
                }
            } else {
                $data = ['error' => 'Гость с таким телефоном уже существует'];
            }
        } else {
            $data = ['error' => 'Гость с такой почтой уже существует'];
        }
        return $data;
    }

    public function updateGuest($first_name, $last_name, $phone, $email, $country, $id)
    {
        $result = pg_query($this->conn, "UPDATE guests SET first_name = '$first_name', last_name = '$last_name', phone = '$phone', email = '$email', country = '$country' WHERE id='$id'");

        if (!empty($result)) {
            $data = ['status' => 'Гость успешно обновлен'];
        } else {
            $data = ['error' => 'Ошибка при обновлении гостя'];
        }
        return $data;
    }

    public function deleteGuest($id)
    {
        $result = pg_query($this->conn, "DELETE FROM guests WHERE id ='$id'");

        if (!empty($result)) {
            $data = ['status' => 'Гость успешно удален'];
        } else {
            $data = ['error' => 'Ошибка при удалении гостя'];
        }
        return $data;
    }

    public function __destruct()
    {
        pg_close($this->conn);
    }
}
