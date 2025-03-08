<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->morphToMany(Role::class, 'roleable');
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::firstOrCreate(['name' => $role]);
        }

        $this->roles()->syncWithoutDetaching([$role->id]);
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }

        if ($role) {
            $this->roles()->detach($role->id);
        }
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return $this->roles->contains('id', $role->id);
    }
}
