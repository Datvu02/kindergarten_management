<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Services\LogService;
use App\Mail\AutoEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Enums\RoleEnum;

class CheckIn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-in';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $paramsSendEmail = [];

    protected $logService;

    public function __construct(LogService $logService)
    {
        parent::__construct();
        $this->logService = $logService;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->logService->info("Start auto send email: ");
            $this->autoEmail();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function autoEmail(){
        try {
            $users = User::where('authority', RoleEnum::PUPIL->value)
                ->whereNotNull('emailParent')
                ->whereNotIn('id', function ($query) {
                    $query->select('user_id')
                        ->from('user_check_in')
                        ->whereDay('created_at', Carbon::yesterday());
                })
                ->select('id', 'emailParent')
                ->get();
            foreach ($users as $user) {
                Mail::send('emails.auto_email', [
                    'user' => $user,
                    'date' => Carbon::yesterday(),
                ], function ($message) use ($user) {
                    $message->to($user->emailParent);
                });
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
