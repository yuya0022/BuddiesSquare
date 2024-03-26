<x-app-layout>
    <div class='event_container'> 
        <div>
            @foreach($events as $event)
                <a href="/posts/{{ $event->id }}/1">
                    <div class='event'>
                        <p class='event_name'>{{ $event->name }}</p>
                        <p>【日程・会場】</p>
                        <div>
                            @foreach($event->event_info as $event_info)
                                <p>{{ $event_info->date }}　　{{$event_info->venue}}</p>
                            @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $events->links() }}
        </div>
    </div>
</x-app-layout>