<x-app-layout>
    <div class='posts_container'>
        <h1>{{ $event->name }}</h1>
        <h2 class='post_category_name'>{{ $category->name }} の投稿作成</h2>
        
        <form class='comment_form' action="/posts" method="POST">
            @csrf
            <x-input-label for="body" :value="__('【投稿内容】')" />
            <textarea id="body" name="body" class='script_comment'>{{ old('body') }}</textarea>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
            <p>※ 1000字以内で入力してください</p>
            <div>
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="category_id" value="{{ $category->id }}">
            </div>
            <div class='submit_container'>
                <button type='submit' class='submit_button'>投稿する</button>
            </div>
        </form>
    </div>
</x-app-layout>