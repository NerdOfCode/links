<?php

namespace App\Http\Controllers;

use App\Models\Links;
use App\Models\OurUsers;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public function accountName(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        if ($name = $request->input('name')) {
            $user = new OurUsers;

            $user->name = $name;
            $user->save();

            $request->session()->put('name', $name);
        }
        
        return back()->withInput();
    }

    public function accountLogout(Request $request) {
        $request->session()->flush();

        return back();
    }

    public function linksHome(Request $request) {
        $user = OurUsers::where('name', $request->session()->get('name'))
                    ->first();

        $allLinks = Links::class;

        if ($user) {
            $allLinks = $user->links();
        }

        return view('links', ['name' => $request->session()->get('name'), 'links' => $allLinks]);
    }

    public function deleteLink(Request $request, $linkID) {
        $link = Links::where('id', $linkID)
            ->delete();

        return back()->withInput();
    }

    public function storeLink(Request $request) {
        $validated = $request->validate([
            'name' => 'required|url|max:255',
        ]);

        $user = OurUsers::where('name', $request->session()->get('name'))
            ->first();

        if (!$user) {
            return back();
        }

        $link = new Links;

        $link->name = $request->input('name');
        $link->user_id = $user->id;

        $link->save();

        return back()->withInput();
    }
}
