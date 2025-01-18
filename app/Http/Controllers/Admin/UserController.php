<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct(protected UserService $userService){}

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $countries = $this->userService->getAllCountries();
        return view('admin.users.create', compact('countries'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser($request->validated());
        return redirect()->route('admin.users.index')->with('success', __('admin.progress_success'));
    }

    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        $countries = $this->userService->getAllCountries();
        return view('admin.users.edit', compact('user', 'countries'));
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        $countries = $this->userService->getAllCountries();
        return view('admin.users.show', compact('user', 'countries'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->updateUser($id, $request->validated());
        return redirect()->route('admin.users.index')->with('success', __('admin.progress_success'));
    }

    public function toggle(Request $request)
    {
        $user = $this->userService->getUserById($request->id);
        $this->userService->toggleField($user, $request->field);
        return redirect()->back()->with('success', __('admin.progress_success'));
    }

    public function deleteSelected(Request $request)
    {
        $this->userService->deleteUsers($request->input('ids', []));
        return response()->json(['success' => true, 'message' => __('admin.progress_success')]);
    }
}
