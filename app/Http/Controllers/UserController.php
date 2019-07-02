<?php

namespace App\Http\Controllers;

use App\Events\SendWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    protected $user;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function loginOtherUser($id)
    {
        $id = $this->decrypt($id);

        $user = User::find($id);
        if (!$user) {
            return abort(404);
        }
        Auth::user()->impersonate($user);
        return redirect('/home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logoutOtherUser()
    {
        Auth::user()->leaveImpersonation();
        return redirect('/home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getSuperAdmins()
    {
        $users = $this->user->getSuperAdmins();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                $html = '<form class="form-inline" id="form'.$user->id.'" action="'.route('users.destroy', $user->id).'"  method="post">';
                if (Auth::user()->hasAnyPermission(['User delete']) && Auth::id() != $user->id) {
                    $html .= ''.method_field("delete").csrf_field().'<button class="btn btn-danger" onclick="confirmDelete('.$user->id.')" type="button"><i class = "fa fa-trash "></i></button></form><script></script>';
                } else {
                    $html .= '</form>';
                }
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users'
        ]);

        $password = Str::random(10);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $password;
        if ($user->save()) {
            $user->assignRole('Super admin');
            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
                'subject' => 'Welcome',
                'link' => url('/'),
            ];
            event(new SendWelcomeMail($data));
            Session::put('success', 'Club added successfully !');
        } else {
            Session::put('error', 'Unable to add !');
        }
        return redirect('/users');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function destroy($id)
    {
        $user= User::find($id);
        if (!$user) {
            return abort(404);
        }
        $user->delete();
        Session::put('success', 'Super admin deleted successfully !');
        return redirect('/users');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
