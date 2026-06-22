<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: 'Times New Roman', serif;
        font-size: {{ $fontSize ?? 12 }}pt;
        line-height: 1.8;
        margin: 3cm 4cm 3cm 4cm;
        color: #000;
    }
    .header-date {
        text-align: right;
        margin-bottom: 1em;
    }
    .header-hal {
        text-align: left;
        font-weight: bold;
        margin-bottom: 1em;
    }
    .line-left {
        margin: 0 0 .2em;
        text-align: left;
        white-space: pre-wrap;
    }
    .line-justify {
        margin: 0 0 .2em;
        text-align: justify;
        white-space: pre-wrap;
    }
    .line-empty {
        margin: 0 0 .5em;
    }
</style>
</head>
<body>
    @if($showDate)
    <div class="header-date">{{ $today }}</div>
    @endif

    @if($showHal)
    <div class="header-hal">Hal: Lamaran Pekerjaan - {{ $position }}</div>
    @endif

    @foreach(explode("\n", $content) as $line)
        @php $trimmed = trim($line); @endphp
        @if($trimmed === '')
            <p class="line-empty">&nbsp;</p>
        @elseif(mb_strlen($trimmed) > 60)
            <p class="line-justify">{{ $line }}</p>
        @else
            <p class="line-left">{{ $line }}</p>
        @endif
    @endforeach
</body>
</html>