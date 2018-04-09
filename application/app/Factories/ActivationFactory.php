<?php namespace App\Factories;

use App\Repositories\ActivationRepository;
//use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
//use Mailgun;
use Sendgrid;
// use SendGrid\Email;
// use App\Mail\TestEmail;

    

class ActivationFactory
{
    protected $activationRepo;
    // protected $mailer;
    protected $resendAfter = 5;

    public function __construct(ActivationRepository $activationRepo)//, Mailer $mailer
    {
        $this->activationRepo = $activationRepo;
        // $this->mailer = $mailer;
    }

    public function sendActivationMail($user, $content)
    {
        if (!$this->shouldSend($user)) {
            $activation = $this->activationRepo->getActivation($user);
            $data = [
                'id' => 1050,
                'time' => strtotime($activation->created_at) + 60 * $this->resendAfter - time()
            ];
            return $data;
        }

        $token = $this->activationRepo->createActivation($user);

        //$link = 'http://localhost:3000/register/' . $token;

        $link = 'https://oohyah.com/register/' . $token;

        $data = array(
            'customer' => $user['name'],
            'url' => $link,
            'content' => $content
        );

        // Mail::send('emails.welcome', $data, function($message) use ($user) {
        //     $message->to($user['email']);
        //     $message->subject('Sendgrid Testing');
        // });

        // Mailgun::send('emails.welcome', $data, function($message) use ($user)
        // {
        //     $message->to($user['email'], $user['name'])->subject('Welcome!');
        // });
       
        // return "Successfully Sent Email For Registeration";
        $template = view('emails.welcome', $data)->render();
        $from = new SendGrid\Email("OOHYAH", "support@oohyah.com");
        $subject = "OOHYAH Sign Up";
        $to = new SendGrid\Email($user['name'], $user['email']);
        $content = new SendGrid\Content("text/html", $template);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $apiKey = getenv('SENDGRID_API_KEY');
        
        $sg = new \SendGrid($apiKey);
        $response = $sg->client->mail()->send()->post($mail);
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        
       
        // $this->activationRepo->deleteActivation($token);

        return $activation;
    }

    private function shouldSend($user)
    {
        // echo $user->email; exit;
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * $this->resendAfter < time();
    }
}