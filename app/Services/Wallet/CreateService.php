<?php

namespace App\Services\Wallet;

use App\Models\V1\TalentWallet;

class CreateService {

    public $id;
    public $wallet;

    public function __construct($id, $wallet){
        $this->id = $id;
        $this->wallet = $wallet;
    }

    public function run()
    {
        $wal = new TalentWallet();

        $wal->talent_id = $this->id;
        $wal->wallet_no = $this->wallet;
        $wal->current_bal = 0;
        $wal->previous_bal = 0;
        $wal->status = 'active';
        $wal->save();

        return $wal;
    }

}
