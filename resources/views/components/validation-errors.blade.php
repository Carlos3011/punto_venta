@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg relative mb-6 animate-fadeIn" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif