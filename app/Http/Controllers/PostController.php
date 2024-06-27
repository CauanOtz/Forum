<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Topic;

    class TopicController extends Controller
    {
        public function listAllPosts(){
            $posts = Topic::all();
            return view('posts.listAllPosts', compact('posts'));
        }

        public function listTopicById($id){
            $post = post::findOrFail($id);
            return view('posts.listPostById', compact('post'));
        }

        public function createPost()
        {
            return view('posts.createPost');
        }

        public function store(Request $request){
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
            ]);

            $post = new post;
            $post->title = $request->title;
            $post->description = $request->description;
            $post-save();

            return redirect()->route('listAllPosts')->with('success', 'Post created successfully');

        }

        public function editPost($id){
            $post = post::findOrFall($id);
            return view('posts.editpost', compact('post'));
        }

        public function updatePost(Request $request, $id){
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
            ]);

            $post = post::findOrFail($id);
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();

            return redirect()->route('listAllPosts')->with('success', 'Post updated successfully');
        }

        public function deletePost($id){
            $post = post::findOrFail($id);
            $post->delete();

            return redirect()->route('listAllposts')->with('success', 'Post deleted successfully');
        }
    }
