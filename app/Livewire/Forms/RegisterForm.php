<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Form;

class RegisterForm extends Form
{
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|string|lowercase|email|max:255|unique:users')]
    public string $email = '';

    #[Rule('required|string|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    public function store(): void
    {
        $validated = $this->validate();
        $validated['password'] = Hash::make($validated['password']);
        event(new Registered($user = User::create($validated)));
        Auth::login($user);
    }
}
