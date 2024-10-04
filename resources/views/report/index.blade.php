@extends('Layout.master')
@section('main_section')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="card-title fs-4 fw-semibold">Monthly Report</h3>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-3">
                            <label for="month" class="form-label">Month</label>
                            <input type="month" name="month" class="form-control w-75" id="month"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="col-3 pt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="salaries"
                                    id="salaries" checked>
                                <label class="form-check-label" for="salaries">
                                    Including Salaries
                                </label>
                            </div>
                        </div>
                        <div class="col-3 pt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="allowance"
                                    id="allowance" checked>
                                <label class="form-check-label" for="allowance">
                                    Including Allowance
                                </label>
                            </div>
                        </div>
                        <div class="col-3 pt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="expense" id="expense"
                                    checked>
                                <label class="form-check-label" for="expense">
                                    Including Expense
                                </label>
                            </div>
                        </div>
                        <div class="col-12 pt-4">
                            <button class="btn btn-primary" type="button" id="generate-report">Generate Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="report-box">

        </div>
    </div>
    <script>
        $(document).ready(function() {
            let today = new Date();
            let year = today.getFullYear();
            let month = (today.getMonth() + 1).toString().padStart(2, '0');
            let currentMonth = `${year}-${month}`;
            $('#month').val(currentMonth);
            $('#month').attr('max', currentMonth);

            $('#generate-report').click(function() {
                let button = $(this);
                button.html(`
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            &nbsp;&nbsp;...
        `);

                let month = $('#month').val();
                let allowance = $('#allowance').is(':checked');
                let expense = $('#expense').is(':checked');
                let salaries = $('#salaries').is(':checked');

                $.ajax({
                    type: "GET",
                    url: "{{ route('generate.report') }}",
                    data: {
                        month,
                        allowance,
                        expense,
                        salaries
                    },
                    success: function(response) {
                        button.html(`Generate Report`); 
                        $('#report-box').html(response);
                    },
                    error: function() {
                        button.html(`Generate Report`);
                        alert('An error occurred while generating the report.');
                    }
                });
            });
        });
    </script>
@endsection
