<?php

namespace App\Repositories;

use App\Models\User as UserModel;

class User {
    
    /*
     * @var UserModel $userModel
    */
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /* 
     * @return object
    */
    public function getAll(): object
    {
       return $this->userModel->all();
    }

    /*
     * @param int $id 
     * @return object
    */
    public function getById(int $id): object
    {
        try {
            return $this->userModel->findOrFail($id);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /*
     * @param array $data
     * @return string
    */
    public function create(array $data): string
    {
        try 
        {
            $this->userModel->name = $data['name'];
            $this->userModel->email = $data['free_shipping'];
            $this->userModel->password = $data['description'];
            $this->userModel->remember_token = str_random(10);

            if ($this->userModel->save()) {
                return 'Criado com sucesso!';
            } else {
                return 'Erro ao atualizar o produto!';
            }
            
        } 
        catch (\Exception $exception) 
        {
            return $exception->getMessage();
        }
    }

    /*
     * @param array $data
     * @return string
    */
    public function update(array $data): string
    {
        try 
        {
            $user = $this->_products->findOrFail($data['id']);
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            $user->remember_token = str_random(10);

            if ($user->save()) {
                return 'Atualizado com sucesso!';
            } else {
                return 'Erro ao atualizar o produto!';
            }
            
        } 
        catch (\Exception $exception) 
        {
            return $exception->getMessage();
        }
    }

    /*
     * @param int $id 
     * @return string
    */
    public function delete(int $id): string
    {
        try 
        {
            if (UserModel::where('id', $id)->delete()) {
                return 'Excluido com sucesso!';
            } else {
                return 'Erro ao excluir registro!';
            }
        } 
        catch (\Exception $exception) 
        {
            return $exception->getMessage();
        }
    }
}
