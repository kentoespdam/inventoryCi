<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-Token");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }

        $session = session();

        $path = explode('/', $_SERVER["REQUEST_URI"]);

        // print_r($path[1]);
        if ($session->get('token') == null && $path[1] != "Auth") {
            return redirect()->to('/Auth');
        }

        // $this->cekToken($request);
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }

    private function cekToken($request)
    {
        $response = Services::response();
        $header = $request->header('X-Token');
        $pth = explode("/", $request->getServer('PATH_INFO'));
        if (!in_array('login_eo', $pth)) {
            if (!$header) {
                $json = json_encode(['message' => 'Unauthorized']);
                return $response->setStatusCode(401)->setBody($json);
            }
            $authenticator = $header->getValue();
            $key = getenv('encryption.key');
            try {
                $decode = JWT::decode($authenticator, new Key($key, 'HS256'));
                //         print_r($decode);
            } catch (Exception $ex) {
                $json = json_encode(['message' => 'Token Not Valid!!!']);
                return $response->setStatusCode(401)->setBody($json);
            }
        }
    }
}
