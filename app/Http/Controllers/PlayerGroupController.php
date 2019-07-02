<?php

namespace App\Http\Controllers;

use App\Models\PlayerGroup;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class PlayerGroupController extends Controller
{
    protected $payerGroup;
    protected $team;

    public function __construct()
    {
        $this->payerGroup = new PlayerGroup();
        $this->team = new Team();
    }

    public function index()
    {
        return view('player-group.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getPlayerGroups()
    {
        $groups = $this->payerGroup->getPlayerGroups();

        return DataTables::of($groups)
            ->addColumn('team', function ($group) {
                return $group->team->name;
            })
            ->addColumn('action', function ($group) {
                $html = '<form class="form-inline" id="form'.$group->id.'" action="'.route('player-groups.destroy', $group->id).'"  method="post">';
                if (Auth::user()->hasAnyPermission(['Player group edit'])) {
                    $html .= '<a href="'.route('player-groups.edit',$group->id).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>';
                } else {
                    $html .= '';
                }
                if (Auth::user()->hasAnyPermission(['Player group delete'])) {
                    $html .= ''.method_field("delete").csrf_field().'<button class="btn btn-danger" onclick="confirmDelete('.$group->id.')" type="button"><i class = "fa fa-trash "></i></button></form><script></script>';
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
        $teams = $this->team->getTeams();
        return view('player-group.create', compact('teams'));
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
            'team' => 'required',
            'name' => 'required'
        ]);

        $group = new PlayerGroup();
        $group->team_id = $request->team;
        $group->name = $request->name;
        if ($group->save()) {
            Session::put('success', 'Player group added successfully !');
        } else {
            Session::put('error', 'Unable to update !');
        }
        return redirect('/player-groups');
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
        $teams = $this->team->getTeams();
        $playerGroup = PlayerGroup::find($id);
        if (!$playerGroup) {
            abort(404);
        }
        return view('player-group.edit', compact('teams', 'playerGroup'));
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
            'team' => 'required',
            'name' => 'required'
        ]);

        $playerGroup = PlayerGroup::find($id);
        if (!$playerGroup) {
            abort(404);
        }
        $playerGroup->team_id = $request->team;
        $playerGroup->name = $request->name;
        if ($playerGroup->save()) {
            Session::put('success', 'Player group updated successfully !');
        } else {
            Session::put('error', 'Unable to add !');
        }
        return redirect('/player-groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $playerGroup = PlayerGroup::find($id);
        if (!$playerGroup) {
            abort(404);
        }
        $playerGroup->delete();
        Session::put('success', 'Player group deleted successfully !');
        return redirect('/player-groups');
    }
}
