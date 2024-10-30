<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Topic;
    use App\Models\Post;
    use App\Models\Category;

    class TopicController extends Controller
    {
        public function listAllTopics(){
            $topics = Topic::all();
            return view('topics.listAllTopics', compact('topics'));
        }

        public function listTopicById($id){
            $topic = topic::findOrFail($id);
            return view('topics.listTopicById', compact('topic'));
        }

        public function createTopic()
        {
            return view('topics.createTopic');
        }

        public function store(Request $request){
            $userId = Auth::id();

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'status' => 'required|int',
            'category' => 'required'
        ]);

        $topic = Topic::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'category_id' => $request->category
        ]);

        $topic->post()->create([
            'user_id' => Auth::id(),
            'image' => $request->image,
            // 'image' => $request->file('image')->store('images', 'public')
        ]);

        // $topic = new Topic([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'status' => $request->status,
        //     'category_id' => $request->category
        // ]);

        // $post = new Post([
        //     'image' => $request->image
        // ]);

        
        // $topic->post()->save($post);



        return($topic);

        }

        public function editTopic($id){
            $topic = Topic::findOrFall($id);
            return view('topics.editTopic', compact('topic'));
        }

        public function updateTopic(Request $request, $id){
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
            ]);

            $topic = Topic::findOrFail($id);
            $topic->title = $request->title;
            $topic->description = $request->description;
            $topic->save();

            return redirect()->route('listAllTopics')->with('success', 'Topic updated successfully');
        }

        public function deleteTopic($id){
            $topic = Topic::findOrFail($id);
            $topic->delete();

            return redirect()->route('listAllTopics')->with('success', 'Topic deleted successfully');
        }
    }
