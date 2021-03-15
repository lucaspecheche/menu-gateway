<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Fluent;
use function Sodium\compare;

class ExampleController extends Controller
{
    public function __construct(public User $user,) {}

    public function index()
    {
        try {
            $id = $this->user->getByEmail('lucas@mail.com')
                ?->id
                ?: throw new \Exception('Não encontrado');

            $result = $this->test(userId: $id,);

        } catch (\Exception) {
            $result = null;
        }

        dd($result);

    }

    public function test(float|int|null $userId,): mixed
    {
        return match($userId) {
            0 => "hello",
            1, 2, 3 => "world",
        };
    }
}
