<x-app-layout>
   <h1>ライブ・イベント</h1>
   <div class='events'>
        @foreach($events as $event)
            <div class='event'>
                <a href="/posts/{{ $event->id }}/1">●{{ $event->name }}</a>
                <p>【日程・会場】</p>
                <div>
                    @foreach($event->event_info as $event_info)
                        <p>{{ $event_info->date }}  {{$event_info->venue}}</p>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    <div class='paginate'>
        {{ $events->links() }}
    </div>
</x-app-layout>