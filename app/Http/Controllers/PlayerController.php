<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class PlayerController extends Controller
{
    protected $payerGroup;
    protected $player;

    /**
     * PlayerController constructor.
     */
    public function __construct()
    {
        $this->payerGroup = new PlayerGroup();
        $this->player = new Player();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        return view('player.index');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getPlayers()
    {
        $players = $this->player->getPlayers();
        return DataTables::of($players)
            ->addColumn('group', function ($player) {
                return $player->group->name;
            })
            ->addColumn('team', function ($player) {
                return $player->group->team->name;
            })
            ->addColumn('photo', function ($player) {
                return '<img width="50px" height="50px" src='.$player->getMedia('player')[0]->getFullUrl().'>';
            })
            ->addColumn('action', function ($player) {
                $html = '<form class="form-inline" id="form'.$player->id.'" action="'.route('players.destroy', $player->id).'"  method="post">';
                if (Auth::user()->hasAnyPermission(['Player edit'])) {
                    $html .= '<a href="'.route('players.edit', $player->id).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>';
                } else {
                    $html .= '';
                }
                if (Auth::user()->hasAnyPermission(['Player delete'])) {
                    $html .= ''.method_field("delete").csrf_field().'<button class="btn btn-danger" onclick="confirmDelete('.$player->id.')" type="button"><i class = "fa fa-trash "></i></button></form><script></script>';
                } else {
                    $html .= '</form>';
                }
                return $html;
            })
            ->rawColumns(['action', 'photo'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $playerGroups = $this->payerGroup->getPlayerGroups();
        return view('player.create', compact('playerGroups'));
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
            'player_group' => 'required',
            'name' => 'required',
            'image' => 'required'
        ]);

        $player = new Player();
        $player->player_group_id = $request->player_group;
        $player->name = $request->name;
        if ($player->save()) {
            $player->addMediaFromRequest('image')->toMediaCollection('player');
            Session::put('success', 'Player added successfully !');
        } else {
            Session::put('error', 'Unable to add !');
        }
        return redirect('/players');
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
        $player= Player::find($id);
        if (!$player) {
            abort(404);
        }
        $playerGroups = $this->payerGroup->getPlayerGroups();
        return view('player.edit', compact('player', 'playerGroups'));
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
            'player_group' => 'required',
            'name' => 'required'
        ]);

        $player= Player::find($id);
        if (!$player) {
            abort(404);
        }
        $player->player_group_id = $request->player_group;
        $player->name = $request->name;
        if ($player->save()) {
            if ($request->hasFile('image')) {
                $player->clearMediaCollection('player');
                $player->addMediaFromRequest('image')->toMediaCollection('player');
            }
            Session::put('success', 'Player updated successfully !');
        } else {
            Session::put('error', 'Unable to update !');
        }
        return redirect('/players');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player= Player::find($id);
        if (!$player) {
            abort(404);
        }
        $player->delete();
        Session::put('success', 'Player deleted successfully !');
        return redirect('/players');
    }
}
