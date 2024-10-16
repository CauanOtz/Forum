<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Topic;
    use App\Models\Post;

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
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
            ]);

            $topic = new Topic;
            $topic->title = $request->title;
            $topic->description = $request->description;
            $topic-save();

            return redirect()->route('listAllTopics')->with('success', 'Topic created successfully');

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
