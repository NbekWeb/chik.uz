<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaint = Complaint::orderBy('id', 'desc')->paginate(15);
        return view('pages.superUser.complaints', ['complaints' => $complaint]);
    }
    public function store()
    {
    }
    public function update(Request $request, Complaint $complaint)
    {
    }
    public function destroy(Complaint $complaint)
    {
        return $complaint->delete();
    }
}
