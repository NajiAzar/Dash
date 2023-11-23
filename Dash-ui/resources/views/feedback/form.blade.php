<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="feedbackTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="viewTab" data-bs-toggle="tab" href="#viewFeedback" role="tab" aria-controls="viewFeedback" aria-selected="true">View Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="addTab" data-bs-toggle="tab" href="#addFeedback" role="tab" aria-controls="addFeedback" aria-selected="false">Add Feedback</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content mt-2">
               

                    <!-- Add Feedback Tab -->
                    <div class="tab-pane fade" id="addFeedback" role="tabpanel" aria-labelledby="addTab">
                        <!-- Your feedback form goes here -->
                        <form id="feedbackForm" action="{{ route('feedback.store', ['orderNumber' => $order->id]) }}" method="post">
                            @csrf
                            <!-- Add your form fields -->
                            <textarea name="comment" class="form-control" rows="3" placeholder="Enter your feedback"></textarea>
                            <button type="button" class="btn btn-primary mt-3" onclick="submitFeedbackForm()">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this script at the end of your HTML, after including Bootstrap and any other dependencies -->
<script>
    // Function to show the feedback modal
    function showFeedbackModal() {
        $('#feedbackModal').modal('show');
    }

    // Function to handle the form submission
    function submitFeedbackForm() {
        // You can add additional validation here if needed

        // Submit the form using AJAX
        $.ajax({
            url: "{{ route('feedback.store', ['orderNumber' => $order->id]) }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                comment: $('#feedbackForm textarea[name="comment"]').val()
            },
            success: function(response) {
                // Handle success (e.g., close modal, show success message)
                $('#feedbackModal').modal('hide');
                alert('Feedback submitted successfully!');
            },
            error: function(error) {
                // Handle error (e.g., show error message)
                alert('Failed to submit feedback. Please try again.');
            }
        });
    }
</script>
