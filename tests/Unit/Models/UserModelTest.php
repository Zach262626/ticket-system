<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

it('has tickets relation', function () {
    $user = new User();
    expect($user->tickets())->toBeInstanceOf(HasMany::class);
});

it('has attachments relation', function () {
    $user = new User();
    expect($user->attachments())->toBeInstanceOf(HasMany::class);
});

it('has messages relation', function () {
    $user = new User();
    expect($user->messages())->toBeInstanceOf(HasMany::class);
});

