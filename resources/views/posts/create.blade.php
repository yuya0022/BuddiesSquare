<x-app-layout>
    <h1>{{$event->name}}　{{ $category->name }} の投稿作成</h1>
    <form action="/posts" method="POST">
        @csrf
        <div>
            <x-input-label for="body" :value="__('【内容】')" />
            <textarea id="body" name="body">{{ old('body') }}</textarea>
            <p>※ 1000字以内で入力してください</p>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>
        <div>
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <input type="submit" value="投稿する"/>
        </div>
    </form>
</x-app-layout>