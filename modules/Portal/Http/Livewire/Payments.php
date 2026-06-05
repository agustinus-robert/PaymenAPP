<?php

namespace Modules\Portal\Http\Livewire;


use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
//use \App\Notifications\GlobalsNotify;
use \App\Mail\MailablePay;
use Modules\Account\Models\User;
use Modules\Account\Models\MembersDonator;
use Modules\Donation\Models\UserInformation;
use Modules\Donation\Models\Donation;
use Modules\Donation\Models\Payment;
use Modules\Donation\Models\PaymentNotification;
use DB;

class Payments extends Component
{


    public $amount = 0;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $notes;
    public $logins;
    public $inputValue;
    public $pays;
    public $date;
    public $invoices = '';
    public $type_payment;
    public $notif;

    public function mount($invoice_id = null, Request $request){
        $this->logins = $request->session()->get('login');
        $this->invoices = $invoice_id;

        if(!empty($invoice_id)){

            $user = UserInformation::where('invoice_num', $invoice_id)->first();
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->address = $user->address;
            $this->notes = $user->note;

            $this->amount = $user->amount;
            $this->date = $user->created_at;

            $payment = Payment::where('invoice_num', $invoice_id)->first();
            $this->pays = round($payment->pay, 0);

            $this->notif = PaymentNotification::where('invoice_num', $invoice_id)->first();
            // if(isset($notif->invoice_num)){
            //     $thi
            // }
        }

        $this->lang = request()->bahasa;
        $session_id = session()->getId();
    }

    #[\Livewire\Attributes\On('call-first')]
    public function donation(){
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        \Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');

        $getOrder = '';
        //$invoice = PaymentNotification::where('invoice_num', $this->pay_id)->first();

        // if(isset($invoice->transaction_status) && $invoice->transaction_status == 'pending'){
        //     $getOrder = rand();
        // } else {
        //     $getOrder = rand();
        // }

        if($this->amount == 0){
            $this->pays = 1000000;
        } else if($this->amount == 1){
            $this->pays = 5000000;
        } else if($this->amount == 2){
            $this->pays = 10000000;
        } else {
            $this->pays = $this->inputValue;
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => ($this->pays + 4000),
            ),
            "callbacks" => array(
                "finish" => "https://tokoecommerce.com/my_custom_finish/?name=Customer01"
            )
        );

        $snapsToken = \Midtrans\Snap::getSnapToken($params);
        $this->dispatch('contentChanged', ['snapToken' => $snapsToken, 'pay_id' => $this->pays]);
    }

    #[\Livewire\Attributes\On('payment')]
    public function save($status, $paymentid, $amount, $order_id, $payment_type, $transaction_status, $transaction_id, $detail, Request $request){
        //$user = User::find($request->session()->get('user_id'));

        if(!empty($this->invoices)){
            $inv = $this->invoices;
        } else {
            $inv = random_int(100, 999).strtotime("now");
        }

        // $emailz = '';

        // if(isset($user->id)){
        //     $memberMeta = MembersDonator::where('user_id', $user->id)->get()->first();
        //     $metaM = MembersDonator::find($memberMeta->id);
        //     $emailz = $user->email_address;
        // } else {
        //     $emailz = $this->email;
        // }

        // $data = [
        //     'firstName' => (isset($user->id) ? $user->name : $this->first_name),
        //     'lastName' => (isset($user->id) ? '' : $this->last_name),
        //     'email' => (isset($user->id) ? $user->email : $this->email),
        //     'phone' => (isset($uset->id)  ? $metaM->getMeta('phone') : $this->phone),
        //     'code' => $inv
        // ];

        // Mail::to($emailz)->send(new MailablePay($data));
        DB::beginTransaction();
        try {

            // if(!empty($this->invoices)){
            //     $userGet = UserInformation::where('invoice_num', $this->invoices)->first();
            //     $userInfo = UserInformation::find($userGet->id);
            // } else {
            //     $userInfo = new UserInformation();
            // }

            // $userInfo->invoice_num = $inv;
            // $userInfo->first_name = (isset($user->id) ? $user->name : $this->first_name);
            // $userInfo->last_name = (isset($user->id) ? '' : $this->last_name);
            // $userInfo->email = (isset($user->id) ? $user->email : $this->email);
            // $userInfo->phone = (isset($uset->id)  ? $metaM->getMeta('phone') : $this->phone);
            // $userInfo->address = $this->address;
            // $userInfo->note = $this->notes;
            // $userInfo->status = 0;
            //     $userInfo->amount = $this->amount;


            // $userInfo->save();

            // if($userInfo->save()){
                // if($status == 'success'){
                //         $userInfos = UserInformation::where('invoice_num', $inv)->first();

                //         $updateUserInfo = UserInformation::find($userInfos->id);
                //         $updateUserInfo->status = 1;
                //         $updateUserInfo->save();
                //     }

                    $getifPayment = Payment::where('invoice_num', $inv)->first();
                    $getifNotif = PaymentNotification::where('invoice_num', $inv)->first();

                    if(isset($getifPayment->invoice_num)){
                        $getPayment = Payment::find($getifPayment->id);

                        $dataUpdatePayment = [
                            'pay' => $this->pays
                        ];

                        $getPayment->update($dataUpdatePayment);
                    } else {
                        $sendPayment = new Payment();
                        $sendPayment->invoice_num =$inv;
                        $sendPayment->pay = $this->pays;
                        $sendPayment->save();
                    }

                    if(isset($getifNotif->invoice_num)){
                        $getNotif = PaymentNotification::find($getifNotif->id);
                        $dataUpdateNotif = [
                            'invoice_num' => $inv,
                            'payment_type' => $payment_type,
                            'transaction_status' => $transaction_status,
                            'transaction_id' => $transaction_id,
                            'notify_detailed_info' => json_encode($detail)
                        ];

                        $getNotif->update($dataUpdateNotif);
                    } else {
                        $notifPayment = new PaymentNotification();
                        $notifPayment->invoice_num = $inv;
                        $notifPayment->payment_type = $payment_type;
                        $notifPayment->transaction_status = $transaction_status;
                        $notifPayment->transaction_id = $transaction_id;
                        $notifPayment->notify_detailed_info = json_encode($detail);
                        $notifPayment->save();
                    }
          //  }

            DB::commit();

            $callbacks = $_SERVER['HTTP_REFERER'];
            return redirect($callbacks);
        }catch(\Exception $e) {
             DB::rollback();
             dd($e);
        }
    }


    public function render()
    {
        return view('portal::livewire.payment');
    }
}
