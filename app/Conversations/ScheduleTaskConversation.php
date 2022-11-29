<?php
 
namespace App\Conversations;
 
use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question as BotManQuestion;
use BotMan\BotMan\Messages\Incoming\Answer as BotManAnswer;
use Illuminate\Support\Facades\Artisan;
 
 
class SheduleTaskConversation extends Conversation
{
    /**
     * First question
     */
    public function pertanyaan()
    {
        $question = Question::create("Silahkan pilih kitab yang ingin dicari.")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Task Schedule BIOS')->value('bios'),
                Button::create('Tentang')->value('tentang'),
            ]);
 
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->jawabanNya($answer->getValue());
            }
        });
    }
 
    public function jawabanNya($pertanyaan)
    {
        switch ($pertanyaan) {
            case 'bios':
                Artisan::call('cron:layanan');
                $this->say('Task Scheduling BIOS sudah dijalankan.');
                break;
            case 'tentang':
                $this->say('Ini adalah bot khusus BIOS');
                break;
        }
    }
 
    /**
     * Start the conversation
     */
    public function run()
    {
        $this->pertanyaan();
        // $this->cariLagi();
    }
}
 