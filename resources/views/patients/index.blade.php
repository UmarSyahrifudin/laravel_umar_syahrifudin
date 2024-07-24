@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Patients</h1>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addPatientModal">Add Patient</button>
    <div class="form-group mt-3">
        <label for="hospital-filter">Filter by Hospital</label>
        <select id="hospital-filter" class="form-control">
            <option value="">Select Hospital</option>
            @foreach($hospitals as $hospital)
                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
            @endforeach
        </select>
    </div>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Hospital</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="patient-list">
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->address }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->hospital->name }}</td>
                    <td>
                        <button class="btn btn-primary edit-patient" data-id="{{ $patient->id }}" data-name="{{ $patient->name }}" data-address="{{ $patient->address }}" data-phone="{{ $patient->phone }}" data-hospital_id="{{ $patient->hospital_id }}">Edit</button>
                        <button class="btn btn-danger delete-patient" data-id="{{ $patient->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Patient Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Add Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addPatientForm">
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
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="hospital_id">Hospital</label>
                        <select class="form-control" id="hospital_id" name="hospital_id" required>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>                
            </div>
        </div>
    </div>
</div>

<!-- Edit Patient Modal -->
<div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPatientForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_patient_id" name="id">
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_address">Address</label>
                        <input type="text" class="form-control" id="edit_address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone">Phone</label>
                        <input type="text" class="form-control" id="edit_phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_hospital_id">Hospital</label>
                        <select class="form-control" id="edit_hospital_id" name="hospital_id" required>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('submit', '#addPatientForm', function(e) {
    e.preventDefault();
    $.ajax({
        url: '{{ route('patients.store') }}',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                alert(response.success);
                $('#addPatientModal').modal('hide');
                location.reload();
            } else {
                alert('Something went wrong!');
            }
        },
        error: function(xhr) {
            // Tampilkan kesalahan jika ada
            alert('Error: ' + xhr.statusText);
        }
    });
});


    $(document).on('click', '.delete-patient', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this patient?')) {
            $.ajax({
                url: '/patients/' + id,
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

    $('#hospital-filter').on('change', function() {
        var hospitalId = $(this).val();
        $.ajax({
            url: '/patients-by-hospital/' + hospitalId,
            type: 'GET',
            success: function(response) {
                var rows = '';
                response.patients.forEach(function(patient) {
                    rows += `
                        <tr>
                            <td>${patient.id}</td>
                            <td>${patient.name}</td>
                            <td>${patient.address}</td>
                            <td>${patient.phone}</td>
                            <td>${patient.hospital.name}</td>
                            <td>
                                <button class="btn btn-danger delete-patient" data-id="${patient.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $('#patient-list').html(rows);
            }
        });
    });

    $(document).on('click', '.edit-patient', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    var address = $(this).data('address');
    var phone = $(this).data('phone');
    var hospital_id = $(this).data('hospital_id');

    $('#edit_patient_id').val(id);
    $('#edit_name').val(name);
    $('#edit_address').val(address);
    $('#edit_phone').val(phone);
    $('#edit_hospital_id').val(hospital_id);

    $('#editPatientModal').modal('show');
});

$(document).on('submit', '#editPatientForm', function(e) {
    e.preventDefault();
    var id = $('#edit_patient_id').val();
    $.ajax({
        url: '/patients/' + id,
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
