@extends('welcome')

@section('content')
    <div class="survey p-5 mx-5 border mt-5">

        <div class="row">
            <div class="col-md-3">
                <div class=" mx-auto p-4 border">
                    <h2 class="fw-bold text-center mb-5">Servey Form</h2>

                    <form action="">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="">Survey Name</label>
                            <input type="text" name="name" class="form-control name">
                        </div>

                        <div class="form-group mb-4">
                            <label for="">Start Date</label>
                            <input type="date" name="start_date" class="form-control start_date">
                        </div>

                        <div class="form-group mb-4">
                            <label for="">End Date</label>
                            <input type="date" name="end_date" class="form-control end_date">
                        </div>

                        <hr>
                        <h5 class="mb-4 text-success">Questions</h5>

                        <div class="form-group mb-4">
                            <label for="">Question Text</label>
                            <input type="text" name="question_text" class="form-control question_text">
                        </div>

                        <div class="form-group mb-4">
                            <label for="">Question Type</label>
                            <select name="question_type" class="form-select type_select question_type">
                                <option value="text">Text</option>
                                <option value="multiple_choice">Multiple Choice</option>
                            </select>
                        </div>

                        <div class="form-group mb-4 d-none choice-container">
                            <label for="">Choices (comma-seperated)</label>
                            <input type="text" name="choices" class="form-control choices">
                        </div>

                        <button type="button" class="btn btn-sm btn-primary save-question">Save Question</button>

                        <hr>
                        <div class="mt-4 mb-1 text-danger" style="font-size: 13px;">When complete click finish
                            survey</div>
                        <button type="button" class="btn btn-success finish-btn">Finish Survey</button>

                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Survey Name</th>
                            <th>Start Data</th>
                            <th>End Date</th>
                            <th>Total Response</th>
                            <th>Preview</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($survey as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->start_date }}</td>
                                <td>{{ $item->end_date }}</td>
                                <td>{{ $item->response ?? '0' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('survey.show', $item->id) }}"><i
                                            class="fa-solid fa-file-pen text-success"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', '.type_select', function() {
                $type = $(this).val();

                if ($type == 'multiple_choice') {
                    $('.choice-container').removeClass('d-none')
                } else {
                    $('.choice-container').addClass('d-none')
                }
            })

            //save question
            $(document).on('click', '.save-question', function() {
                let name = $('.name').val();
                let start_date = $('.start_date').val();
                let end_date = $('.end_date').val();
                let question_text = $('.question_text').val();
                let question_type = $('.question_type').val();
                let choices = $('.choices').val();

                if (!name || !start_date || !end_date) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please Fill Name, Start Date & End Date",
                    });
                } else {
                    $.ajax({
                        url: "{{ route('survey.store') }}",
                        type: "post",
                        data: {
                            name,
                            start_date,
                            end_date,
                            question_text,
                            question_type,
                            choices,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $('.question_text').val('');
                            $(".choices").val('');
                            if (res == 'success') {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Question added successfully",
                                    showConfirmButton: false,
                                    timer: 500
                                });
                            }
                        }
                    })
                }


            })

            //finish survey
            $(document).on('click', '.finish-btn', function() {
                window.location.reload();
            })
        })
    </script>
@endsection
