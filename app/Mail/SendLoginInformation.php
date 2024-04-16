<?php
// このメールクラスでは、アプリケーションの URL、登録メールアドレス、パスワードをコンストラクタで受け取り、メールのビューに渡します。
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendLoginInformation extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $email;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($url, $email, $password)
    {
        $this->url = $url;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     *、件名・送信者・返信先に関する情報を設定できます
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Login Information',
        );
    }

    /**
     * Get the message content definition.
     * 本文の設定を行います
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.login-information',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     * 添付ファイルについて定義します
     */
    public function attachments(): array
    {
        return [];
    }
}
