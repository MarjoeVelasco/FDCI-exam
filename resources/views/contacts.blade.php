@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h1 class="fw-bold">Contacts</h1></div>
                <div class="card-body bg-white py-3">
                    <a href="/contacts/create" id="addContactButton" class="btn btn-success mb-3 float-start">Add Contact</a>
                    <div class="mb-3 float-end">
                        <form>
                            <input type="text" placeholder="Search" class="form-control" id="searchInput">
                        </form>
                    </div>
                    <table class="table table-hover" id="contactsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add a Modal for Adding/Editing Contacts -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Fetch and display contacts on load
        fetchContacts();

        function fetchContacts() {
            $.ajax({
                type: "GET",
                url: "/api/contacts",
                success: function(data) {
                    let rows = '';
                    $.each(data, function(key, post) {
                        rows += `
                            <tr>
                                <td>${post.id}</td>
                                <td>${post.title}</td>
                                <td>${post.body}</td>
                                <td>
                                    <button data-id="${post.id}" class="btn btn-primary btn-sm edit-post">Edit</button>
                                    <button data-id="${post.id}" class="btn btn-danger btn-sm delete-post">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#postList').html(rows);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    
    });
</script>
@endsection
