<?php

namespace vultrui\Http\Controllers;

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use vultrui\User;

class MyAccount extends Controller
{
    /**
     *  \Notification methods.
     */

    /*public function markAsRead( Request $request, $id )
    {

        return Auth::user()->notifications->find($id)->markAsRead();
    }*/

    /*public function markNotificationsAsRead( Request $request )
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success_message', 'Marked as read');
    }*/

    /*public function deleteNotifications()
    {

        Auth::user()->notifications()->delete();

        return redirect()->back()->with('success_message', 'Notifications deleted');
    }*/

    public function index()
    {

        // $threads = Thread::getAllLatest()->simplePaginate(5);
        $threads = Thread::forUser(Auth::user()->id)->latest('updated_at')->simplePaginate(5);
        $user = User::findOrFail(Auth::id());
        $users = User::where('id', '!=', Auth::id())->get();
        $user_activities = Activity::where('causer_id', '=', Auth::user()->id)->paginate(15);

        return view('dash.account', compact('user', 'threads', 'users', 'user_activities'));
    }

    public function showThread($id)
    {
        $thread = Thread::findOrFail($id);

        if (!$thread->hasParticipant(\Auth::id())) {
            abort(404);
        }

        $userId = Auth::id();
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();
        $thread->markAsRead($userId);

        return view('partials.messages', compact('thread', 'users', 'thread_m'));
    }

    public function updateThread(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);

        $thread->activateAllParticipants();
        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(),
            'body'      => $request->message,
        ]);

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(),
        ]);

        $participant->last_read = new Carbon();
        $participant->save();

        // Recipients
        if ($request->has('recipients')) {
            $thread->addParticipant($request->recipients);
        }

        return redirect()->route('account.thread.show', $id);
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function deleteThread(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);

        if ($thread->creator() !== null && $thread->creator()->is(auth()->user()) || auth()->user()->hasRole('super-admin')) {
            $thread->delete();

            return redirect()->route('account.index', '#messages')->with('success', 'Thread deleted!');
        }
    }

    public function storeThread(Request $request)
    {
        $thread = Thread::create([
            'subject' => $request->subject,
        ]);
        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(),
            'body'      => $request->message,
        ]);
        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(),
            'last_read' => new Carbon(),
        ]);
        // Recipients
        if ($request->has('recipients')) {
            $thread->addParticipant($request->recipients);
        }

        return redirect()->route('account.index', '#messages')->with('success', 'Thread created!');
    }
}
