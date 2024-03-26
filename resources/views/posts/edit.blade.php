<x-app-layout>
    <div class='posts_container'>
        <h1>投稿編集ページ</h1>
        <form class='comment_form' action="/posts/{{ $post->id }}" method="POST">
            @csrf
            @method('PUT')
            <x-input-label for="body" :value="__('【内容】')" />
            <textarea id="body" class='script_comment' name="body">{{ old('body', $post->body) }}</textarea>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
            <p>※ 1000字以内で入力してください</p>

            <div class='submit_container'>
                <button type='submit' class='submit_button'>保存する</button>
            </div>
        </form>
    </div>
</x-app-layout>