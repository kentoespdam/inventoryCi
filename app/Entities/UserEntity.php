<?php

namespace App\Entities;

use App\Models\Master\VPegawaiModel;
use CodeIgniter\Entity\Entity;
use Config\Database;
use Firebase\JWT\JWT;

class UserEntity extends Entity
{
    public function doLogin($password)
    {
        $db = Database::connect('eoffice');
        $q = $db->query("SELECT PASSWORD('$password') as password")->getRow();
        if ($q->password != $this->attributes['user_password']) return false;
        $validOrg = model(VPegawaiModel::class)
            ->where([
                'nipam' => $this->attributes['user_login'],
            ])
            ->where("org_code IN ('BA4.3','BA9.2')")
            ->first();
        if (!$validOrg) return false;

        return true;
    }
    public function generateToken()
    {
        $u = model(VPegawaiModel::class)->where('nipam', $this->attributes['user_login'])->first();
        $key = getenv('encryption.key');
        $iat = time();
        $nbf = $iat;
        $exp = $iat + 21600;
        $payload = [
            "iss" => getenv("app.baseURL"),
            "aud" => getenv("app.baseURL"),
            'nipam' => $u->nipam,
            'nama' => $u->nama,
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $exp,
            "data" => $u
        ];

        // $jwt = JWT::encode($payload, $key, 'HS256');
        $result = [
            'token' => JWT::encode($payload, $key, 'HS256'),
            'nipam' => $u->nipam,
            'nama' => $u->nama
        ];

        return $result;
    }
}
