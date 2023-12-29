@extends('welcome')

@section('content')
    <div class="w-50 mt-5 p-5 mx-auto border">
        <h2 class="text-center mb-5">{{ $survey->name }} Survey</h2>

        <form action="{{ route('responses.store') }}" method="post">
            @csrf

            <input type="hidden" name="survey_id" value="{{ $survey->id }}">
            @foreach ($survey->questions as $question)
                <div class="form-group mb-4">
                    <label for="">{{ $question->question_text }}</label> <br>

                    @if ($question->question_type == 'text')
                        <input type="text" name="responses[{{ $question->id }}]" class="form-control">
                    @elseif ($question->question_type == 'multiple_choice')
                        @foreach (explode(',', $question->choices) as $choice)
                            <label>
                                <input type="checkbox" name="responses[{{ $question->id }}][]" value="{{ $choice }}"
                                    class="">
                                {{ $choice }}
                            </label>
                            <br>
                        @endforeach
                    @endif
                </div>
            @endforeach

            <button class="btn btn-success">Submit</button>
        </form>
    </div>
@endsection
