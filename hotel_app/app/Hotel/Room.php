<?php

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;



class Room extends BaseService
{

    public function get($roomId)
    {
        $parameters = [
            ':room_id' => $roomId,
        ];
        return $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
    }

    public function getCountGuests()
    {
        // Get count of guests
        $rows = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room');
        $count_of_guests = [];
        foreach ($rows as $row) {
            $count_of_guests[] = $row['count_of_guests'];
        }
        return $count_of_guests;
    }


    public function getCities()
    {
        // Get all cities 
        $rows = $this->fetchAll('SELECT DISTINCT city FROM room');
        $cities = [];
        foreach ($rows as $row) {
            $cities[] = $row['city'];
        } 
        return $cities;
    }

    public function search($checkInDate, $checkOutDate, $city, $price1, $price2, $count_of_guests='',  $typeId = '')
    {
        // Setup parameters
        $parameters = [
            ':check_in_date' => $checkInDate->format(DateTime::ATOM),
            ':check_out_date' => $checkOutDate->format(DateTime::ATOM),
            ':city' => $city,
            ':price1' => $price1,
            ':price2' => $price2,
        ];
        
        if (!empty($typeId)) {
            $parameters[':type_id'] = $typeId;
        }
        if (!empty($count_of_guests)) {
            $parameters[':count_of_guests'] = $count_of_guests;
        }

        // Build query
        $sql = 'SELECT room.*, room_type.title as room_type
        FROM room 
        INNER JOIN room_type ON room.type_id = room_type.type_id
        WHERE price BETWEEN :price1 AND :price2 AND ';

        if (!empty($typeId)) {
            $sql .= ' room.type_id = :type_id AND ';
        }

        if (!empty($count_of_guests)) {
            $sql .= 'count_of_guests = :count_of_guests AND';
        }
        

        $sql .= ' city = :city AND room_id NOT IN (
            SELECT room_id
            FROM booking
            WHERE check_in_date <= :check_out_date AND check_out_date >= :check_in_date
        )';
        
        // Get results
        return $this->fetchAll($sql, $parameters);

    }

    


}