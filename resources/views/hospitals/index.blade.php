@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hospitals</h1>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addHospitalModal">Add Hospital</button>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hospitals as $hospital)
                <tr>
                    <td>{{ $hospital->id }}</td>
                    <td>{{ $hospital->name }}</td>
                    <td>{{ $hospital->address }}</td>
                    <td>{{ $hospital->email }}</td>
                    <td>{{ $hospital->phone }}</td>
                    <td>
                        <button class="btn btn-primary edit-hospital" data-id="{{ $hospital->id }}" data-name="{{ $hospital->name }}" data-address="{{ $hospital->address }}" data-email="{{ $hospital->email }}" data-phone="{{ $hospital->phone }}">Edit</button>
                        <button class="btn btn-danger delete-hospital" data-id="{{ $hospital->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Hospital Modal -->
<div class="modal fade" id="addHospitalModal" tabindex="-1" role="dialog" aria-labelledby="addHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHospitalModalLabel">Add Hospital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addHospitalForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Hospital Modal -->
<div class="modal fade" id="editHospitalModal" tabindex="-1" role="dialog" aria-labelledby="editHospitalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editHospitalModalLabel">Edit Hospital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editHospitalForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_hospital_id" name="id">
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_address">Address</label>
                        <input type="text" class="form-control" id="edit_address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Phone</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('submit', '#addHospitalForm', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('hospitals.store') }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response.success);
                location.reload();
            }
        });
    });

    $(document).on('click', '.delete-hospital', function() {
        var id = $(this).data('id');
        if(confirm('Are you sure you want to delete this hospital?')) {
            $.ajax({
                url: '/hospitals/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.success);
                    location.reload();
                }
            });
        }
    });

    $(document).on('click', '.edit-hospital', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    var address = $(this).data('address');
    var email = $(this).data('email');
    var phone = $(this).data('phone');

    $('#edit_hospital_id').val(id);
    $('#edit_name').val(name);
    $('#edit_address').val(address);
    $('#edit_email').val(email);
    $('#edit_phone').val(phone);

    $('#editHospitalModal').modal('show');
});

$(document).on('submit', '#editHospitalForm', function(e) {
    e.preventDefault();
    var id = $('#edit_hospital_id').val();
    $.ajax({
        url: '/hospitals/' + id,
        type: 'PUT',
        data: $(this).serialize(),
        success: function(response) {
            alert(response.success);
            location.reload();
        }
    });
});


</script>
@endsection
