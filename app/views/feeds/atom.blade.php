{{ '<?xml version="1.0" encoding="utf-8"?>' }}

<feed xmlns="http://www.w3.org/2005/Atom">
    <title>Laravel-Tricks</title>
    <subtitle>Laravel tricks is a website that aggregates useful tips and tricks for Laravel PHP framework</subtitle>
    <link href="{{ Request::url() }}" rel="self" />
    <updated>{{ Carbon\Carbon::now()->toATOMString() }}</updated>
    <author>
        <name>Maks Surguy</name>
        <uri>http://twitter.com/msurguy</uri>
    </author>
    <author>
        <name>Stidges</name>
        <uri>http://twitter.com/stidges</uri>
    </author>
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
