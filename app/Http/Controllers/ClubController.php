<?php

namespace App\Http\Controllers;

use App\Events\ClubDelete;
use App\Events\SendWelcomeMail;
use App\Models\Club;
use App\Models\ClubHasUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ClubController extends Controller
{
    protected $club;

    public function __construct()
    {
        $this->club = new Club();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('club.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getClubs()
    {
        $clubs = $this->club->getClubs();

        return DataTables::of($clubs)
            ->addColumn('admin', function ($club) {
                return $club->hasUser->user->name;
            })
            ->addColumn('action', function ($club) {
                $html = '<form class="form-inline" id="form'.$club->id.'" action="'.route('clubs.destroy', $club->id).'"  method="post">';
                if (Auth::user()->hasAnyPermission(['Login other'])) {
                    $html .= '<a href="'.route('login.other', $this->encrypt($club->hasUser->user->id)).'" class = "btn btn-primary"><i class="fa fa-lock"></i></a>';
                }
                if (Auth::user()->hasAnyPermission(['Club delete'])) {
                    $html .= ''.method_field("delete").csrf_field().'<button class="btn btn-danger" onclick="confirmDelete('.$club->id.')" type="button"><i class = "fa fa-trash "></i></button></form><script></script>';
                } else {
                    $html .= '</form>';
                }
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('club.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'club_name' => 'required|unique:clubs,name',
            'name' => 'required',
            'email' => 'required|unique:users'
        ]);

        $club = new Club();
        $club->name = $request->club_name;
        $club->save();
        $password = Str::random(10);
        $user = new User();
        $user->name = $request->name;
        $user->password = bcrypt($password);
        $user->email = $request->email;
        $user->save();

        if ($club->save() && $user->save()) {
            $user->assignRole('Club admin');
            ClubHasUser::create(['user_id' => $user->id, 'club_id' => $club->id]);
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
        return redirect('/clubs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $club= Club::find($id);
        if (!$club) {
            return abort(404);
        }
        event(new ClubDelete($id));
        Session::put('success', 'Club deleted successfully !');
        return redirect('/clubs');
    }
}
