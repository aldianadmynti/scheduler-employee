<?php

namespace App\Http\Controllers;

use App\Models\Scheduller;
use App\Models\User;
use Illuminate\Http\Request;

class SchedullerController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $datas = Scheduller::query();

        if (auth()->user()->role->name != 'admin') {
            $datas->where('user_id', auth()->user()->id);
        }

        if ($request->search) {
            $datas->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->date) {
            $datas->whereDate('start_date', $request->date)->orWhereDate('end_date', $request->date);
        }

        Scheduller::where('user_id', auth()->user()->id)->where('status_read', 'unread')->update(['status_read' => 'read']);

        $datas = $datas->get();

        return view('pages.scheduller', compact(['datas', 'users']));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'place' => 'required',
        ]);

        if ($scheduller = Scheduller::create($validate)) {
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->back()->withErrors(['error' => 'Data gagal ditambahkan']);
        }
    }

    public function edit(Scheduller $scheduller)
    {
        $users = User::all();
        return view('pages.scheduller-edit', compact(['scheduller', 'users']));
    }

    public function update(Request $request, Scheduller $scheduller)
    {
        $validate = $request->validate([
            'user_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'place' => 'required',
        ]);

        if ($scheduller->update($validate)) {
            return redirect()->back()->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->back()->withErrors(['error' => 'Data gagal diubah']);
        }
    }

    public function destroy(Scheduller $scheduller)
    {
        if ($scheduller->delete()) {
            return redirect()->route('scheduller.index')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->withErrors(['error' => 'Data gagal dihapus']);
        }
    }
}
