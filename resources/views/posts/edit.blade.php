<x-app-layout>
    <h1>投稿編集ページ</h1>
    <form action="/posts/{{ $post->id }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <x-input-label for="body" :value="__('【内容】')" />
            <textarea id="body" name="body">{{ old('body', $post->body) }}</textarea>
            <p>※ 1000字以内で入力してください</p>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>
        <div>
            <a href="/posts/{{ $post->id }}">キャンセル</a>
            <input type="submit" value="保存する"/>
        </div>
    </form>
    
</x-app-layout>