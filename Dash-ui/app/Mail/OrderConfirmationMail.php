<?php

// app/Mail/OrderConfirmationMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $order;
    public $cartItems;

    public function __construct(Customer $customer, Order $order, $cartItems)
    {
        $this->customer = $customer;
        $this->order = $order;
        $this->cartItems = $cartItems;
    }

    public function build()
    {
        return $this->view('emails.order-confirmation')
            ->subject('Order Confirmation');
    }
}

