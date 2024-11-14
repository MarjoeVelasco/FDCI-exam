<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Http\Request; 

class ContactService
{
    public function getAllContacts(Request $request, $userId)
    {
        $search = $request->query('search', ''); 

        $contacts = Contact::where('user_id', $userId)
        ->where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('company', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        })
        ->paginate(5); 
        return response()->json($contacts);
    }

    public function createContact(array $data)
    {
        $data['user_id'] = auth()->id();
        return Contact::create($data);
    }

    public function updateContact(Contact $contact, array $data)
    {
        return $contact->update($data);
    }

    public function deleteContact(Contact $contact)
    {
        return $contact->delete();
    }
}
