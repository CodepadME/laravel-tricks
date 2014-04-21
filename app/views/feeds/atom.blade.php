{{ '<?xml version="1.0" encoding="utf-8"?>' }}

<feed xmlns="http://www.w3.org/2005/Atom">
    <title>{{ trans('feeds.title') }}</title>
    <subtitle>{{ trans('feeds.sub_title') }}</subtitle>
    <link href="{{ Request::url() }}" rel="self" />
    <updated>{{ Carbon\Carbon::now()->toATOMString() }}</updated>
    {{ trans('feeds.author') }}
    <id>tag:{{ Request::getHost() }},{{ date('Y') }}:/feed.atom</id>

@foreach($tricks as $trick)
    <entry>
        <title>{{ $trick->title }}</title>
        <link href="{{ route('tricks.show', $trick->slug) }}" />
        <id>{{ $trick->tagUri }}</id>
        <updated>{{ $trick->updated_at->toATOMString() }}</updated>
        <summary>{{ $trick->description }}</summary>
    </entry>
@endforeach
</feed>
