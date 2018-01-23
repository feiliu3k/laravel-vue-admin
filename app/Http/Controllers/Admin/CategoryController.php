<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\PatternRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * @var RoleRepositoryInterface $roleRepository
     */
    private $categoryRepository;

    private $patternRepository;


    public function __construct(CategoryRepositoryInterface $categoryRepository,PatternRepositoryInterface $patternRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->patternRepository = $patternRepository;

    }

    /**
     * 管理员，对用户进行修改，新增操作
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function category_save(Request $request)
    {

        $id = intval($request->input("id", 0));

        $data = $request->only('name', 'alias', 'pattern_id');
        $this->category_validation($request, $id);
        if ($id > 0) {
            $data = $this->categoryRepository->updateRich($data, $id);
        } else {
            $data = $this->categoryRepository->create($data);
        }
        $data->load('pattern');
        return $this->result($data != null, $data);

    }


    public function category_list()
    {
        $result = $this->categoryRepository->paginate();
        return $this->result(true, $result);
    }

    public function category_remove( $id = 0 ){

        return $this->result( $this->categoryRepository->delete( $id ) );
    }

    protected function category_validation($request, $id)
    {

        $category = [
            'name' => ['required', 'string', 'max:255'],
            'alias' => ['required', 'string'],
            'pattern_id' => 'required'
        ];
        if ($id < 1) {
            // 新用户做唯一性检测
            $category['name'][] = "unique:categories,name";
        } else {
            $category['name'][] = Rule::unique('categories')->ignore($id);
        }

        $this->validateWith($category, $request);
    }

    /**
     * 管理员，对用户进行修改，新增操作
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pattern_save(Request $request)
    {

        $id = intval($request->input("id", 0));

        $data = $request->only('name', 'category_template', 'list_template', 'show_template');
        $this->pattern_validation($request, $id);
        if ($id > 0) {
            $data = $this->patternRepository->updateRich($data, $id);
        } else {
            $data = $this->patternRepository->create($data);
        }
        return $this->result($data != null, $data);

    }

    public function pattern_all()
    {
        $data = $this->patternRepository->get_all();
        return $this->result($data != null, $data);
    }



    public function pattern_list()
    {
        $result = $this->patternRepository->paginate();
        return $this->result(true, $result);
    }

    public function pattern_remove( $id = 0 ){

        return $this->result( $this->patternRepository->delete( $id ) );
    }

    protected function pattern_validation($request, $id)
    {

        $pattern = [
            'name' => ['required', 'string', 'max:255'],
            'category_template' => ['required', 'string'],
            'list_template' => ['required', 'string'],
            'show_template' => ['required', 'string'],
        ];
        if ($id < 1) {
            // 新用户做唯一性检测
            $pattern['name'][] = "unique:patterns,name";
        } else {
            $pattern['name'][] = Rule::unique('patterns')->ignore($id);
        }

        $this->validateWith($pattern, $request);
    }
}
