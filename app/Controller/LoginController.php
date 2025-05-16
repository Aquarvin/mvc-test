<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Repository\UserRepository;
use App\Model\Service\AuthenticateUser;
use App\Model\User;
use App\Session;
use Symfony\Component\Routing\RouteCollection;

class LoginController
{
    private Session $session;

    private UserRepository $userRepository;

    public function __construct()
    {
        $this->session = new Session();
        $this->userRepository = new UserRepository();
    }

    public function indexAction(RouteCollection $routes): void
    {
        $user = $this->initUser();

        require_once APP_ROOT . '/app/view/login.php';
    }

    public function loginPostAction(RouteCollection $routes): void
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $authenticateUser = new AuthenticateUser();
            try {
                $user = $authenticateUser->execute($_POST['email'], $_POST['password']);
                $result['success'] = true;
                $result['message'] = 'Welcome ' . $user->getFirstName() . ' ' . $user->getLastName();
                $this->session->set('user', $user->getId());
            } catch (\Exception $e) {
                $result['success'] = false;
                $result['message'] = $e->getMessage();
            } finally {
                echo json_encode($result);
            }
        }
    }

    public function logoutPostAction(RouteCollection $routes): void
    {
        $this->session->remove('user');
        $user = null;
        require_once APP_ROOT . '/app/view/login.php';
    }

    private function initUser(): ?User
    {
        $user = null;

        if ($this->session->get('user')) {
            try {
                $user = $this->userRepository->get((int)$this->session->get('user'));
            } catch (\Exception $e) {
            }
        }

        return $user;
    }
}
