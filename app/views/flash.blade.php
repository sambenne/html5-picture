@foreach ($_messages as $_message)
    <div class="alert{{{ (isset($_message[1])) ? ' alert-' . $_message[1] : '' }}}">
        {{ ((isset($_message[1]) && isset($_message_titles[$_message[1]]) && count($_message_titles[$_message[1]]) > 0 && (($_r = mt_rand(0, count($_message_titles[$_message[1]]) - 1)) || true)) ? '<strong>' . $_message_titles[$_message[1]][$_r] . '</strong> ' : '') . $_message[0] }}
    </div>
@endforeach

@if ($errors->has())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif