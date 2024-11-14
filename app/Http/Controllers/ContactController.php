<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function all(Request $request,$userId)
    {
        return response()->json($this->contactService->getAllContacts($request, $userId));
    }

    public function store(ContactRequest $request)
    {
        $contact = $this->contactService->createContact($request->validated());
        return redirect('/home')->with('status', 'Contact created successfully!');
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $this->contactService->updateContact($contact, $request->validated());
        return redirect()->route('home')->with('status', 'Contact updated successfully!');
    }

    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);
        return response()->json(['message' => 'Contact deleted successfully']);
    }

    public function create()
    {
        return view('create');
    }

    public function edit(Contact $contact)
    {
        return view('edit', compact('contact'));
    }
}