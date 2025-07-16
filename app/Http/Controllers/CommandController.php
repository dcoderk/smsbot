<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandController extends Controller
{
    /**
     * Show the form for testing a command.
     */
    public function showTestForm()
    {
        return view('commands.sms');
    }

    public function store(Request $request)
    {
        $manager = auth()->user();
        
        // Make trigger unique only for the manager's company
        $request->validate([
            'trigger' => 'required|string|unique:commands,trigger,NULL,id,company_id,' . $manager->company_id,
            'description' => 'nullable|string|max:255',
            'text_reply' => 'required|string',
            'url_reply' => 'required|url',
        ]);
    
    // ... the rest of your validation ...
    DB::transaction(function () use ($request, $manager) {
        $companyId = ($manager->role === 'Manager') ? $manager->company_id : null;

        // Create the command and assign the company ID
        $command = Command::create([
            'trigger' => $request->trigger,
            'description' => $request->description,
            'company_id' => $companyId, // <-- Assign company ID here
        ]);

        // Create replies (this part remains the same)
        $command->replies()->create([
            'type' => 'text', 'content' => $request->text_reply, 'company_id' => $companyId,
        ]);
        $command->replies()->create([
            'type' => 'url', 'content' => $request->url_reply, 'company_id' => $companyId,
        ]);
    });

    return redirect()->route('commands.create')->with('success', 'Command created successfully!');
    }

    /**
     * Find a command and return its replies to the view.
     */
    public function executeTestCommand(Request $request)
    {
        // 1. Validate the inputs
        $validated = $request->validate([
            'telephone' => 'required|string|exists:users,telephone',
            'trigger' => 'required|string',
        ]);

        $staffUser = User::where('telephone', $validated['telephone'])->firstOrFail();

        // -- CORRECTED COMMAND SEARCH LOGIC --

        // 2. First, look for a command specific to the staff's company
        $command = Command::where('trigger', $validated['trigger'])
                        ->where('company_id', $staffUser->company_id)
                        ->first();

        // 3. If no company-specific command is found, look for a global one (where company_id is null)
        if (!$command) {
            $command = Command::where('trigger', 'LIKE', $validated['trigger'])
                            ->whereNull('company_id')
                            ->first();
        }

        // 4. NOW, check if a command was found at all. If not, the command truly doesn't exist.
        if (!$command) {
            return view('commands.sms', ['replies' => collect(), 'message' => 'Error: Command not found.']);
        }
        
        // -- END OF CORRECTION --


        // 5. Find the replies for the command that was found
        $replies = $command->replies()
            ->where('company_id', $staffUser->company_id)
            ->get();

        if ($replies->isEmpty()) {
            $replies = $command->replies()
                ->whereNull('company_id')
                ->whereNull('user_id')
                ->get();
        }

        // 6. Personalize replies by replacing placeholders
        $processedReplies = $replies->map(function ($reply) use ($staffUser) {
            $placeholders = ['{name}', '{title}'];
            $values = [$staffUser->name, $staffUser->title];
            
            $reply->content = str_replace($placeholders, $values, $reply->content);
            return $reply;
        });

        return view('commands.sms', [
            'replies' => $processedReplies,
            'message' => $processedReplies->isEmpty() ? 'Error: No replies found for this command.' : null
        ]);
    }
}
