<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Command</title>
    <style>
        body { font-family: sans-serif; margin: 2em; }
        .form-group { margin-bottom: 1em; }
        label { display: block; margin-bottom: .25em; }
        input { width: 400px; padding: 0.5em; }
        .results { margin-top: 2em; padding: 1em; border: 1px solid #ccc; background-color: #f9f9f9; min-height: 50px; }
        .reply { margin-bottom: 0.5em; }
    </style>
</head>
<body>
    <h1>Test a Command</h1>
    <form action="{{ route('commands.test.execute') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="telephone">Staff Telephone Number:</label>
            <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}" required>
            @error('telephone') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="trigger">Staff Command:</label>
            <input type="text" id="trigger" name="trigger" value="{{ old('trigger') }}" placeholder="e.g., Admission" required>
            @error('trigger') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <button type="submit">Execute</button>
    </form>

    <div class="results">
        <strong>Response:</strong>
        <br><br>
        @if (isset($replies) && $replies->isNotEmpty())
            @foreach ($replies as $reply)
                @if ($reply->type === 'text')
                    <div class="reply">{{ $reply->content }}</div>
                @elseif ($reply->type === 'url')
                    <div class="reply"><a href="http://{{ $reply->content }}" target="_blank">{{ $reply->content }}</a></div>
                @endif
            @endforeach
        @elseif (isset($message))
            <div style="color:red">{{ $message }}</div>
        @else
             <div>Awaiting command...</div>
        @endif
    </div>
</body>
</html>