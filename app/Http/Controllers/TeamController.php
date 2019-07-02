<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class TeamController extends Controller
{
    protected $team;
    protected $club;

    public function __construct()
    {
        $this->team = new Team();
        $this->club = new Club();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('team.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getTeams()
    {
        $teams = $this->team->getTeams();

        return DataTables::of($teams)
            ->addColumn('team', function ($team) {
                return $team->name;
            })
            ->addColumn('action', function ($team) {
                $html = '<form class="form-inline" id="form'.$team->id.'" action="'.route('teams.destroy', $team->id).'"  method="post">';
                if (Auth::user()->hasAnyPermission(['Team edit'])) {
                    $html .= '<a href="'.route('teams.edit', $team->id).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>';
                } else {
                    $html .= '';
                }
                if (Auth::user()->hasAnyPermission(['Team delete'])) {
                    $html .= ''.method_field("delete").csrf_field().'<button class="btn btn-danger" onclick="confirmDelete('.$team->id.')" type="button"><i class = "fa fa-trash "></i></button></form><script></script>';
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
        return view('team.create');
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
            'name' => 'required'
        ]);

        $team = new Team();
        $team->club_id = $this->club->authClub()->id;
        $team->name = $request->name;
        if ($team->save()) {
            Session::put('success', 'Team added successfully !');
        } else {
            Session::put('error', 'Unable to update !');
        }
        return redirect('/teams');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::find($id);
        if (!$team) {
            abort(404);
        }
        return view('team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $team = Team::find($id);
        $team->name = $request->name;
        if ($team->save()) {
            Session::put('success', 'Team updated successfully !');
        } else {
            Session::put('error', 'Unable to update !');
        }
        return redirect('/teams');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::find($id);
        if (!$team) {
            abort(404);
        }
        $team->delete();
        Session::put('success', 'Team deleted successfully !');
        return redirect('/teams');
    }
}
