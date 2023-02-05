<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\OrderItem;
use App\Models\Transaction;
use Filament\Pages\Actions;
use App\Models\PurchaseItem;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TransactionResource;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Payment Received')
            ->body('Your payment has been received.');
    }
    public function create(bool $another = false): void
    {
        $this->authorizeAccess();
        $this->callHook('beforeValidate');
        $data = $this->form->getState();

        if($data['trading']=='order')
            {
                $order = Order::where('order_number' , '=' , $data['order'])->first();
                $total_paid = Transaction::where('trading_id' , $order->id)
                            ->where('entity_type' , 'customer')
                            ->where('transaction_type' , 'debit')
                            ->sum('transaction_amount');
                
                if(($order->total_price - $total_paid) < $data['transaction_amount'])
                {
                    return ;
                }
            }
        else if($data['trading']=='purchase')
        {
            $purchase = Purchase::where('purchase_number' , '=' , $data['order'])->first();
            $total_paid = Transaction::where('trading_id' , $purchase->id)
                        ->where('entity_type' , 'company')
                        ->where('transaction_type' , 'debit')
                        ->sum('transaction_amount');
            
            if(($purchase->total_purchased_price - $total_paid) < $data['transaction_amount'])
            {
                return ;
            }
        }
        else{}
        
        try {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeCreate($data);

            $this->callHook('beforeCreate');

            $this->record = $this->handleRecordCreation($data);

            $this->form->model($this->record)->saveRelationships();

            $this->callHook('afterCreate');
        } catch (Halt $exception) {
            return;
        }

        $this->getCreatedNotification()?->send();

        if ($another) {
            // Ensure that the form record is anonymized so that relationships aren't loaded.
            $this->form->model($this->record::class);
            $this->record = null;

            $this->fillForm();

            return;
        }

        $this->redirect($this->getRedirectUrl());
    }

    protected function handleRecordCreation(array $data): Model
    {
        // return null;
        // dd($data['trading']);
        if($data['trading']=='order')
        {
            $order = Order::where('order_number' , '=' , $data['order'])->first();

            $data['trading_id'] = $order->id;
            $data['trading_type'] = 'order';
            $data['employee_id'] = auth()->id();
            $data['entity_id'] = $order->customer_code;
            $data['entity_type'] = 'customer';
            $data['transaction_type'] = 'debit';

            static::getModel()::create($data);

            $data['trading_id'] = $order->id;
            $data['trading_type'] = 'order';
            $data['employee_id'] = auth()->id();
            $data['entity_id'] = '1';
            $data['entity_type'] = 'company';
            $data['transaction_type'] = 'credit';

            $total_paid = Transaction::where('trading_id' , $order->id)
                            ->where('entity_type' , 'customer')
                            ->where('transaction_type' , 'debit')
                            ->sum('transaction_amount');

            if($order->total_price == $total_paid)
                {
                    Order::where('id' , $order->id)->update(['order_status' => '3']);
                    
                    $order_items = OrderItem::where('order_id' , '=' , $order->id)->get();
                    foreach ($order_items as $key => $item)
                    {
                        $product = Product::find($item['product_id']);
                        $updated_inventory = $product->inventory - $item['product_quantity'];
                        Product::where('id' , $item['product_id'])
                            ->update(['inventory' => $updated_inventory]);
                    }
                }
            else if($order->total_price < $total_paid)
                Order::where('id' , $order->id)->update(['order_status' => '2']);
            else if($order->total_price > $total_paid)
                Order::where('id' , $order->id)->update(['order_status' => '1']);
            else{}

            return static::getModel()::create($data);
        }

        else if($data['trading']=='purchase')
        {
            $purchase = Purchase::where('purchase_number' , '=' , $data['order'])->first();

            $data['trading_id'] = $purchase->id;
            $data['trading_type'] = 'purchase';
            $data['employee_id'] = auth()->id();
            $data['entity_id'] = $purchase->company_id;
            $data['entity_type'] = 'company';
            $data['transaction_type'] = 'debit';

            static::getModel()::create($data);

            $data['trading_id'] = $purchase->id;
            $data['trading_type'] = 'purchase';
            $data['employee_id'] = auth()->id();
            $data['entity_id'] = $purchase->supplier_id;
            $data['entity_type'] = 'supplier';
            $data['transaction_type'] = 'credit';

            $total_paid = Transaction::where('trading_id' , $purchase->id)
                            ->where('entity_type' , 'company')
                            ->where('transaction_type' , 'debit')
                            ->sum('transaction_amount');

            if($purchase->total_purchased_price == $total_paid)
            {
                Purchase::where('id' , $purchase->id)->update(['purchase_status' => '3']);
                $purchase_items = PurchaseItem::where('purchase_id' , '=' , $purchase->id)->get();

                foreach ($purchase_items as $key => $item)
                {
                    $product = Product::find($item['product_id']);
                    $updated_inventory = $product->inventory + $item['product_quantity'];
                    Product::where('id' , $item['product_id'])
                        ->update(['inventory' => $updated_inventory]);
                }
            }
            else if($purchase->total_purchased_price < $total_paid)
                Purchase::where('id' , $purchase->id)->update(['purchase_status' => '2']);
            else if($purchase->total_purchased_price > $total_paid)
                Purchase::where('id' , $purchase->id)->update(['purchase_status' => '1']);
            else{}

            

            return static::getModel()::create($data);
        }
    }
}
