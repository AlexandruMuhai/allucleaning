<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->isPracownik()) {
            return redirect()->route('admin.jobs.index');
        }

        if ($user->isKlient()) {
            return redirect()->route('admin.locations.index');
        }

        $stats = [
            'users' => User::count(),
            'administrators' => User::where('role', 'administrator')->count(),
            'pracownicy' => User::where('role', 'pracownik')->count(),
            'klienci' => User::where('role', 'klient')->count(),
            'contact_requests' => ContactRequest::count(),
            'unread_requests' => ContactRequest::where('is_read', false)->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentRequests = ContactRequest::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentRequests'));
    }
}
