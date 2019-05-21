<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\User;
use App\Models\User as UserModel;

class UserTest extends TestCase
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new User;
    }

    private function factoryUser(int $qtd)
    {
        return factory(UserModel::class, $qtd)->make();
    }

    /**
     * @test
     */
    public function it_receive_all_users()
    {
        $users = $this->factoryUser(10);

        $response = $this->repository->getAll();

        $this->assertEquals($users, $response);
    }

    /*
     * @test
     */
    public function it_receive_correct_user()
    {        
        $users =$this->factoryUser(1);
        
        $response = $this->repository->getById(1);

        $this->assertEquals($users, $response);
    }
    
    /*
     * @test
     */
    public function it_has_no_error_on_create_user()
    {
        $user = $this->repository->create([
            'name' => 'Teste',
            'email' => 'teste@teste.com.br',
            'password' => '123456' 
        ]);

        $this->assertEquals('Criado com sucesso!', $user);
    }

    /*
     * @test
     */
    public function it_has_no_error_in_update_user()
    {
        $this->factoryUser(1);

        $user = $this->repository->update([
            'id' => 1,
            'name' => 'Teste',
            'email' => 'teste@teste.com.br',
            'password' => '123456' 
        ]);

        $this->assertEquals('Atualizado com sucesso!', $user);
    }

    /*
     * @test
     */
    public function it_user_was_deleted()
    {
        $this->factoryUser(1);

        $user = $this->repository->delete(1);

        $this->assertEquals('Excluido com sucesso!', $user);
    }
}
