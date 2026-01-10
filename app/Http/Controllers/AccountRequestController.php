<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use Illuminate\Http\Request;

class AccountRequestController extends Controller
{
    /**
     * Formulaire de demande de compte
     */
    public function create()
    {
        return view('public.account-request');
    }

    /**
     * Enregistrer la demande de compte
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:account_requests,email',
            'phone' => 'nullable|string|max:20',
            'department' => 'required|string|max:255',
            'justification' => 'required|string|min:50',
        ], [
            'email.unique' => 'Une demande avec cet email existe déjà.',
            'justification.min' => 'La justification doit contenir au moins 50 caractères.',
        ]);

        $validated['status'] = 'pending';

        AccountRequest::create($validated);
        
        return redirect()->route('account.request.sent')
            ->with('success', 'Votre demande a été envoyée avec succès !');
    }
}
