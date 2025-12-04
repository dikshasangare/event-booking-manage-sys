<?php

use Illuminate\Support\Facades\Auth;

function hasRole($role): bool {
    return Auth::check() && Auth::user()->hasRole($role);
}

function hasPermission($permission): bool {
    return Auth::check() && Auth::user()->can($permission);
}

function hasAnyRole($roles): bool {
    return Auth::check() && Auth::user()->hasAnyRole($roles);
}
