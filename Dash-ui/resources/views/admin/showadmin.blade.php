@extends('layouts.head')
@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.showform') }}" class="btn btn-primary">Add Admin</a>
        </div>
       

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List of Admins</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.edit', ['id' => $admin->id]) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <form action="{{ route('admin.destroy', ['id' => $admin->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this admin?')">
        <i class="bx bx-trash me-1"></i> Delete
    </button>
</form>
                                    <!-- <a class="dropdown-item" href="#" onclick="confirmDelete('{{ route('admin.destroy', ['id' => $admin->id]) }}');"><i class="bx bx-trash me-1"></i> Delete</a> -->
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
      

    </div>
    <div class="d-flex justify-content-center">
    {{ $admins->links('custom-pagination') }}
</div>
    <!-- / Content -->

    <!-- Footer -->
    <footer class="content-footer footer bg-footer-theme">
        <!-- Footer content -->
    </footer>
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
</div>

<!-- Content wrapper -->
@endsection
