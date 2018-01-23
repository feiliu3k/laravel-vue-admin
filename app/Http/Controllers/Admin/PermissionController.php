<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * @var RoleRepositoryInterface $roleRepository
     */
    private $roleRepository;

    /**
     * @var PermissionRepositoryInterface $roleRepository
     */
    private $permissionRepository;

    /**
     * @var UserRepositoryInterface $userRepository
     */
    private $userRepository;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository,UserRepositoryInterface $userRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * 管理员，对用户进行修改，新增操作
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function permission_save(Request $request)
    {

        $id = intval($request->input("id", 0));

        $data = $request->only('name', 'display_name', 'description');
        $this->permission_validation($request, $id);
        if ($id > 0) {
            $data = $this->permissionRepository->updateRich($data, $id);
        } else {
            $data = $this->permissionRepository->create($data);
        }
        return $this->result($data != null, $data);

    }


    public function permission_list()
    {
        $result = $this->permissionRepository->paginate();
        return $this->result(true, $result);
    }

    public function permission_remove( $id = 0 ){

        return $this->result( $this->permissionRepository->delete( $id ) );
    }

    protected function permission_validation($request, $id)
    {

        $permission = [
            'name' => ['required', 'string', 'max:255'],
            'display_name' => ['required', 'string'],
            'description' => 'required'
        ];
        if ($id < 1) {
            // 新用户做唯一性检测
            $permission['name'][] = "unique:permissions,name";
        } else {
            $permission['name'][] = Rule::unique('permissions')->ignore($id);
        }

        $this->validateWith($permission, $request);
    }

    /**
     * 管理员，对用户进行修改，新增操作
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user_save(Request $request)
    {

        $id = intval($request->input("id", 0));

        $data = $request->only('name', 'display_name', 'description');
        $this->user_validation($request, $id);
        if ($id > 0) {
            $data = $this->userRepository->updateRich($data, $id);
        } else {
            $data = $this->userRepository->create($data);
        }
        return $this->result($data != null, $data);

    }


    public function user_list()
    {
        $result = $this->userRepository->paginate();
        return $this->result(true, $result);
    }

    public function user_remove( $id = 0 ){

        return $this->result( $this->userRepository->delete( $id ) );
    }

    protected function user_validation($request, $id)
    {

        $user = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string'],
        ];
        if ($id < 1) {
            // 新用户做唯一性检测
            $user['name'][] = "unique:users,name";
        } else {
            $user['name'][] = Rule::unique('users')->ignore($id);
        }

        $this->validateWith($user, $request);
    }


    /**
     * 管理员，对用户进行修改，新增操作
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function role_save(Request $request)
    {

        $id = intval($request->input("id", 0));

        $data = $request->only('name', 'display_name', 'description');
        $this->role_validation($request, $id);
        if ($id > 0) {
            $data = $this->roleRepository->updateRich($data, $id);
        } else {
            $data = $this->roleRepository->create($data);
        }
        return $this->result($data != null, $data);

    }


    public function role_list()
    {
        $result = $this->roleRepository->paginate();
        return $this->result(true, $result);
    }

    public function role_remove( $id = 0 ){

        return $this->result( $this->roleRepository->delete( $id ) );
    }

    protected function role_validation($request, $id)
    {

        $role = [
            'name' => ['required', 'string', 'max:255'],
            'display_name' => ['required', 'string'],
            'description' => 'required'
        ];
        if ($id < 1) {
            // 新用户做唯一性检测
            $role['name'][] = "unique:roles,name";
        } else {
            $role['name'][] = Rule::unique('roles')->ignore($id);
        }

        $this->validateWith($role, $request);
    }

}
