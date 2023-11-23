@extends('layouts.head')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Promotional Banners /</span> Show all</h4>

    <!-- Testimonials -->
    <div class="row mb-5">
    <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('promotionalbanners.add') }}" class="btn btn-primary">Add Promotional Banners</a>
        </div>
        @foreach($promotionalbanners as $promotionalbanner)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100">
                <img class="card-img-top" src="{{ asset('storage/'.$promotionalbanner->image) }}" alt="Card image cap" />
                <div class="card-body">
                    <h5 class="card-title">Title : {{ $promotionalbanner->title }}</h5>
                    <h6 class="card-subtitle text-muted">Description : {{ $promotionalbanner->description }}</h6><br/>
                    <h6 class="card-subtitle text-muted">Target URL : {{ $promotionalbanner->target_url }}</h6><br/>
                   
                    <a href="{{ route('promotionalbanners.edit', ['id' => $promotionalbanner->id]) }}" class="btn btn-outline-primary">Edit</a>
                    <button class="btn btn-outline-danger" onclick="deletePromotionalBanner({{ $promotionalbanner->id }})">Delete</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /Testimonials -->
</div>
<script>
    function deletePromotionalBanner(promotionalbannerId) {
        if (confirm('Are you sure you want to delete this promotionalbanner?')) {
            fetch(`/promotionalbanners/${promotionalbannerId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Promotional Banner deleted:', data);
                // Reload the page or update UI as needed
                window.location.reload();
            })
            .catch(error => {
                console.error('Error deleting Promotional Banner:', error);
                // Handle error as needed
            });
        }
    }
</script>
@endsection
