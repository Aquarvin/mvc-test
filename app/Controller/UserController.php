<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use Symfony\Component\Routing\RouteCollection;

class UserController
{
    const SUCCESS_MESSAGE = 'User have been created';
    const ERROR_MESSAGE = 'Something went wrong';

    public function indexAction(RouteCollection $routes): void
    {
        require_once APP_ROOT . '/app/view/user.php';
    }

    public function postAction(RouteCollection $routes): void
    {
        $user = new User();

        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'password' => $_POST['password'],
        ];
        $success = true;
        if (!$this->validateData($data)) {
            $result['success'] = false;
            $result['message'] = self::ERROR_MESSAGE;
            echo json_encode($result);
            return;
        }
        try {
            $user = $user->create($data);
        } catch (\Exception $e) {
            $success = false;
        }
        $result['success'] = $success;
        $result['message'] = $success ? self::SUCCESS_MESSAGE : self::ERROR_MESSAGE;

        echo json_encode($result);
    }

    // todo: implement different validation types
    private function validateData(array $data): bool
    {
        $valid = true;
        foreach ($data as $input) {
            if (empty($input)) {
                $valid = false;
            }
        }
        return $valid;
    }
}
