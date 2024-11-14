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
                             <input type="text" placeholder="Search" class="form-control" id="searchInput">
                    </div>

                    <table class="table table-hover" id="contactsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="contactsTableBody">
                        </tbody>
                    </table>
                    <!-- pagination -->
                    <div id="paginationControls" class="text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteContactModal" tabindex="-1" aria-labelledby="deleteContactModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteContactModalLabel">Delete Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to DELETE?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    var userId = @json(Auth::id());
    var currentPage = 1;  
    var searchQuery = ''; 

    fetchContacts(userId, currentPage, searchQuery);

    // Handle search input change
    $('#searchInput').on('input', function() {
        searchQuery = $(this).val(); // Get the search query
        currentPage = 1; // Reset to the first page when searching
        fetchContacts(userId, currentPage, searchQuery); // Fetch contacts with search term
    });


    function fetchContacts(userId, page, query) {
        $.ajax({
            type: "GET",
            url: `/api/contacts/${userId}?page=${page}&search=${query}`, 
            success: function(data) {
                let contacts = data.original.data;
                let pagination = data.original;

                let rows = '';
                // Loop through contacts and populate the table
                $.each(contacts, function(key, contact) {
                    rows += `
                        <tr>
                            <td>${contact.name}</td>
                            <td>${contact.company}</td>
                            <td>${contact.phone}</td>
                            <td>${contact.email}</td>
                            <td>
                                <a href="/contacts/${contact.id}/edit" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm deleteContactBtn" data-id="${contact.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $('#contactsTableBody').html(rows);

                // Update pagination controls
                updatePagination(pagination);
            },
            error: function(error) {
                console.log(error);
                alert("There was an error fetching contacts.");
            }
        });
    }

    // Function to update pagination controls
    function updatePagination(pagination) {
        let paginationHtml = '';

        // Check if previous page exists
        if (pagination.prev_page_url) {
            paginationHtml += `<button class="btn btn-secondary btn-sm" id="prevPageBtn">Previous</button>`;
        }
        // Display current page number
        paginationHtml += `<span class="btn btn-light btn-sm">${pagination.current_page}</span>`;

        // Check if next page exists
        if (pagination.next_page_url) {
            paginationHtml += `<button class="btn btn-secondary btn-sm" id="nextPageBtn">Next</button>`;
        }

        $('#paginationControls').html(paginationHtml);

        $('#paginationControls button').on('click', function() {
            if ($(this).attr('id') === 'prevPageBtn') {
                currentPage = pagination.current_page - 1;
            } else if ($(this).attr('id') === 'nextPageBtn') {
                currentPage = pagination.current_page + 1;
            }
            fetchContacts(userId, currentPage, searchQuery);
        });
    }

    // delete popup
    $(document).on('click', '.deleteContactBtn', function() {
        var contactId = $(this).data('id');
        $('#confirmDeleteBtn').data('id', contactId);
        $('#deleteContactModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function() {
        var contactId = $(this).data('id');
        
        // delete
        $.ajax({
            type: "DELETE",
            url: `/api/contacts/${contactId}`,
            success: function(response) {
                $('#deleteContactModal').modal('hide');
                $('#searchInput').val('');
                searchQuery = ''; 
                fetchContacts(userId, 1, searchQuery);
            },
            error: function(error) {
                console.log(error);
                alert("There was an error deleting the contact.");
            }
        });
    });
});
</script>
@endsection
