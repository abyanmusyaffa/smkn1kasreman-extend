<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"admin","guard_name":"web","permissions":["view_article","view_extracurricular","view_jobfair","view_achievement","view_any_achievement","create_achievement","update_achievement","delete_achievement","delete_any_achievement","view_alumni","view_any_alumni","create_alumni","update_alumni","delete_alumni","delete_any_alumni","view_any_article","create_article","update_article","delete_article","delete_any_article","view_any_extracurricular","create_extracurricular","update_extracurricular","delete_extracurricular","delete_any_extracurricular","view_facility","view_any_facility","create_facility","update_facility","delete_facility","delete_any_facility","view_any_jobfair","create_jobfair","update_jobfair","delete_jobfair","delete_any_jobfair","view_major","view_any_major","create_major","update_major","delete_major","delete_any_major","view_partner","view_any_partner","create_partner","update_partner","delete_partner","delete_any_partner","view_photo","view_any_photo","create_photo","update_photo","delete_photo","delete_any_photo","view_staff","view_any_staff","create_staff","update_staff","delete_staff","delete_any_staff","view_testimonial","view_any_testimonial","create_testimonial","update_testimonial","delete_testimonial","delete_any_testimonial","view_user","view_any_user","create_user","update_user","delete_user","delete_any_user","view_weblink","view_any_weblink","create_weblink","update_weblink","delete_weblink","delete_any_weblink","page_About","page_Download"]},{"name":"author","guard_name":"web","permissions":["view_article","view_jobfair","view_achievement","view_any_achievement","create_achievement","update_achievement","delete_achievement","view_any_article","create_article","update_article","delete_article","view_any_jobfair","create_jobfair","update_jobfair","delete_jobfair"]},{"name":"super_admin","guard_name":"web","permissions":["view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_article","view_extracurricular","view_jobfair","view_achievement","view_any_achievement","create_achievement","update_achievement","delete_achievement","delete_any_achievement","view_alumni","view_any_alumni","create_alumni","update_alumni","delete_alumni","delete_any_alumni","view_any_article","create_article","update_article","delete_article","delete_any_article","view_any_extracurricular","create_extracurricular","update_extracurricular","delete_extracurricular","delete_any_extracurricular","view_facility","view_any_facility","create_facility","update_facility","delete_facility","delete_any_facility","view_any_jobfair","create_jobfair","update_jobfair","delete_jobfair","delete_any_jobfair","view_major","view_any_major","create_major","update_major","delete_major","delete_any_major","view_partner","view_any_partner","create_partner","update_partner","delete_partner","delete_any_partner","view_photo","view_any_photo","create_photo","update_photo","delete_photo","delete_any_photo","view_staff","view_any_staff","create_staff","update_staff","delete_staff","delete_any_staff","view_testimonial","view_any_testimonial","create_testimonial","update_testimonial","delete_testimonial","delete_any_testimonial","view_user","view_any_user","create_user","update_user","delete_user","delete_any_user","view_weblink","view_any_weblink","create_weblink","update_weblink","delete_weblink","delete_any_weblink","page_About","page_Download"]}]';
        $directPermissions = '{"13":{"name":"restore_achievement","guard_name":"web"},"14":{"name":"restore_any_achievement","guard_name":"web"},"15":{"name":"replicate_achievement","guard_name":"web"},"16":{"name":"reorder_achievement","guard_name":"web"},"19":{"name":"force_delete_achievement","guard_name":"web"},"20":{"name":"force_delete_any_achievement","guard_name":"web"},"25":{"name":"restore_alumni","guard_name":"web"},"26":{"name":"restore_any_alumni","guard_name":"web"},"27":{"name":"replicate_alumni","guard_name":"web"},"28":{"name":"reorder_alumni","guard_name":"web"},"31":{"name":"force_delete_alumni","guard_name":"web"},"32":{"name":"force_delete_any_alumni","guard_name":"web"},"36":{"name":"restore_article","guard_name":"web"},"37":{"name":"restore_any_article","guard_name":"web"},"38":{"name":"replicate_article","guard_name":"web"},"39":{"name":"reorder_article","guard_name":"web"},"42":{"name":"force_delete_article","guard_name":"web"},"43":{"name":"force_delete_any_article","guard_name":"web"},"47":{"name":"restore_extracurricular","guard_name":"web"},"48":{"name":"restore_any_extracurricular","guard_name":"web"},"49":{"name":"replicate_extracurricular","guard_name":"web"},"50":{"name":"reorder_extracurricular","guard_name":"web"},"53":{"name":"force_delete_extracurricular","guard_name":"web"},"54":{"name":"force_delete_any_extracurricular","guard_name":"web"},"59":{"name":"restore_facility","guard_name":"web"},"60":{"name":"restore_any_facility","guard_name":"web"},"61":{"name":"replicate_facility","guard_name":"web"},"62":{"name":"reorder_facility","guard_name":"web"},"65":{"name":"force_delete_facility","guard_name":"web"},"66":{"name":"force_delete_any_facility","guard_name":"web"},"70":{"name":"restore_jobfair","guard_name":"web"},"71":{"name":"restore_any_jobfair","guard_name":"web"},"72":{"name":"replicate_jobfair","guard_name":"web"},"73":{"name":"reorder_jobfair","guard_name":"web"},"76":{"name":"force_delete_jobfair","guard_name":"web"},"77":{"name":"force_delete_any_jobfair","guard_name":"web"},"82":{"name":"restore_major","guard_name":"web"},"83":{"name":"restore_any_major","guard_name":"web"},"84":{"name":"replicate_major","guard_name":"web"},"85":{"name":"reorder_major","guard_name":"web"},"88":{"name":"force_delete_major","guard_name":"web"},"89":{"name":"force_delete_any_major","guard_name":"web"},"94":{"name":"restore_partner","guard_name":"web"},"95":{"name":"restore_any_partner","guard_name":"web"},"96":{"name":"replicate_partner","guard_name":"web"},"97":{"name":"reorder_partner","guard_name":"web"},"100":{"name":"force_delete_partner","guard_name":"web"},"101":{"name":"force_delete_any_partner","guard_name":"web"},"106":{"name":"restore_photo","guard_name":"web"},"107":{"name":"restore_any_photo","guard_name":"web"},"108":{"name":"replicate_photo","guard_name":"web"},"109":{"name":"reorder_photo","guard_name":"web"},"112":{"name":"force_delete_photo","guard_name":"web"},"113":{"name":"force_delete_any_photo","guard_name":"web"},"118":{"name":"restore_staff","guard_name":"web"},"119":{"name":"restore_any_staff","guard_name":"web"},"120":{"name":"replicate_staff","guard_name":"web"},"121":{"name":"reorder_staff","guard_name":"web"},"124":{"name":"force_delete_staff","guard_name":"web"},"125":{"name":"force_delete_any_staff","guard_name":"web"},"130":{"name":"restore_testimonial","guard_name":"web"},"131":{"name":"restore_any_testimonial","guard_name":"web"},"132":{"name":"replicate_testimonial","guard_name":"web"},"133":{"name":"reorder_testimonial","guard_name":"web"},"136":{"name":"force_delete_testimonial","guard_name":"web"},"137":{"name":"force_delete_any_testimonial","guard_name":"web"},"142":{"name":"restore_user","guard_name":"web"},"143":{"name":"restore_any_user","guard_name":"web"},"144":{"name":"replicate_user","guard_name":"web"},"145":{"name":"reorder_user","guard_name":"web"},"148":{"name":"force_delete_user","guard_name":"web"},"149":{"name":"force_delete_any_user","guard_name":"web"},"154":{"name":"restore_weblink","guard_name":"web"},"155":{"name":"restore_any_weblink","guard_name":"web"},"156":{"name":"replicate_weblink","guard_name":"web"},"157":{"name":"reorder_weblink","guard_name":"web"},"160":{"name":"force_delete_weblink","guard_name":"web"},"161":{"name":"force_delete_any_weblink","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
