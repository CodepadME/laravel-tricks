{{ '<?xml version="1.0" encoding="utf-8"?>' }}

<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title>{{ trans('feeds.title') }}</title>
        <link>{{ trans('feeds.link') }}</link>
        <atom:link href="{{ Request::url() }}" rel="self"></atom:link>
        <description>{{ trans('feeds.sub_title') }}</description>
        <language>en-us</language>
        <lastBuildDate>{{ Carbon\Carbon::now()->toRSSString() }}</lastBuildDate>

@foreach($tricks as $trick)
        <item>
            <title>{{ $trick->title }}</title>
            <link>{{ route('tricks.show', $trick->slug) }}</link>
            <guid>{{ route('tricks.show', $trick->slug) }}</guid>
            <description><![CDATA[{{ $trick->description}}]]></description>
            <pubDate>{{ $trick->created_at->toRSSString() }}</pubDate>
        </item>
@endforeach
    </channel>
</rss>
