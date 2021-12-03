<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;

class User extends BaseService
{
    const TOKEN_KEY = 'asfdhkgjlr;ofijhgbfdklffsadf';

    private static $currentUserId;

    public function getByUserId($userId)
    {
        $parameters = [
            ':user_id' => $userId,
        ];
        return $this->fetch('SELECT * FROM user WHERE user_id = :user_id', $parameters);
    }
    public function getByEmail($email)
    {
        $parameters = [
            ':email' => $email,
        ];
        return $this->fetch('SELECT * FROM user WHERE email = :email', $parameters);
    }

    public function getList()
    {
        return $this->fetchAll('SELECT * FROM user');
    }



    public function insert($name, $email, $password)
    {
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        // Prepare parameters 
        $parameters = [
            ':name' => $name,
            ':email' => $email,
            ':password' => $passwordHash,
        ];

        // Prepare statement
        $rows = $this->execute(
        'INSERT INTO user (name, email, password)
         VALUES (:name, :email, :password)', $parameters);

        return $rows == 1;
    }

    public function verify($email, $password)
    {
        // Step 1 - retrieve user
        $user = $this->getByEmail($email);

        // Step 2 - Verify user password
        return password_verify($password, $user['password']);
    }
    public function getUserToken($userId, $crsf = '')
    {

        // Create token payload
        $payload = [
            'user_id' => $userId,
            'crsf' => $crsf ?: md5(time()),
        ];
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

        return sprintf('%s.%s', $payloadEncoded, $signature);
    }
    public static function getTokenPayload($token)
    {
        // Get payload and signature
        [$payloadEncoded] = explode('.', $token);

        // Get payload 
        return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token)
    {
        // Get payload
        $payload = $this->getTokenPayload($token);
        $userId = $payload['user_id'];
        $crsf = $payload['crsf'];

        // Generate signature and verify
        return $this->getUserToken($userId, $crsf) == $token;

    }

    public static function verifyCrsf($crsf) 
    {
        return self::getCrsf() == $crsf;
    }

    public static function getCrsf() 
    {
        // Get token payload
        $token = $_COOKIE['user_token'];
        $payload = self::getTokenPayload($token);
       

        return $payload['crsf'];
    }

    public static function getCurrentUserId()
    {
        return self::$currentUserId;
    }
    
    public static function setCurrentUserId($userId)
    {
        self::$currentUserId = $userId;
    }
}
// error_reporting(E_ALL);
