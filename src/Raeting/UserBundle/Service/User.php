<?php

namespace Raeting\UserBundle\Service;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Raeting\UserBundle\Model\User as UserModel;

class User
{
    /**
     * @var Raeting\UserBundle\Model\User
     */
    protected $userModel;

    protected $encoderFactory;

    /**
     * @param Pombia\UserBundle\Model\User $userModel
     * @param object                       $encoderFactory
     */
    public function __construct(
        UserModel $userModel, 
        $encoderFactory)
    {
        $this->userModel = $userModel;
        $this->encoderFactory = $encoderFactory;

    }

    /**
     * Search for user by email.
     *
     * @param string $email
     *
     * @return array
     */
    public function getByEmail($email)
    {
        return $this->userModel->getByEmail($email);
    }

    /**
     * Get user by id
     * @param  $id
     * @return array
     */
    public function getById($id)
    {
        return $this->userModel->getById($id);
    }

    /**
     * @NOTE 2012-10-31 disabled user creation
     * Method used only in Order service
     * Check if user exists with specific email, if no - create
     * and return created user data
     *
     * @param array $data user data from form
     *
     * @return array user data from DB
     */
    public function getOrCreate($data)
    {
        // $email = $data['email'];

        // $user = $this->getByEmail($email);

        // if ($user) {
        //     return $user;
        // }
        
        $data['id'] = 0;

        return $data;
        // $id = $this->userModel->insert($data);
        // return $this->getById($id);
    }

    /**
     * Register user to system.
     *
     * @param array $userData Regisration form data.
     *
     * @return int User id.
     */
    public function register(array $userData)
    {
        $user = $this->userModel->getByEmailAndGroup($userData['email'], UserModel::USERGROUP_CUSTOMER);

        if (!empty($user)) {
            throw new \UnexpectedValueException(sprintf('Username "%s" already registered', $userData['email']));
        }

        $data = array(
            'created_on' => date('Y-m-d H:i:s'),
            'firstname' => $userData['firstname'],
            'lastname' => $userData['lastname'],
            'email' => $userData['email'],
            'password' => $this->encodePassword($userData['password']),
            'usergroup' => UserModel::USERGROUP_CUSTOMER,
        );

        $userId = $this->userModel->insert($data);

        return $userId;
    }

    /**
     * Encode password by current settings.
     *
     * @param string $password
     *
     * @return string
     */
    public function encodePassword($password)
    {
        $plainUser = new \Raeting\UserBundle\Security\User;
        $encoder = $this->encoderFactory->getEncoder($plainUser);
        $password = $encoder->encodePassword($password, $plainUser->getSalt());

        return $password;
    }

    /**
     * Generate hash for password recovery.
     *
     * @param string $email
     *
     * @return string
     */
    protected function generateHash($email)
    {
        $string = $this->encodePassword(rand() . $email . time());

        return strtoupper(substr($string, 0, 16));
    }

    /**
     * Create recovery hash for user.
     *
     * @param string $email
     *
     * @return string Created hash.
     */
    public function createUserHash($email)
    {
        $user = $this->userModel->getByEmail($email);

        if (empty($user)) {
            throw new UsernameNotFoundException($email);
        }

        $data = array(
            'recovery_hash' => $this->generateHash($email),
            'recovery_date' => date("Y-m-d H:i:s"),
        );

        $this->userModel->update($data, array('id' => $user['id']));

        return $data['recovery_hash'];
    }

    /**
     * Check is recovery has valid and not expired for user.
     *
     * @param string $email
     * @param string $hash
     *
     * @return bool
     */
    public function isValidHash($email, $hash)
    {
        $user = $this->getByEmail($email);
        if ($user) {
            return $hash === $user['recovery_hash'] &&
                null !== $user['recovery_date'] &&
                $user['recovery_date'] > date("Y-m-d H:i:s", strtotime("-1 day"));
        }

        return false;
    }

    public function changePassword(array $formData)
    {
        if (true === $this->isValidHash($formData['email'], $formData['hash'])) {

            $data = array(
                'recovery_hash' => null,
                'recovery_date' => null,
                'password' => $this->encodePassword($formData['password']),
            );

            $this->userModel->update($data, array('email' => $formData['email']));

            return true;
        }

        return false;
    }

    /**
     * updateProfile
     * @param  array $data user data
     * @return int
     */
    public function updateProfile(array $data)
    {
        return $this->userModel->update($data, array('id' => $data['id']));
    }
    
    /**
     * updatePassword
     * @param  array $data user data
     * @return int
     */
    public function updatePassword(array $formData)
    {
        $data = array(
            'id' => $formData['id']
            );
        if (null !== $formData['password_new']) {
            $data['password'] = $this->encodePassword($formData['password_new']);
        }

        return $this->userModel->update($data, array('id' => $data['id']));
    }

    /**
     * Update user data.
     *
     * @param array $data
     *
     * @return int
     */
    public function update(array $data)
    {
        return $this->userModel->update($data, array('id' => $data['id']));
    }

    public function delete($identifier) 
    {
        return $this->userModel->delete($identifier);
    }
}
