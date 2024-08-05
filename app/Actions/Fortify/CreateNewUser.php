<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB; 
use App\Enums\SuscripcionStatusEnum; 

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // return User::create([
        //     'name' => $input['name'],
        //     'email' => $input['email'],
        //     'password' => Hash::make($input['password']),
        // ]);

        return DB::transaction(function() use ($input) { 
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            // try {
            //     $user->suscripcion()->create([
            //         'estatus' => SuscripcionStatusEnum::Inactiva,
            //     ]);
            // } catch (\Throwable $th) {
            //     $user->delete(); 
            //     throw $th; 
            // }

            try {
                $user->roles()->sync(2); 
            } catch (\Throwable $th) {
                $user->delete(); 
                throw $th; 
            }

            return $user;
        });
    }
}
